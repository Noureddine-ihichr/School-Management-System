<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\StudentAuth;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\AbsenceController;
//use App\Http\Controllers\TimetableController;





Route::get('/', function () {
    return view('welcome');
});


//routes for authentication

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//Middleware dashboard routes

//admin dashboard
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Admin management routes
    Route::get('/admin-management', [AdminController::class, 'index'])->name('admin.management');
    Route::get('/admin-management/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin-management', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin-management/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin-management/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin-management/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::delete('/classes/{class}/teachers/{teacher}', [ClassController::class, 'removeTeacher'])->name('classes.teachers.remove');
    Route::delete('/classes/{class}/students/{student}', [ClassController::class, 'removeStudent'])->name('classes.students.remove');
});

//student dashboard
Route::middleware('student')->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard.student');
});

// Teacher Dashboard
Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'dashboard'])->name('dashboard.teacher');
    Route::get('/teacher/classes', [TeacherController::class, 'classesOverview'])->name('teacher.classes');
    Route::get('/teacher/classes/{class}', [ClassController::class, 'teacherClassDetails'])->name('teacher.classes.details'); // Keep only this
    Route::get('/teacher/profile', function () {
        return view('teacher-section.profile.profile');
    })->name('teacher.profile');
});




//

//routes for sections 


// Teacher Routes
Route::resource('teachers', TeacherController::class);

// Student Routes
Route::resource('students', StudentController::class);

// Classe Routes
Route::resource('classes', ClassController::class);

// Subject Routes
Route::resource('subjects', SubjectController::class);
// After your subjects resource route
Route::delete('subjects/{subject}/teachers/{teacher}', [SubjectController::class, 'removeTeacher'])
    ->name('subjects.teachers.remove');

// Add these routes for profile management
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profile', function () {
        return view('admin-section.profile.profile');
    })->name('profile.admin');
    
    Route::get('/super-admin/profile', function () {
        return view('admin.profile');
    })->name('profile.super_admin');
});

Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])
    ->name('profile.update.picture');





















// //Student Dashboard Routes
// Route::get('/students', [StudentController::class, 'index'])->name('students.index');
// Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
// Route::post('/students', [StudentController::class, 'store'])->name('students.store');
// Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
// Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
// Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
// Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

// Add this route if it doesn't exist
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
