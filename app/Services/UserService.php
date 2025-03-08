<?php

namespace App\Services;

use App\Jobs\SendOtpJob;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserService
{
    use ApiResponse;
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function store($request)
    {
        return User::create($request->all());
    }

    public function login($request)
    {
        $user = $this->userRepository->getUserByEmail($request->email);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return false;
        }
        return $user;
    }

    public function forgetPassword($request)
    {
        $user = $this->userRepository->getUserByEmail($request->email);
        if (!$user) {
            $this->setMeta('errors', 'User not found');
            return $this->setResponse();
        }
        $status = Password::sendResetLink($request->only('email'));
        return $status;
    }

    public function resetPassword($request)
    {
        $user = $this->userRepository->getUserByEmail($request->email);
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

    public function verifyEmail($request)
    {
        $user = $this->userRepository->getUserByEmail($request->email);
        if (!$user) {
            return false;
        }
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        dispatch(new SendOtpJob($user));
        $user->save();
        return $user;
    }

    public function verifyOtp($request)
    {
        $user = $this->userRepository->getUserByEmail($request->email);
        if (!$user) {
            $this->setMeta('errors', 'User not found');
            return [
                'success' => false,
                'message' => 'User not found',
            ];
        }
        if ($user->otp != $request->otp) {
            $this->setMeta('errors', 'Invalid OTP');
            return [
                'success' => false,
                'message' => 'Invalid OTP',
            ];
        }
        if ($user->otp_expires_at < now()) {
            $this->setMeta('errors', 'OTP is expired');
            return [
                'success' => false,
                'message' => 'OTP is expired',
            ];
        }
        try {
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->email_verified_at = now();
            $user->save();

            return [
                'success' => true,
                'message' => 'OTP verified successfully',
                'user' => $user
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to update user information'
            ];
        }
    }

    public function logout($request)
    {
        $user = $this->userRepository->getUserByEmail($request->email);
        if (!$user) {
            $this->setMeta('errors', 'User not found');
            return $this->setResponse();
        }
        $user->tokens()->delete();
        $this->setMeta('message', 'User logged out successfully');
        return $this->setResponse();
    }
}
