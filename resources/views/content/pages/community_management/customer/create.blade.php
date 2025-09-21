@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Customer')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Add New Customer</h3>
        <a href="{{ route('customers.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

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

    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <form action="{{ route('customers.store') }}" method="POST" class="p-4">
                @csrf
                <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="software">Software <span class="text-danger">*</span></label>
                        <input type="text" name="software" id="software" value="{{ old('software') }}"
                            class="form-control @error('software') is-invalid @enderror">
                        @error('software')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">Phone <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                            class="form-control @error('phone') is-invalid @enderror" pattern="[0-9]+" inputmode="numeric"
                            maxlength="15" autocomplete="tel"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        @error('phone')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="company_name">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}"
                            class="form-control @error('company_name') is-invalid @enderror">
                        @error('company_name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="address">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}"
                            class="form-control @error('address') is-invalid @enderror">
                        @error('address')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="area">Area <span class="text-danger">*</span></label>
                        <input type="text" name="area" id="area" value="{{ old('area') }}"
                            class="form-control @error('area') is-invalid @enderror">
                        @error('area')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="city">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                            class="form-control @error('city') is-invalid @enderror">
                        @error('city')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="country">Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" id="country" value="{{ old('country') }}"
                            class="form-control @error('country') is-invalid @enderror">
                        @error('country')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="post_code">Post Code <span class="text-danger">*</span></label>
                        <input type="text" name="post_code" id="post_code" value="{{ old('post_code') }}"
                            class="form-control @error('post_code') is-invalid @enderror">
                        @error('post_code')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="note">Note <span class="text-danger">*</span></label>
                        <textarea name="note" id="note" rows="2" class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
                        @error('note')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="source">Source <span class="text-danger">*</span></label>
                        <input type="text" name="source" id="source" value="{{ old('source') }}"
                            class="form-control @error('source') is-invalid @enderror">
                        @error('source')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
