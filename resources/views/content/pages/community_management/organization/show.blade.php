@extends('layouts/contentNavbarLayout')

@section('title', 'Show Organization')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Organization Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('organizations.edit', $organization->id) }}"
                class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                <i class="fas fa-edit"></i> Edit
            </a>

        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <!-- Title -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label><strong>Organization Name:</strong></label>
                        <p class="form-control-plaintext">{{ $organization->name }}</p>
                    </div>
                </div>

                <!-- Uploaded Image -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label><strong>Image:</strong></label>
                        <div class="border p-2 rounded bg-light text-center">
                            <img src="{{ $organization->image ? asset('uploads/images/organization/' . $organization->image) : asset('uploads/images/no-image.png') }}"
                                alt="organization Image" class="img-fluid rounded" style="max-height: 200px; margin:auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
