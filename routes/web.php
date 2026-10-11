<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::resource('/', LandingController::class);
Route::get('/dashboard', [PesananController::class, 'index'])->name('dashboard.index');

Route::middleware(['auth', 'verified', 'CheckRole:user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard/{dashboard}', [PesananController::class, 'create']);
});

Route::middleware(['auth', 'verified', 'CheckRole:admin'])->group(function () {
    Route::resource('/admin', AdminDashboardController::class);
});

require __DIR__.'/auth.php';
