@extends('layouts/contentNavbarLayout')

@section('title', 'Create Campaign')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Create Campaign</h3>
        <a href="{{ route('campaigns.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    {{-- Show Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header fw-bold">Campaign Information</div>
        <div class="card-body">
            <form action="{{ route('campaigns.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- Campaign Name --}}
                    <div class="col-md-4">
                        <label for="name" class="form-label">Campaign Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Campaign Type --}}
                    <div class="col-md-4">
                        <label for="type" class="form-label">Campaign Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">Select type</option>
                            <option value="public_relations" {{ old('type') == 'public_relations' ? 'selected' : '' }}>
                                Public Relations</option>
                            <option value="content_marketting" {{ old('type') == 'content_marketting' ? 'selected' : '' }}>
                                Content Marketing</option>
                            <option value="social_marketting" {{ old('type') == 'social_marketting' ? 'selected' : '' }}>
                                Social Marketing</option>
                            <option value="brand" {{ old('type') == 'brand' ? 'selected' : '' }}>Brand</option>
                            <option value="sales" {{ old('type') == 'sales' ? 'selected' : '' }}>Sales</option>
                            <option value="media" {{ old('type') == 'media' ? 'selected' : '' }}>Media</option>
                            <option value="rebranding" {{ old('type') == 'rebranding' ? 'selected' : '' }}>Rebranding
                            </option>
                            <option value="product_launch" {{ old('type') == 'product_launch' ? 'selected' : '' }}>Product
                                Launch</option>
                        </select>
                        @error('type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Pipeline --}}
                    <div class="col-md-4">
                        <label for="pipeline_id" class="form-label">Pipeline</label>
                        <select name="pipeline_id" id="pipeline_id"
                            class="form-control  @error('pipeline_id') is-invalid @enderror">
                            <option value="">Select Pipeline</option>
                            @foreach ($pipelines as $pipeline)
                                <option value="{{ $pipeline->id }}"
                                    {{ old('pipeline_id') == $pipeline->id ? 'selected' : '' }}>
                                    {{ $pipeline->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('pipeline_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Plan --}}
                    <div class="col-md-4">
                        <label for="plan" class="form-label">Plan <span class="text-danger">*</span></label>
                        <select name="plan" id="plan" class="form-control @error('plan') is-invalid @enderror">
                            <option value="">Select a Plan</option>
                            <option value="Standard" {{ old('plan') == 'Standard' ? 'selected' : '' }}>Standard - BDT
                                10,000 /yr + 20,000 BDT setup cost</option>
                            <option value="Professional" {{ old('plan') == 'Professional' ? 'selected' : '' }}>Professional
                                - BDT 15,000 /yr + 20,000 BDT setup cost</option>
                            <option value="Premium" {{ old('plan') == 'Premium' ? 'selected' : '' }}>Premium - BDT 25,000
                                /yr + 20,000 BDT setup cost</option>
                            <option value="Premium Plus" {{ old('plan') == 'Premium Plus' ? 'selected' : '' }}>Premium Plus
                                - BDT 50,000 /yr + 20,000 BDT setup cost</option>
                        </select>
                        @error('plan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Numeric Fields --}}
                    <div class="col-md-4">
                        <label class="form-label">Total Members</label>
                        <input type="number" name="total_members"
                            class="form-control @error('total_members') is-invalid @enderror"
                            value="{{ old('total_members', 0) }}">
                        @error('total_members')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sent</label>
                        <input type="number" name="sent" class="form-control @error('sent') is-invalid @enderror"
                            value="{{ old('sent', 0) }}">
                        @error('sent')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Opened</label>
                        <input type="number" name="opened" class="form-control @error('opened') is-invalid @enderror"
                            value="{{ old('opened', 0) }}">
                        @error('opened')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Delivered</label>
                        <input type="number" name="delivered"
                            class="form-control @error('delivered') is-invalid @enderror"
                            value="{{ old('delivered', 0) }}">
                        @error('delivered')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Closed</label>
                        <input type="number" name="closed" class="form-control @error('closed') is-invalid @enderror"
                            value="{{ old('closed', 0) }}">
                        @error('closed')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Unsubscribe</label>
                        <input type="number" name="unsubscribe"
                            class="form-control @error('unsubscribe') is-invalid @enderror"
                            value="{{ old('unsubscribe', 0) }}">
                        @error('unsubscribe')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bounced</label>
                        <input type="number" name="bounced" class="form-control @error('bounced') is-invalid @enderror"
                            value="{{ old('bounced', 0) }}">
                        @error('bounced')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Progress (%)</label>
                        <input type="number" name="progress"
                            class="form-control @error('progress') is-invalid @enderror"
                            value="{{ old('progress', 0) }}">
                        @error('progress')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Select status</option>
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Dates --}}
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date') }}">
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date"
                            class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                        @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Save Campaign</button>
                </div>
            </form>
        </div>
    </div>
@endsection
