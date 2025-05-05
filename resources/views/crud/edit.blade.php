@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header bg-secondary d-flex justify-content-between">
                <h3>Edit User</h3>
                <a href="{{ route('test.index') }}" class="btn btn-primary">Users</a>
            </div>
            <div class="card-body">
                <form action="{{ route('test.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email   ', $user->email) }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="age">Age Range</label>
                        <Select class="form-control" name="age" id="age">
                            <option value="">Select Age</option>
                            <option value="18-25" {{ old('age', $user->age) == '18-25' ? 'selected' : '' }}>18 - 25
                            </option>
                            <option value="26-40" {{ old('age', $user->age) == '26-40' ? 'selected' : '' }}>26 - 40
                            </option>
                            <option value="41-60" {{ old('age', $user->age) == '41-60' ? 'selected' : '' }}>41 - 60
                            </option>
                            <option value="61+" {{ old('age', $user->age) == '61+' ? 'selected' : '' }}>61+</option>
                        </Select>
                        @error('age')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <Select class="form-control" name="gender" id="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                            </option>
                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other
                            </option>
                        </Select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="profile" class="form-label">Upload Profile</label>
                            <input class="form-control" type="file" id="profile" name="profile" onchange="previewImage(this)">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                        @error('profile')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        @if ($user->profile)
                            <div class="mt-2 mb-3">
                                <label>Current Profile Image:</label>
                                <div>
                                    <img id="imagePreview" src="{{ $user->profile ? asset('storage/' . $user->profile) : asset('path/to/default-image.jpg') }}" 
                                    alt="Profile Preview" style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            console.log(preview);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush