<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $users = App\Models\User::all();
    if (Auth::guard('admin')->check()) {
        dd($users);
    } else {
        dd('no admin');
    }
});
