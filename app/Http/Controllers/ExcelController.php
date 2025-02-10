<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Jobs\ProcessExcel;
use App\Models\Row;
use Illuminate\Support\Facades\Redis;


class ExcelController extends Controller
{
    public function index()
    {
        $rows = Row::orderBy('date')->get()->groupBy('date');

        return view('rows.index', compact('rows'));
    }

    public function showUploadForm()
    {
        return view('upload');
    }

    public function upload(UploadFileRequest $request)
    {
        dispatch(new ProcessExcel($request->file->store('temp')));

        return redirect()->back()->with('success', 'Файл успешно загружен и обрабатывается.');
    }

    public function progress($key)
    {
        $progress = Redis::get($key);

        return response()->json(['progress' => $progress]);
    }
}
