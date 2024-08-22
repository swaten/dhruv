<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileHandlingModule;


Route::get('/', function () {
    return view('homepage');
});


Route::controller(FileHandlingModule::class)->group(function () {
  // Route::get('/', 'show');
    // Route::get('/', 'show');
    Route::post('/upload_file', 'upload_excel_file')->name('upload_file');
    Route::get('/getData', 'getData')->name('getData');
    Route::get('/details/{id}', 'details')->name('details');
    Route::get('/download_zip', 'download_zip')->name('download_zip');
});
