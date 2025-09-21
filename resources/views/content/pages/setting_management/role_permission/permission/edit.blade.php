@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Permission')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Update Permission</h3>
        <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    <div class="container-fluid">
        <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Permission Name"
                            value="{{ old('name', $permission->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="guard_name">Guard <span class="text-danger">*</span></label>
                        <input type="text" name="guard_name" class="form-control" placeholder="Guard Name"
                            value="{{ old('guard_name', $permission->guard_name) }}" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Permission</button>
                </div>
            </div>
        </form>
    </div>

@stop
