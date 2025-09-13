@extends('adminlte::page')

@section('title', 'Create Campaign')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Create Campaign</h1>
        <a href="{{ route('campaigns.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
@stop

@section('content')
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
        <div class="card-header">
            Campaign Information
        </div>
        <div class="card-body">
            <form action="{{ route('campaigns.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="name">Campaign Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name') }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="type">Campaign Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">Select type</option>
                            <option value="public_relations" {{ old('type') == 'public_relations' ? 'selected' : '' }}>
                                Public Relations
                            </option>
                            <option value="content_marketting" {{ old('type') == 'content_marketting' ? 'selected' : '' }}>
                                Content Marketing
                            </option>
                            <option value="social_marketing" {{ old('type') == 'social_marketting' ? 'selected' : '' }}>
                                Social Marketing</option>
                            <option value="brand" {{ old('type') == 'brand' ? 'selected' : '' }}>
                                Brand</option>
                            <option value="sales" {{ old('type') == 'sales' ? 'selected' : '' }}>
                                Sales
                            </option>
                            <option value="media" {{ old('type') == 'media' ? 'selected' : '' }}>
                                Media</option>
                            <option value="rebranding" {{ old('type') == 'rebranding' ? 'selected' : '' }}>
                                Rebranding</option>
                            <option value="product_launch" {{ old('type') == 'product_launch' ? 'selected' : '' }}>Product
                                launch
                            </option>
                        </select>
                        @error('type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="pipeline_id">Pipeline</label>
                        <select name="pipeline_id" id="pipeline_id" class="form-control">
                            <option value="">Select Pipeline</option>
                            @foreach ($pipelines as $pipeline)
                                <option value="{{ $pipeline->id }}"
                                    {{ old('pipeline_id') == $pipeline->id ? 'selected' : '' }}>
                                    {{ $pipeline->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="plan">Plan <span class="text-danger">*</span></label>
                        <select name="plan" id="plan" class="form-control @error('plan') is-invalid @enderror">
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
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="total_members">Total Members</label>
                        <input type="number" name="total_members" class="form-control"
                            value="{{ old('total_members', 0) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="sent">Sent</label>
                        <input type="number" name="sent" class="form-control" value="{{ old('sent', 0) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="opened">Opened</label>
                        <input type="number" name="opened" class="form-control" value="{{ old('opened', 0) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="delivered">Delivered</label>
                        <input type="number" name="delivered" class="form-control" value="{{ old('delivered', 0) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="closed">Closed</label>
                        <input type="number" name="closed" class="form-control" value="{{ old('closed', 0) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="unsubscribe">Unsubscribe</label>
                        <input type="number" name="unsubscribe" class="form-control" value="{{ old('unsubscribe', 0) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="bounced">Bounced</label>
                        <input type="number" name="bounced" class="form-control" value="{{ old('bounced', 0) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="progress">Progress (%)</label>
                        <input type="number" name="progress" class="form-control" value="{{ old('progress', 0) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>

                </div>

                <button type="submit" class="btn btn-success">Save Campaign</button>
            </form>
        </div>
    </div>
@stop
