<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserService
{
    use ApiResponse;
    public function store($request)
    {
        return User::create($request->all());
    }

    public function login($request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return false;
        }
        return $user;
    }

    public function forgetPassword($request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $this->setMeta('errors', 'User not found');
            return $this->setResponse();
        }
        $status = Password::sendResetLink($request->only('email'));
        return $status;
    }

    public function resetPassword($request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $this->setMeta('errors', 'User not found');
            return $this->setResponse();
        }
        $status = Password::reset($request->all(), function ($user, $password) use ($request) {
            $user->password = Hash::make($password);
            $user->save();
        });
        return $status;
    }
}
