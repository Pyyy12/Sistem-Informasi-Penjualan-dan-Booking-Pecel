<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DailySaleController;
use Illuminate\Support\Facades\Route;

// Customer Front-facing Routes
Route::get('/', [BookingController::class, 'index'])->name('home');
Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success/{code}', [BookingController::class, 'success'])->name('booking.success');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/sales', [DailySaleController::class, 'index'])->name('sales.index');
    Route::post('/sales', [DailySaleController::class, 'store'])->name('sales.store');
});