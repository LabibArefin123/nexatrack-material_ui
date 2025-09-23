@extends('layouts/contentNavbarLayout')

@section('title', 'Lost Reason Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Lost Reason Details</h3>
        <a href="{{ route('lost_reasons.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Lost Reason Information</h5>

            <p><strong>Title:</strong> {{ $lost_reason->title }}</p>
            <p>
                <strong>Status:</strong>
                @if ($lost_reason->status === 'Active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </p>
            <p><strong>Created At:</strong> {{ $lost_reason->created_at->format('j F Y, g:i A') }}</p>
            <p><strong>Updated At:</strong> {{ $lost_reason->updated_at->format('j F Y, g:i A') }}</p>
        </div>
    </div>
@endsection
