<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Show forms
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Handle form submissions
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//forgot password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

//reset password
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset-password');

//email verification
Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->name('verify-email');

//confirm password
Route::get('/confirm-password', function () {
    return view('auth.confirm-password');
})->name('confirm-password');
