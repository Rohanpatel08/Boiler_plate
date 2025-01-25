<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user', function (Request $request) {
        // dd($request->user());
        $users = User::all();
        // dd(Auth::guard());
        if (Auth::guard('web')->check()) {
            dd($users);
        } else {
            dd('no admin');
        }
    });
});

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('verify/email', [UserController::class, 'verifyEmail'])->name('verify.email');
Route::post('verify/otp', [UserController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/forget-password', [UserController::class, 'forgetPassword'])->name('forget-password');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.reset');
