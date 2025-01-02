<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\StudentAuth;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\AdminController;


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



// Route::middleware(StudentAuth::class)->group(function () {
//     Route::get('/student/dashboard', [StudentAuthController::class, 'dashboard'])->name('dashboard.student');
// });