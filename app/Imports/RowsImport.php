<?php

namespace App\Imports;

use App\Jobs\ProcessChunks;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RowsImport implements ToModel, WithChunkReading, WithStartRow, WithHeadingRow
{
    use RemembersRowNumber;

    const ROW_COUNT = 1000;

    protected array $data;
    private string $uniqueKey;

    public function __construct()
    {
        $this->uniqueKey = uniqid();
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $row['row_number'] = $this->getRowNumber();
        $this->data[] = $row;

        if(count($this->data) == self::ROW_COUNT) {
            \Log::error($this->uniqueKey);
            dispatch(new ProcessChunks($this->data, $this->uniqueKey))->onQueue('chunks_process');
            $this->data = [];
        }

    }
}
