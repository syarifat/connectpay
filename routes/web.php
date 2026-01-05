<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Halaman Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkWA'])->name('password.wa');
Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('pelanggan', AdminController::class);
    Route::get('/pelanggan/pembayaran/{id}', [AdminController::class, 'pembayaran'])->name('admin.pembayaran');
    Route::post('/pelanggan/pembayaran', [AdminController::class, 'storePembayaran'])->name('admin.pembayaran.store');
    Route::resource('pakets', PaketController::class);
    Route::get('/broadcast', [AdminController::class, 'broadcast'])->name('admin.broadcast');
    Route::post('/broadcast/send', [AdminController::class, 'sendBroadcast'])->name('admin.broadcast.send');
});

// Khusus Pelanggan
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'index']);
    Route::get('/change-password', [AuthController::class, 'editPassword'])->name('password.edit');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

Route::get('/cron/send-reminder', [AdminController::class, 'sendAutoReminder']);