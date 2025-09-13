@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Pipeline')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Pipeline</h3>
        <a href="{{ route('pipelines.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
            <form action="{{ route('pipelines.update', $pipeline->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Pipeline Name <span class="text-danger">*</span></label>
                        <select name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                            <option value="">Select a name</option>
                            <option value="sales" {{ $pipeline->name == 'sales' ? 'selected' : '' }}>Sales</option>
                            <option value="marketing" {{ $pipeline->name == 'marketing' ? 'selected' : '' }}>Marketing
                            </option>
                            <option value="email" {{ $pipeline->name == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="chats" {{ $pipeline->name == 'chats' ? 'selected' : '' }}>Chats</option>
                            <option value="operational" {{ $pipeline->name == 'operational' ? 'selected' : '' }}>Operational
                            </option>
                            <option value="collaborative" {{ $pipeline->name == 'collaborative' ? 'selected' : '' }}>
                                Collaborative</option>
                            <option value="differentiate" {{ $pipeline->name == 'differentiate' ? 'selected' : '' }}>
                                Differentiate</option>
                            <option value="interact" {{ $pipeline->name == 'interact' ? 'selected' : '' }}>Interact
                            </option>
                        </select>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Total Deal Value <span class="text-danger">*</span></label>
                        <input type="number" name="total_deal_value"
                            class="form-control @error('total_deal_value') is-invalid @enderror"
                            value="{{ old('total_deal_value', $pipeline->total_deal_value) }}">
                        @error('total_deal_value')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>No of Deals <span class="text-danger">*</span></label>
                        <input type="number" name="no_of_deals"
                            class="form-control @error('no_of_deals') is-invalid @enderror"
                            value="{{ old('no_of_deals', $pipeline->no_of_deals) }}">
                        @error('no_of_deals')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="stage">Pipeline Stage <span class="text-danger">*</span></label>
                        <select name="stage" id="stage" class="form-control @error('stage') is-invalid @enderror">
                            <option value="">Select a stage</option>
                            <option value="win" {{ $pipeline->stage == 'win' ? 'selected' : '' }}>Win</option>
                            <option value="in_pipeline" {{ $pipeline->stage == 'in_pipeline' ? 'selected' : '' }}>In
                                Pipeline</option>
                            <option value="conversation" {{ $pipeline->stage == 'conversation' ? 'selected' : '' }}>
                                Conversation</option>
                            <option value="lost" {{ $pipeline->stage == 'lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                        @error('stage')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Active" {{ $pipeline->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $pipeline->status == 'Inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
@stop
