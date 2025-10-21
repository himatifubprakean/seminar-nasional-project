<?php

use App\Http\Controllers\ExpoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FormController;
use App\Livewire\PenilaianComponent;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ExcelUploadController;




//Halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login.post');


Route::middleware(['auth'])->group(function(){
    Route::get('/scan', [ExpoController::class, 'scan'])->name('scan');
    // Route::get('/upload', [PresensiController::class, 'uploadForm'])->name('upload.form');
    // Route::post('/import', [PresensiController::class, 'importExcel'])->name('import.excel');
    Route::post('/absen', [PresensiController::class, 'absen'])->name('absen.submit');
    Route::get('/peserta', [PresensiController::class, 'listPeserta'])->name('peserta.list');
    Route::get('/qrcode/{id}', [PresensiController::class, 'generateQRCode'])->name('qrcode.generate');
    
    Route::get('/upload-excel', [ExcelUploadController::class, 'index'])->name('upload.excel');
    Route::post('/upload-excel', [ExcelUploadController::class, 'ImportExcel'])->name('upload.excel.post');
});
