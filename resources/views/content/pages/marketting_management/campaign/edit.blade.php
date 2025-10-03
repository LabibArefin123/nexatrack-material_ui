@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Campaign')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Campaign</h3>
        <a href="{{ route('campaigns.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
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
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-md-4 form-group">
                        <label for="name">Campaign Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $campaign->name) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="type">Campaign Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">Select type</option>
                            <option value="public_relations"
                                {{ old('type', $campaign->type) == 'public_relations' ? 'selected' : '' }}>Public
                                Relations
                            </option>
                            <option value="content_marketting"
                                {{ old('type', $campaign->type) == 'content_marketting' ? 'selected' : '' }}>Content
                                Marketing</option>
                            <option value="social_marketing"
                                {{ old('type', $campaign->type) == 'social_marketing' ? 'selected' : '' }}>Social
                                Marketing
                            </option>
                            <option value="brand" {{ old('type', $campaign->type) == 'brand' ? 'selected' : '' }}>Brand
                            </option>
                            <option value="sales" {{ old('type', $campaign->type) == 'sales' ? 'selected' : '' }}>Sales
                            </option>
                            <option value="media" {{ old('type', $campaign->type) == 'media' ? 'selected' : '' }}>Media
                            </option>
                            <option value="rebranding"
                                {{ old('type', $campaign->type) == 'rebranding' ? 'selected' : '' }}>Rebranding
                            </option>
                            <option value="product_launch"
                                {{ old('type', $campaign->type) == 'product_launch' ? 'selected' : '' }}>Product Launch
                            </option>
                        </select>
                        @error('type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="pipeline_id">Pipeline</label>
                        <select name="pipeline_id" id="pipeline_id" class="form-control">
                            <option value="">Select Pipeline</option>
                            @foreach ($pipelines as $pipeline)
                                <option value="{{ $pipeline->id }}"
                                    {{ old('pipeline_id', $campaign->pipeline_id) == $pipeline->id ? 'selected' : '' }}>
                                    {{ $pipeline->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="plan">Plan <span class="text-danger">*</span></label>
                        <select name="plan" id="plan" class="form-control @error('plan') is-invalid @enderror">
                            <option value="">Select a Plan</option>
                            <option value="Standard" {{ old('plan', $campaign->plan) == 'Standard' ? 'selected' : '' }}>
                                Standard - BDT 10,000 /yr + 20,000 BDT setup cost</option>
                            <option value="Professional"
                                {{ old('plan', $campaign->plan) == 'Professional' ? 'selected' : '' }}>Professional -
                                BDT
                                15,000 /yr + 20,000 BDT setup cost</option>
                            <option value="Premium" {{ old('plan', $campaign->plan) == 'Premium' ? 'selected' : '' }}>
                                Premium - BDT 25,000 /yr + 20,000 BDT setup cost</option>
                            <option value="Premium Plus"
                                {{ old('plan', $campaign->plan) == 'Premium Plus' ? 'selected' : '' }}>Premium Plus -
                                BDT
                                50,000 /yr + 20,000 BDT setup cost</option>
                        </select>
                        @error('plan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="total_members">Total Members</label>
                        <input type="number" name="total_members" class="form-control"
                            value="{{ old('total_members', $campaign->total_members) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="sent">Sent</label>
                        <input type="number" name="sent" class="form-control"
                            value="{{ old('sent', $campaign->sent) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="opened">Opened</label>
                        <input type="number" name="opened" class="form-control"
                            value="{{ old('opened', $campaign->opened) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="delivered">Delivered</label>
                        <input type="number" name="delivered" class="form-control"
                            value="{{ old('delivered', $campaign->delivered) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="closed">Closed</label>
                        <input type="number" name="closed" class="form-control"
                            value="{{ old('closed', $campaign->closed) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="unsubscribe">Unsubscribe</label>
                        <input type="number" name="unsubscribe" class="form-control"
                            value="{{ old('unsubscribe', $campaign->unsubscribe) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="bounced">Bounced</label>
                        <input type="number" name="bounced" class="form-control"
                            value="{{ old('bounced', $campaign->bounced) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="progress">Progress (%)</label>
                        <input type="number" name="progress" class="form-control"
                            value="{{ old('progress', $campaign->progress) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="Active" {{ old('status', $campaign->status) == 'Active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="Inactive"
                                {{ old('status', $campaign->status) == 'Inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', optional($campaign->start_date)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ old('end_date', optional($campaign->end_date)->format('Y-m-d')) }}">
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
@endsection
