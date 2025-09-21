@extends('layouts/contentNavbarLayout')

@section('title', 'User Profile')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>User Profile</h3>
        <a href="{{ route('user_profile_edit') }}" class="btn btn-warning" id="editProfileBtn">
            <i class="fas fa-edit me-1"></i> Edit Profile
        </a>
    </div>
    <div class="container-fluid">
        <!-- Profile Card -->
        <div class="card shadow-sm">
            <div class="card-body row align-items-center">
                <!-- Profile Image -->
                <div class="col-md-3 text-center">
                    <img src="{{ asset('uploads/images/default.jpg') }}" class="rounded-circle img-fluid shadow"
                        alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <!-- User Info -->
                <div class="col-md-9">
                    <h4 class="mb-3">{{ $user->name }}</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2"><strong>Username:</strong> {{ $user->username }}</div>
                        <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $user->email }}</div>
                        <div class="col-md-6 mb-2"><strong>Phone:</strong> {{ $user->phone ?? 'Not Provided' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection

@section('js')
    <script>
        // Edit Profile Confirmation
        document.getElementById('editProfileBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Do you want to edit your profile?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, edit it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('user_profile_edit') }}";
                }
            });
        });

        // Update Password Confirmation
        document.getElementById('updatePasswordBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update your password?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('updatePasswordForm').submit();
                }
            });
        });
    </script>
@endsection
