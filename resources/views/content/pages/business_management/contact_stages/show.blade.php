@extends('layouts/contentNavbarLayout')

@section('title', 'Contract Stage Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Contract Stage Details</h3>
        <a href="{{ route('contact_stages.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Stage Information</h5>

            <p><strong>Title:</strong> {{ $contact_stage->title }}</p>
            <p>
                <strong>Status:</strong>
                @if ($contact_stage->status === 'Active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </p>
            <p><strong>Created At:</strong> {{ $contact_stage->created_at->format('j F Y, g:i A') }}</p>
            <p><strong>Updated At:</strong> {{ $contact_stage->updated_at->format('j F Y, g:i A') }}</p>
        </div>
    </div>
@endsection
