<?php

namespace App\Jobs;

use App\Events\RowCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;
use App\Models\Row;
use Illuminate\Support\Facades\Redis;

class ProcessChunks implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    protected string $key;

    public function __construct(array $data, string $key)
    {
        $this->data = $data;
        $this->key = $key;
    }

    public function handle()
    {
        $errors = [];

        foreach ($this->data as $row) {
            $validator = Validator::make($row, [
                'id' => 'required|integer|min:1',
                'name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'date' => 'required|date_format:d.m.Y',
            ]);

            if ($validator->fails()) {
                $error = "{$row['row_number']} - " . implode(', ', $validator->errors()->all()) . "\n";
                file_put_contents(storage_path('app/result.txt'), $error, FILE_APPEND);

                Redis::incr($this->key);

                continue;
            }

            Row::where('excel_id', $row['id'])->firstOr(function () use ($row) {
                Row::create([
                    'excel_id' => $row['id'],
                    'name' => $row['name'],
                    'date' => \Carbon\Carbon::createFromFormat('d.m.Y', $row['date']),
                ]);

                Row::created(function ($row) {
                    broadcast(new RowCreated($row));
                });
            });

            Redis::incr($this->key);
        }

        if (!empty($errors)) {
            $errorLog = '';
            foreach ($errors as $error) {
                $errorLog .= "{$error['row']} - " . implode(', ', $error['errors']) . "\n";
            }
            file_put_contents(storage_path('app/result.txt'), $errorLog, FILE_APPEND);
        }
    }
}
