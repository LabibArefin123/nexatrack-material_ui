@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Customer')

@section('content_header')
    <h1>Edit Customer</h1>
@stop

@section('content')
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

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            Update
                        </button>
                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary">
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
