<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|confirmed|min:8',
            'age' => 'required',
            'gender' => 'required',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Your name must be at least :min characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Passwords do not match.',
            'password.min' => 'Password must be at least :min characters.',
            'age.required' => 'Age is required.',
            'gender.required' => 'Gender is required.',
            'profile.required' => 'Profile picture is required.',
            'profile.image' => 'Please upload a valid image file.',
            'profile.mimes' => 'Profile picture must be in JPEG, PNG, JPG, or GIF format.',
            'profile.max' => 'Profile picture size should not exceed 2MB.',
        ];
    }
}
