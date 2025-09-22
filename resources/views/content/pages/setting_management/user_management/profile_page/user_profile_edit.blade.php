@extends('layouts/contentNavbarLayout')

@section('title', 'Edit User Profile')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">✏️ Edit User Profile</h4>
            <button class="btn btn-outline-secondary  d-flex align-items-center gap-1" onclick="history.back()">
                <i class="bi bi-arrow-left"></i> Back
            </button>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('user_profile_update') }}" method="POST" enctype="multipart/form-data"
                    id="profileUpdateForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <input type="text" name="username" id="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role (only for super admin) -->
                        @if ($user->user_type == 1)
                            <div class="col-md-6">
                                <label for="role_id" class="form-label fw-bold">User Role</label>
                                <select name="role_id" id="role_id"
                                    class="form-select @error('role_id') is-invalid @enderror" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone 2 -->
                        <div class="col-md-6">
                            <label for="phone_2" class="form-label fw-bold">Alternate Phone</label>
                            <input type="text" name="phone_2" id="phone_2"
                                class="form-control @error('phone_2') is-invalid @enderror"
                                value="{{ old('phone_2', $user->phone_2) }}">
                            @error('phone_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Profile Picture -->
                        <div class="col-md-6">
                            <label for="profile_picture" class="form-label fw-bold">Profile Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture"
                                class="form-control @error('profile_picture') is-invalid @enderror">
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user->profile_picture)
                                <div class="mt-2">
                                    <img src="{{ asset('uploads/profile/' . $user->profile_picture) }}"
                                        class="rounded-circle border" width="80" height="80" alt="Profile Picture">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
