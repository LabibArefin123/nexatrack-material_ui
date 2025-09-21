@extends('layouts/contentNavbarLayout')

@section('title', 'Campaign Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Campaign Details</h3>
        <a href="{{ route('campaigns.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header fw-bold">Campaign Information</div>
        <div class="card-body">
            <div class="row g-3">
                {{-- Name --}}
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{ $campaign->name }}" disabled>
                </div>

                {{-- Type --}}
                <div class="col-md-6">
                    <label class="form-label">Type</label>
                    <input type="text" class="form-control" value="{{ $campaign->type }}" disabled>
                </div>

                {{-- Pipeline --}}
                <div class="col-md-6">
                    <label class="form-label">Pipeline</label>
                    <input type="text" class="form-control" value="{{ $campaign->pipeline->name ?? '-' }}" disabled>
                </div>

                {{-- Plan --}}
                <div class="col-md-6">
                    <label class="form-label">Plan</label>
                    <input type="text" class="form-control" value="{{ $campaign->plan }}" disabled>
                </div>

                {{-- Numbers --}}
                <div class="col-md-6">
                    <label class="form-label">Total Members</label>
                    <input type="text" class="form-control" value="{{ $campaign->total_members }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sent</label>
                    <input type="text" class="form-control" value="{{ $campaign->sent }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Opened</label>
                    <input type="text" class="form-control" value="{{ $campaign->opened }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Delivered</label>
                    <input type="text" class="form-control" value="{{ $campaign->delivered }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Closed</label>
                    <input type="text" class="form-control" value="{{ $campaign->closed ?? '-' }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Unsubscribe</label>
                    <input type="text" class="form-control" value="{{ $campaign->unsubscribe }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bounced</label>
                    <input type="text" class="form-control" value="{{ $campaign->bounced }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Progress (%)</label>
                    <input type="text" class="form-control" value="{{ $campaign->progress }}" disabled>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <input type="text" class="form-control" value="{{ $campaign->status }}" disabled>
                </div>

                {{-- Dates --}}
                <div class="col-md-6">
                    <label class="form-label">Start Date</label>
                    <input type="text" class="form-control" value="{{ $campaign->start_date }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date</label>
                    <input type="text" class="form-control" value="{{ $campaign->end_date }}" disabled>
                </div>
            </div>
        </div>
    </div>
@endsection
