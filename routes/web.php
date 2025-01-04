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
use App\Http\Controllers\ClassController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\TimetableController;

// Teacher Routes
Route::resource('teachers', TeacherController::class);

// Student Routes
Route::resource('students', StudentController::class);

// Class Routes
Route::resource('classes', ClassController::class);

// Absence Routes
Route::resource('absences', AbsenceController::class);

// Timetable Routes
Route::resource('timetables', TimetableController::class);


Route::get('/', function () {
    return view('welcome');
});


//routes for authentication

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//admin dashboard routes

Route::middleware(AdminAuth::class)->group(function () {
    Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard.admin');
    
});


//admin management
Route::get('/admin-management', [AdminController::class, 'index'])->name('admin.management');
Route::get('/admin-management/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin-management', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin-management/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin-management/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin-management/{id}', [AdminController::class, 'destroy'])->name('admin.delete');


// Teacher Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'dashboard'])->name('dashboard.teacher');
    Route::get('/teacher/profile', [TeacherDashboardController::class, 'profile'])->name('teacher.profile');
    Route::get('/teacher/classes', [TeacherDashboardController::class, 'classes'])->name('teacher.classes');
    Route::get('/teacher/schedule', [TeacherDashboardController::class, 'schedule'])->name('teacher.schedule');
});
// Route::middleware(StudentAuth::class)->group(function () {
//     Route::get('/student/dashboard', [StudentAuthController::class, 'dashboard'])->name('dashboard.student');
// });