@extends('adminlte::page')

@section('title', 'Edit Campaign')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Edit Campaign</h1>
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
        <div class="card-header">Edit Campaign Information</div>
        <div class="card-body">
            <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="name">Campaign Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $campaign->name) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="type">Type <span class="text-danger">*</span></label>
                        <input type="text" name="type" id="type" class="form-control"
                            value="{{ old('type', $campaign->type) }}">
                    </div>

                    <div class="col-md-6 form-group">
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

                    <div class="col-md-6 form-group">
                        <label for="plan_id">Plan</label>
                        <select name="plan_id" id="plan_id" class="form-control">
                            <option value="">Select Plan</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}"
                                    {{ old('plan_id', $campaign->plan_id) == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="total_members">Total Members</label>
                        <input type="number" name="total_members" class="form-control"
                            value="{{ old('total_members', $campaign->total_members) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="sent">Sent</label>
                        <input type="number" name="sent" class="form-control"
                            value="{{ old('sent', $campaign->sent) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="opened">Opened</label>
                        <input type="number" name="opened" class="form-control"
                            value="{{ old('opened', $campaign->opened) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="delivered">Delivered</label>
                        <input type="number" name="delivered" class="form-control"
                            value="{{ old('delivered', $campaign->delivered) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="closed">Closed</label>
                        <input type="number" name="closed" class="form-control"
                            value="{{ old('closed', $campaign->closed) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="unsubscribe">Unsubscribe</label>
                        <input type="number" name="unsubscribe" class="form-control"
                            value="{{ old('unsubscribe', $campaign->unsubscribe) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="bounced">Bounced</label>
                        <input type="number" name="bounced" class="form-control"
                            value="{{ old('bounced', $campaign->bounced) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="progress">Progress (%)</label>
                        <input type="number" name="progress" class="form-control"
                            value="{{ old('progress', $campaign->progress) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="Active" {{ old('status', $campaign->status) == 'Active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="Inactive" {{ old('status', $campaign->status) == 'Inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', $campaign->start_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ old('end_date', $campaign->end_date?->format('Y-m-d')) }}">
                    </div>

                </div>

                <button type="submit" class="btn btn-success">Update Campaign</button>
            </form>
        </div>
    </div>
@stop
