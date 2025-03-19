<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user', function (Request $request) {
        $users = User::all();
        if (Auth::guard('sanctum')->check()) {
            dd($users);
        } else {
            dd('no admin');
        }
    });
});
Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login',  'login')->name('login');
    Route::post('/forget-password',  'forgetPassword')->name('forget-password');
    Route::post('/reset-password',  'resetPassword')->name('password.reset');
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('verify/email',  [UserController::class, 'verifyEmail'])->name('verify.email');
    Route::post('verify/otp',  [UserController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('logout',  [UserController::class, 'logout'])->name('logout');
});
