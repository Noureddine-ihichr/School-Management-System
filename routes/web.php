<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController; // Add ScheduleController
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Dashboard
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin management routes
    Route::get('/admin-management', [AdminController::class, 'index'])->name('admin.management');
    Route::get('/admin-management/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin-management', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin-management/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin-management/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin-management/{id}', [AdminController::class, 'destroy'])->name('admin.delete');

    // Class-Teacher and Class-Student relationships
    Route::delete('/classes/{class}/teachers/{teacher}', [ClassController::class, 'removeTeacher'])->name('classes.teachers.remove');
    Route::delete('/classes/{class}/students/{student}', [ClassController::class, 'removeStudent'])->name('classes.students.remove');
});

// Student Dashboard
Route::middleware('student')->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard.student');
});

// Teacher Dashboard
Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'dashboard'])->name('dashboard.teacher');
    Route::get('/teacher/classes', [TeacherController::class, 'classesOverview'])->name('teacher.classes');
    Route::get('/teacher/classes/{class}', [ClassController::class, 'teacherClassDetails'])->name('teacher.classes.details');
    Route::get('/teacher/profile', function () {
        return view('teacher-section.profile.profile');
    })->name('teacher.profile');
});

// Teacher, Student, Class, and Subject Management
Route::resource('teachers', TeacherController::class);
Route::resource('students', StudentController::class);
Route::resource('classes', ClassController::class);
Route::resource('subjects', SubjectController::class);

// Subject-Teacher relationship management
Route::delete('subjects/{subject}/teachers/{teacher}', [SubjectController::class, 'removeTeacher'])->name('subjects.teachers.remove');

// Profile management
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profile', function () {
        return view('admin-section.profile.profile');
    })->name('profile.admin');

    Route::get('/super-admin/profile', function () {
        return view('admin.profile');
    })->name('profile.super_admin');
});

Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update.picture');

// Schedule Management Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('schedules', ScheduleController::class);
});

Route::get('/schedules/{schedule}/pdf', [ScheduleController::class, 'downloadPdf'])->name('schedules.pdf');
