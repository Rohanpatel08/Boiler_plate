<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $users = User::all();

    foreach ($users as $user) {
        Log::info($user->getRoleNames());
    }
    Log::info('Date and Time');
    logger(now());
    dd('no admin');
});

Route::get('/test', function () {
    return view('test');
});
