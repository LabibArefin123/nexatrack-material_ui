@extends('layouts/contentNavbarLayout')

@section('title', 'Source Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Source Details</h3>
        <a href="{{ route('sources.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Source Information</h5>

            <p><strong>Title:</strong> {{ $source->title }}</p>
            <p>
                <strong>Status:</strong>
                @if ($source->status === 'Active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </p>
            <p><strong>Created At:</strong> {{ $source->created_at->format('j F Y, g:i A') }}</p>
            <p><strong>Updated At:</strong> {{ $source->updated_at->format('j F Y, g:i A') }}</p>
        </div>
    </div>
@endsection
