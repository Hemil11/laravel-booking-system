<?php

/*
| Permission middleware (alias: `permission`):
|   Route::middleware(['auth', 'permission:manage_services'])->group(...);
| Comma-separated names require ALL permissions:
|   Route::middleware(['auth', 'permission:manage_users,manage_bookings'])->group(...);
| See also: ServiceController / StaffController `__construct` for `only([...])` examples.
*/

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoicePaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::resource('services', ServiceController::class);
Route::resource('staff', StaffController::class);

Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::get('admin', AdminDashboardController::class)->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('bookings/available-slots', [BookingController::class, 'availableSlots'])->name('bookings.available-slots');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('invoices/{invoice}/mock-payment', [InvoicePaymentController::class, 'process'])->name('invoices.mock-payment');
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'show']);
});
