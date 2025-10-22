<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SemnasController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ExcelUploadController;
use App\Http\Controllers\EmailController; // ✅ Tambahin controller Email
use App\Livewire\PenilaianComponent;

// Halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    // Halaman scan
    Route::get('/scan', [SemnasController::class, 'ShowScanPage'])->name('scan');

    // Upload Excel
    Route::get('/upload-excel', [ExcelUploadController::class, 'index'])->name('upload.excel.form');
    Route::post('/upload-excel', [ExcelUploadController::class, 'ImportExcel'])->name('upload.excel.submit');

    // ✅ Tambahin route untuk kirim QR Code ke email
    Route::post('/send-qrcode-email', [EmailController::class, 'sendQRCodeEmail'])->name('send.qrcode.email');

    // Presensi dan peserta
    Route::post('/absen', [PresensiController::class, 'absen'])->name('absen.submit');
    Route::get('/peserta', [PresensiController::class, 'listPeserta'])->name('peserta.list');
    Route::get('/qrcode/{id}', [PresensiController::class, 'generateQRCode'])->name('qrcode.generate');
    Route::post('/manual-absen', [PresensiController::class, 'manualAbsen'])->name('manual-absen.post');

    // Fitur tambahan
    Route::post('/send-bulk-email', [SemnasController::class, 'SendBulkEmail'])->name('send-bulk-email.post');
    Route::get('/delete-all-participants', [SemnasController::class, 'deleteAllParticipant'])->name('delete-all-participants.delete');
});
