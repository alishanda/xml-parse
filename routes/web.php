<?php

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [ExcelController::class, 'showUploadForm'])->name('dashboard');
    Route::post('/upload', [ExcelController::class, 'upload'])->name('upload.submit');

    Route::get('/rows', [ExcelController::class, 'index'])->name('rows.index');
    Route::get('/progress/{key}', [ExcelController::class, 'progress'])->name('progress');
});

require __DIR__.'/auth.php';
