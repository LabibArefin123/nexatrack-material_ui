@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Customer')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Customer</h3>
        <a href="{{ route('customers.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Software --}}
                        <div class="form-group col-md-6">
                            <label for="software">Software <span class="text-danger">*</span></label>
                            <input type="text" name="software" class="form-control"
                                value="{{ old('software', $customer->software) }}">
                        </div>

                        {{-- Name --}}
                        <div class="form-group col-md-6">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $customer->name) }}">
                        </div>

                        {{-- Email --}}
                        <div class="form-group col-md-6">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $customer->email) }}">
                        </div>

                        {{-- Company Name --}}
                        <div class="form-group col-md-6">
                            <label for="company_name">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control"
                                value="{{ old('company_name', $customer->company_name) }}">
                        </div>

                        {{-- Address --}}
                        <div class="form-group col-md-6">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $customer->address) }}">
                        </div>

                        {{-- Area --}}
                        <div class="form-group col-md-6">
                            <label for="area">Area <span class="text-danger">*</span></label>
                            <input type="text" name="area" class="form-control"
                                value="{{ old('area', $customer->area) }}">
                        </div>

                        {{-- City --}}
                        <div class="form-group col-md-6">
                            <label for="city">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control"
                                value="{{ old('city', $customer->city) }}">
                        </div>

                        {{-- Country --}}
                        <div class="form-group col-md-6">
                            <label for="country">Country <span class="text-danger">*</span></label>
                            <input type="text" name="country" class="form-control"
                                value="{{ old('country', $customer->country) }}">
                        </div>

                        {{-- Post Code --}}
                        <div class="form-group col-md-6">
                            <label for="post_code">Post Code <span class="text-danger">*</span></label>
                            <input type="text" name="post_code" class="form-control"
                                value="{{ old('post_code', $customer->post_code) }}">
                        </div>

                        {{-- Source --}}
                        <div class="form-group col-md-6">
                            <label for="source">Source <span class="text-danger">*</span></label>
                            <input type="text" name="source" class="form-control"
                                value="{{ old('source', $customer->source) }}">
                        </div>

                        {{-- Note --}}
                        <div class="form-group col-md-6">
                            <label for="note">Note <span class="text-danger">*</span></label>
                            <textarea name="note" class="form-control" rows="3">{{ old('note', $customer->note) }}</textarea>
                        </div>


                    </div>

                    <div class="form-group col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
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
