@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Plan')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0 text-dark">Edit Customer Plan</h3>
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
                <form action="{{ route('plans.update', $plan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Software --}}
                        <div class="form-group col-md-6">
                            <label for="software">Software <span class="text-danger">*</span></label>
                            <input type="text" name="software" class="form-control"
                                value="{{ old('software', $plan->software) }}">
                        </div>

                        {{-- Name --}}
                        <div class="form-group col-md-6">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $plan->name) }}">
                        </div>

                        {{-- Email --}}
                        <div class="form-group col-md-6">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $plan->email) }}">
                        </div>

                        {{-- Phone --}}
                        <div class="form-group col-md-6">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $plan->phone) }}">
                        </div>

                        {{-- Company Name --}}
                        <div class="form-group col-md-6">
                            <label for="company_name">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control"
                                value="{{ old('company_name', $plan->company_name) }}">
                        </div>

                        {{-- Address --}}
                        <div class="form-group col-md-6">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $plan->address) }}">
                        </div>

                        {{-- Area --}}
                        <div class="form-group col-md-6">
                            <label for="area">Area <span class="text-danger">*</span></label>
                            <input type="text" name="area" class="form-control"
                                value="{{ old('area', $plan->area) }}">
                        </div>

                        {{-- City --}}
                        <div class="form-group col-md-6">
                            <label for="city">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control"
                                value="{{ old('city', $plan->city) }}">
                        </div>

                        {{-- Country --}}
                        <div class="form-group col-md-6">
                            <label for="country">Country <span class="text-danger">*</span></label>
                            <input type="text" name="country" class="form-control"
                                value="{{ old('country', $plan->country) }}">
                        </div>

                        {{-- Post Code --}}
                        <div class="form-group col-md-6">
                            <label for="post_code">Post Code <span class="text-danger">*</span></label>
                            <input type="text" name="post_code" class="form-control"
                                value="{{ old('post_code', $plan->post_code) }}">
                        </div>

                        {{-- Source --}}
                        <div class="form-group col-md-6">
                            <label for="source">Source <span class="text-danger">*</span></label>
                            <input type="text" name="source" class="form-control"
                                value="{{ old('source', $plan->source) }}">
                        </div>

                        {{-- Plan --}}
                        <div class="form-group col-md-6">
                            <label for="plan">Plan <span class="text-danger">*</span></label>
                            <select name="plan" id="plan"
                                class="form-control @error('plan') is-invalid @enderror">
                                <option value="">Select a Plan</option>
                                <option value="Standard" {{ old('plan', $plan->plan) == 'Standard' ? 'selected' : '' }}>
                                    Standard - BDT 10,000 /yr + 20,000 BDT setup cost
                                </option>
                                <option value="Professional"
                                    {{ old('plan', $plan->plan) == 'Professional' ? 'selected' : '' }}>
                                    Professional - BDT 15,000 /yr + 20,000 BDT setup cost
                                </option>
                                <option value="Premium" {{ old('plan', $plan->plan) == 'Premium' ? 'selected' : '' }}>
                                    Premium - BDT 25,000 /yr + 20,000 BDT setup cost
                                </option>
                                <option value="Premium Plus"
                                    {{ old('plan', $plan->plan) == 'Premium Plus' ? 'selected' : '' }}>
                                    Premium Plus - BDT 50,000 /yr + 20,000 BDT setup cost
                                </option>
                            </select>
                            @error('plan')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            Update
                        </button>
                        <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-group label {
            font-weight: 600;
        }
    </style>
@stop
