<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SemnasController;
use App\Http\Controllers\ExcelUploadController;
use App\Livewire\PenilaianComponent;



//Halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login.post');


Route::middleware(['auth'])->group(function(){
    Route::get('/scan', [SemnasController::class, 'ShowScanPage'])->name('scan');
   

    Route::get('/upload-excel', [ExcelUploadController::class, 'index'])->name('upload.excel.form');
    Route::post('/upload-excel', [ExcelUploadController::class, 'ImportExcel'])->name('upload.excel.submit');
    Route::post('/absen', [PresensiController::class, 'absen'])->name('absen.submit');
    Route::post('/manual-absen',[PresensiController::class,'manualAbsen'])->name('manual-absen.post');
    Route::post('/send-bulk-email',[SemnasController::class,'SendBulkEmail'])->name('send-bulk-email.post');
    Route::get('/delete-all-participants',[SemnasController::class,'deleteAllParticipant'])->name('delete-all-participants.delete');

    // Route::get('/peserta', [PresensiController::class, 'listPeserta'])->name('peserta.list');
    // Route::get('/qrcode/{id}', [PresensiController::class, 'generateQRCode'])->name('qrcode.generate');
});


