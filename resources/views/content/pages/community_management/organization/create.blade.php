@extends('layouts/contentNavbarLayout')

@section('title', 'Create Organization')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Create Organization</h3>
        <a href="{{ route('organizations.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('organizations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="name">Organization Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter organization name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Image -->
                    <div class="form-group col-md-6">
                        <label for="iconInput" class="form-label">Upload Image <span class="text-danger">*</span></label>
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
                            <img id="imagePreview" src="{{ asset('uploads/images/no-image.png') }}" alt="Preview Image"
                                class="img-fluid" style="max-height: 150px; margin:auto;">
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success mt-10">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
