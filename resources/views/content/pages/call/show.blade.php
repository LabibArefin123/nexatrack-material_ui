@extends('layouts/contentNavbarLayout')

@section('title', 'Call Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Call Details</h3>
        <a href="{{ route('calls.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Call Information</h5>

            <p><strong>Title:</strong> {{ $call->title }}</p>
            <p>
                <strong>Status:</strong>
                @if ($call->status === 'Active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </p>
            <p><strong>Created At:</strong> {{ $call->created_at->format('j F Y, g:i A') }}</p>
            <p><strong>Updated At:</strong> {{ $call->updated_at->format('j F Y, g:i A') }}</p>
        </div>
    </div>
@endsection
