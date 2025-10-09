@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Organization')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Organization</h3>
        <a href="{{ route('organizations.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left"
                viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('organizations.update', $organization->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-6">
                        <label for="title" class="form-label">Organization name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $organization->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Image name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Upload + Hidden Toast Input -->
                    <div class="col-md-6">
                        <label for="iconInput" class="form-label">Upload / Edit Image <span
                                class="text-danger">*</span></label>
                        <input type="file" name="image" id="iconInput"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <input type="hidden" name="icon" id="iconData" />
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Preview -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Preview</label>
                        <div class="border p-2 rounded bg-light text-center">
                            <img id="imagePreview"
                                src="{{ $organization->image ? asset('uploads/images/organization/' . $organization->image) : asset('uploads/images/no-image.png') }}"
                                alt="Preview Image" class="img-fluid" style="max-height: 150px; margin:auto;">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
