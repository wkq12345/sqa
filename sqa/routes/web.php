<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\StudentProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Student Dashboard
Route::get('/student/dashboard', function () {
    return view('student.dashboard');
})->middleware(['auth', 'role:student'])->name('student.dashboard');

//Student Profile
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/profile', [StudentProfileController::class, 'index'])->name('student.profile');
    Route::put('/student/profile', [StudentProfileController::class, 'update'])->name('student.profile.update');
    Route::post('/student/profile/photo', [StudentProfileController::class, 'uploadPhoto'])->name('student.profile.photo');
});

// Staff Dashboard
Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->middleware(['auth', 'role:staff'])->name('staff.dashboard');

// Staff Profile
Route::get('/staff/profile', function () {
    return view('staff.profile');
})->middleware(['auth', 'role:staff'])->name('staff.profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/staff/profile', [StaffProfileController::class, 'index'])->name('staff.profile');
    Route::put('/staff/profile', [StaffProfileController::class, 'update'])->name('staff.profile.update');
    Route::post('/staff/profile/photo', [StaffProfileController::class, 'uploadPhoto'])->name('staff.profile.photo');
});


require __DIR__ . '/auth.php';
