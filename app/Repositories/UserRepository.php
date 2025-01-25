<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserRepository
{
    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
