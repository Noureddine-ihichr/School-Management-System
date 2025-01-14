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
    Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard.admin');
    
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
Route::middleware('teacher')->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'dashboard'])->name('dashboard.teacher');
    Route::get('/teacher/profile', [TeacherDashboardController::class, 'profile'])->name('teacher.profile');
    Route::get('/teacher/classes', [TeacherDashboardController::class, 'classes'])->name('teacher.classes');
    Route::get('/teacher/schedule', [TeacherDashboardController::class, 'schedule'])->name('teacher.schedule');
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





















// //Student Dashboard Routes
// Route::get('/students', [StudentController::class, 'index'])->name('students.index');
// Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
// Route::post('/students', [StudentController::class, 'store'])->name('students.store');
// Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
// Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
// Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
// Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
