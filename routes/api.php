<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/user', function (Request $request) {

    return $request->user();
});

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::post('/forget-password', [UserController::class, 'forgetPassword'])->name('forget-password');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.reset');
