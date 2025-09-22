@extends('layouts/contentNavbarLayout')

@section('title', 'Add New Customer Plan')

@section('content_header')

@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0 text-dark">Add New Customer Plan</h3>
        <a href="{{ route('plans.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
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
            <div class="row">

                <div class="card card-primary shadow-sm rounded-4">
                    <form action="{{ route('plans.store') }}" method="POST" class="p-4">
                        @csrf
                        <div class="row">

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
                                    class="form-control @error('phone') is-invalid @enderror" pattern="[0-9]+"
                                    inputmode="numeric" maxlength="15" autocomplete="tel"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                @error('phone')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="company_name">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" id="company_name"
                                    value="{{ old('company_name') }}"
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
                                <label for="plan">Plan <span class="text-danger">*</span></label>
                                <select name="plan" id="plan"
                                    class="form-control @error('plan') is-invalid @enderror">
                                    <option value="">Select a Plan</option>
                                    <option value="Standard" {{ old('plan') == 'Standard' ? 'selected' : '' }}>
                                        Standard - BDT 10,000 /yr + 20,000 BDT setup cost
                                    </option>
                                    <option value="Professional" {{ old('plan') == 'Professional' ? 'selected' : '' }}>
                                        Professional - BDT 15,000 /yr + 20,000 BDT setup cost
                                    </option>
                                    <option value="Premium" {{ old('plan') == 'Premium' ? 'selected' : '' }}>
                                        Premium - BDT 25,000 /yr + 20,000 BDT setup cost
                                    </option>
                                    <option value="Premium Plus" {{ old('plan') == 'Premium Plus' ? 'selected' : '' }}>
                                        Premium Plus - BDT 50,000 /yr + 20,000 BDT setup cost
                                    </option>
                                </select>
                                @error('plan')
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

                        <div class="form-group col-12 mt-4"
                            style="text-align: right; margin-top: 1.5rem; margin-bottom: 0.5rem;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
@stop
