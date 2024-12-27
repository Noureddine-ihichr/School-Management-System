<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\StudentAuth;
use App\Http\Controllers\StudentAuthController;

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


Route::middleware(StudentAuth::class)->group(function () {
    Route::get('/student/dashboard', [StudentAuthController::class, 'dashboard'])->name('dashboard.student');
});