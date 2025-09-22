@extends('layouts/contentNavbarLayout')

@section('title', 'Create Pipeline')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Create Pipeline</h3>
        <a href="{{ route('pipelines.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
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
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pipelines.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Pipeline Name <span class="text-danger">*</span></label>
                        <select name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                            <option value="">Select a name</option>
                            <option value="sales" {{ old('name') == 'sales' ? 'selected' : '' }}>Sales</option>
                            <option value="marketing" {{ old('name') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="email" {{ old('name') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="chats" {{ old('name') == 'chats' ? 'selected' : '' }}>Chats</option>
                            <option value="operational" {{ old('name') == 'operational' ? 'selected' : '' }}>Operational
                            </option>
                            <option value="collaborative" {{ old('name') == 'collaborative' ? 'selected' : '' }}>
                                Collaborative</option>
                            <option value="differentiate" {{ old('name') == 'differentiate' ? 'selected' : '' }}>
                                Differentiate</option>
                            <option value="interact" {{ old('name') == 'interact' ? 'selected' : '' }}>Interact</option>
                        </select>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Total Deal Value <span class="text-danger">*</span></label>
                        <input type="number" name="total_deal_value"
                            class="form-control @error('total_deal_value') is-invalid @enderror"
                            value="{{ old('total_deal_value') }}">
                        @error('total_deal_value')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>No of Deals <span class="text-danger">*</span></label>
                        <input type="number" name="no_of_deals"
                            class="form-control @error('no_of_deals') is-invalid @enderror"
                            value="{{ old('no_of_deals') }}">
                        @error('no_of_deals')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="stage">Pipeline Stage <span class="text-danger">*</span></label>
                        <select name="stage" id="stage" class="form-control @error('stage') is-invalid @enderror">
                            <option value="">Select a stage</option>
                            <option value="win" {{ old('stage') == 'win' ? 'selected' : '' }}>Win</option>
                            <option value="in_pipeline" {{ old('stage') == 'in_pipeline' ? 'selected' : '' }}>In Pipeline
                            </option>
                            <option value="conversation" {{ old('stage') == 'conversation' ? 'selected' : '' }}>
                                Conversation</option>
                            <option value="lost" {{ old('stage') == 'lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                        @error('stage')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
@stop
