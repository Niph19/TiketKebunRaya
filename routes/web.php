<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware(['auth', 'verified', 'CheckRole:user'])->group(function () {
    
});

Route::middleware(['auth', 'verified', 'CheckRole:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
});

require __DIR__.'/auth.php';
