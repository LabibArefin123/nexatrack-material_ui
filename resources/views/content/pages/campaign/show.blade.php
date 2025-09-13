@extends('adminlte::page')

@section('title', 'Campaign Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Campaign Details</h1>
        <a href="{{ route('campaigns.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Campaign Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ $campaign->name }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Type</label>
                    <input type="text" class="form-control" value="{{ $campaign->type }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Pipeline</label>
                    <input type="text" class="form-control" value="{{ $campaign->pipeline->name ?? '-' }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Plan</label>
                    <input type="text" class="form-control" value="{{ $campaign->plan }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Total Members</label>
                    <input type="text" class="form-control" value="{{ $campaign->total_members }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Opened</label>
                    <input type="text" class="form-control" value="{{ $campaign->opened }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Closed</label>
                    <input type="text" class="form-control" value="{{ $campaign->closed ?? '-' }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Unsubscribe</label>
                    <input type="text" class="form-control" value="{{ $campaign->unsubscribe }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Delivered</label>
                    <input type="text" class="form-control" value="{{ $campaign->delivered }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Bounced</label>
                    <input type="text" class="form-control" value="{{ $campaign->bounced }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Progress</label>
                    <input type="text" class="form-control" value="{{ $campaign->progress }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ $campaign->status }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>Start Date</label>
                    <input type="text" class="form-control" value="{{ $campaign->start_date }}" disabled>
                </div>
                <div class="col-md-6 form-group">
                    <label>End Date</label>
                    <input type="text" class="form-control" value="{{ $campaign->end_date }}" disabled>
                </div>
            </div>
        </div>
    </div>
@stop
