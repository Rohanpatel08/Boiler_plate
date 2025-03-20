<?php

use App\DataTables\UsersDataTable;
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
    dd('no admin '. now());
});

Route::get('/test', function (UsersDataTable $dataTable) {
    return $dataTable->render('test');
});
