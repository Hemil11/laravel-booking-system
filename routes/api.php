<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvailableSlotController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\InvoicePaymentController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('api.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.login');
});

Route::get('services', [ServiceController::class, 'index'])->name('api.services.index');

Route::get('available-slots', AvailableSlotController::class)->name('api.available-slots');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('bookings', [BookingController::class, 'store'])->name('api.bookings.store');
    Route::post('invoices/{invoice}/mock-payment', [InvoicePaymentController::class, 'process'])
        ->middleware('throttle:payment')
        ->name('api.invoices.mock-payment');
});
