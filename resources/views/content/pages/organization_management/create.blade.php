@extends('layouts/contentNavbarLayout')

@section('title', 'Create Organization')

@section('content_header')
    <h1>Create Organization</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('organizations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="name">Organization Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Enter organization name">
                    </div>
                    <!-- Image -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="iconInput" class="form-label">Upload Image <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="image" id="iconInput"
                                class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <input type="hidden" name="icon" id="iconData" />
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
