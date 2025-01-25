<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    use ApiResponse;
    public function index()
    {
        //
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ]);
        if ($validator->fails()) {
            $this->setMeta('errors', $validator->errors());
            return $this->setResponse();
        }
        $user = $this->userService->store($request);
        $user->assignRole('user');
        $this->setMeta('message', 'User created successfully');
        $this->setData('user', $user);
        return $this->setResponse();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
        ]);
        if ($validator->fails()) {
            $this->setMeta('errors', $validator->errors());
            return $this->setResponse();
        }
        $user = $this->userService->login($request);
        if (!$user) {
            $this->setMeta('errors', 'Invalid email or password');
            return $this->setResponse();
        }
        $this->setMeta('message', 'User logged in successfully');
        $this->setData('token', $user->createToken('token')->plainTextToken);
        $this->setData('user', $user);
        return $this->setResponse();
    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
        ]);
        if ($validator->fails()) {
            $this->setMeta('errors', $validator->errors());
            return $this->setResponse();
        }
        $status = $this->userService->forgetPassword($request);
        $status === Password::RESET_LINK_SENT ? $this->setMeta('status', $status) : $this->setMeta('status', $status);
        $this->setMeta('message', 'Password reset link sent successfully');
        return $this->setResponse();
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'token' => 'required',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ]);
        if ($validator->fails()) {
            $this->setMeta('errors', $validator->errors());
            return $this->setResponse();
        }
        $status = $this->userService->resetPassword($request);
        $status === Password::PASSWORD_RESET ? $this->setMeta('status', $status) : $this->setMeta('status', $status);
        $this->setMeta('message', 'Password reset successfully');
        return $this->setResponse();
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
        ]);
        if ($validator->fails()) {
            $this->setMeta('errors', $validator->errors());
            return $this->setResponse();
        }
        $user = $this->userService->verifyEmail($request);
        if (!$user) {
            $this->setMeta('errors', 'User not found');
            return $this->setResponse();
        }
        $this->setMeta('message', 'Email verified successfully');
        $this->setData('user', $user);
        return $this->setResponse();
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'otp' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $this->setMeta('errors', $validator->errors());
            return $this->setResponse();
        }
        try {
            $result = $this->userService->verifyOtp($request);

            if (!$result['success']) {
                $this->setMeta('errors', $result['message']);
                return $this->setResponse();
            }

            $this->setMeta('message', 'OTP verified successfully');
            $this->setData('user', $result['user']);
            return $this->setResponse();
        } catch (\Exception $e) {
            $this->setMeta('errors', 'An error occurred while verifying OTP');
            return $this->setResponse();
        }
    }
}
