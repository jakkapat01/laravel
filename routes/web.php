<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
// Users resource
Route::resource('users', \App\Http\Controllers\UserController::class);

// Login routes
Route::view('login', 'users.login')->name('users.login');
Route::post('login', [\App\Http\Controllers\UserController::class, 'login'])->name('users.login.post');

// Logout
Route::get('logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');
Route::resource('courses', \App\Http\Controllers\CourseController::class);
Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('main');
Route::resource('regs', \App\Http\Controllers\RegController::class);