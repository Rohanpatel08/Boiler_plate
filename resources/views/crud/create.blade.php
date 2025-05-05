@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header bg-secondary d-flex justify-content-between">
                <h3>Create User</h3>
                <a href="{{ route('test.index') }}" class="btn btn-primary">Users</a>
            </div>
            <div class="card-body">
                <form action="{{ route('test.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">    
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="age">Age Range</label>
                        <Select class="form-control" name="age" id="age">
                            <option value="">Select Age</option>
                            <option value="18-25">18 - 25</option>
                            <option value="26-40">26 - 40</option>
                            <option value="41-60">41 - 60</option>
                            <option value="61+">61+</option>
                        </Select>
                        @error('age')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <Select class="form-control" name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </Select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="profile" class="form-label">Upload Profile</label>
                            <input class="form-control" type="file" id="profile" name="profile">
                        </div>
                        @error('profile')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input class="form-control" type="password" name="password" id="password">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-group">
                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="toggleCPassword">
                                    <i class="fa-solid fa-eye-slash" id="toggleCIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Create User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        console.log('test');
        
        const passwordField = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        
        // Toggle password visibility
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye'); // Change to eye-slash icon
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash'); // Change back to eye icon
        }

    });
    document.getElementById('toggleCPassword').addEventListener('click', function () {
        const cPasswordField = document.getElementById('password_confirmation');
        const cIcon = document.getElementById('toggleCIcon');

        // Toggle confirm password visibility
        if (cPasswordField.type === 'password') {
            cPasswordField.type = 'text';
            cIcon.classList.remove('fa-eye-slash');
            cIcon.classList.add('fa-eye'); // Change to eye-slash icon
        } else {
            cPasswordField.type = 'password';
            cIcon.classList.remove('fa-eye');
            cIcon.classList.add('fa-eye-slash'); // Change back to eye icon
        }
    });
</script>
@endpush