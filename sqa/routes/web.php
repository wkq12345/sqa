<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CourseController;

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


//Module Enrollment Routes
Route::middleware(['auth', 'role:staff'])->group(function () {

    Route::get('/staff/enrollment', [ModuleController::class, 'index'])
        ->name('staff.enrollment');

    Route::get('/staff/enrollment/{course}', [ModuleController::class, 'show'])
        ->name('module.show');

    Route::get('/staff/enrollment/{course}/add', [ModuleController::class, 'create'])
        ->name('module.add');

    Route::post('/staff/enrollment/store', [ModuleController::class, 'store'])
        ->name('module.store');

    Route::put('/staff/enrollment/update/{module}', [ModuleController::class, 'update'])
        ->name('module.update');

    Route::delete('/staff/enrollment/delete/{module}', [ModuleController::class, 'destroy'])
        ->name('module.destroy');
});

Route::middleware(['auth', 'role:staff'])->group(function () {

    Route::get('/assignment', [AssignmentController::class, 'index'])
        ->name('assignment.assignments');

    Route::get('/assignment/course/{course_id}', [AssignmentController::class, 'list'])
        ->name('assignment.list');

    Route::get('/assignment/create/{course_id}', [AssignmentController::class, 'create'])
        ->name('assignment.create');

    Route::post('/assignment', [AssignmentController::class, 'store'])
        ->name('assignment.store');

    Route::get('/assignment/{assignment_id}/edit', [AssignmentController::class, 'edit'])
        ->name('assignment.edit');

    Route::put('/assignment/{assignment_id}', [AssignmentController::class, 'update'])
        ->name('assignment.update');

    Route::delete('/assignment/{assignment_id}', [AssignmentController::class, 'destroy'])
        ->name('assignment.destroy');


});
//Course Routes
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::resource('courses', CourseController::class);
});

Route::resource('courses',CourseController::class);



require __DIR__ . '/auth.php';
