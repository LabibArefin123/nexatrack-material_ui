@extends('layouts/contentNavbarLayout')

@section('title', 'User Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h3 class="mb-0">User Details</h3>
        <a href="{{ route('system_users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Name -->
                <div class="form-group col-md-6 mb-3">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
                </div>

                <!-- Username -->
                <div class="form-group col-md-6 mb-3">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="form-control" value="{{ $user->username }}" readonly>
                </div>

                <!-- Email -->
                <div class="form-group col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>

                <!-- Phone -->
                <div class="form-group col-md-6 mb-3">
                    <label for="phone">Phone </label>
                    <input type="text" id="phone" class="form-control" value="{{ $user->phone ?? 'Not Provided' }}"
                        readonly>
                </div>

                <!-- Role -->
                <div class="form-group col-md-6 mb-3">
                    <label for="role">User Role</label>
                    <input type="text" id="role" class="form-control"
                        value="{{ $user->roles->pluck('name')->join(', ') }}" readonly>
                </div>
            </div>
        </div>
    </div>

@stop
