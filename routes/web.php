<?php

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('services', ServiceController::class);
Route::resource('staff', StaffController::class);
