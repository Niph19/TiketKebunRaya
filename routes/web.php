<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\JenisTiketController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'CheckRole:user'])->group(function () {
    Route::get('/dashboard', [PesananController::class, 'index'])->name('dashboard.index');
    Route::get('/pesan/{jenisTiket}', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{pesanan}/bukti', [PesananController::class, 'uploadBukti'])->name('pesanan.bukti');
    Route::get('/pesanan/{pesanan}/e-tiket', [PesananController::class, 'downloadTicket'])->name('pesanan.tiket');
});

Route::middleware(['auth', 'verified', 'CheckRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
    Route::get('/pesanan/{pesanan}/bukti', [AdminDashboardController::class, 'showProof'])->name('pesanan.bukti');
    Route::post('/pesanan/{pesanan}/approve', [AdminDashboardController::class, 'approve'])->name('pesanan.approve');
    Route::post('/pesanan/{pesanan}/reject', [AdminDashboardController::class, 'reject'])->name('pesanan.reject');
    Route::resource('/jenis-tiket', JenisTiketController::class)
        ->except(['show', 'destroy'])
        ->names('jenis-tiket')
        ->parameters(['jenis-tiket' => 'jenisTiket']);
});

require __DIR__.'/auth.php';
