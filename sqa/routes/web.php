<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AssignmentController;

Route::get('/', function () {
    return view('welcome');
});

//admin dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

//admin profile
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::put('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::post('/admin/profile/photo', [AdminProfileController::class, 'uploadPhoto'])->name('admin.profile.photo');
});

//admin register user
Route::get('/admin/register', function () {
    return view('admin.register');
})->middleware(['auth', 'role:admin'])->name('admin.register');


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

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/enrollment', function () {
        return view('module.enroll');
    })->name('staff.enrollment');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/assignments', [AssignmentController::class, 'assignments'])
    ->name('assignments.assignments');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/assignments/course/{courseId}', [AssignmentController::class, 'showCourseAssignments'])
    ->name('assignments.course');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/assignments/create/{courseId}', [AssignmentController::class, 'create'])
    ->name('assignments.create');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::post('/assignments', [AssignmentController::class, 'store'])
    ->name('assignments.store');
});


Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/assignments/{assignment_id}/edit', [AssignmentController::class, 'edit'])
    ->name('assignments.edit');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::put('/assignments/{assignment_id}', [AssignmentController::class, 'update'])
    ->name('assignments.update');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::delete('/assignments/{assignment_id}', [AssignmentController::class, 'destroy'])
    ->name('assignments.destroy');
});






require __DIR__ . '/auth.php';
