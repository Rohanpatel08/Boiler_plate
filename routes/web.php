<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $users = App\Models\User::all();
    if (Auth::guard('admin')->check()) {
        dd($users);
    } else {
        Log::info('Date and Time');
        logger(now());
        dd('no admin');
    }
});
