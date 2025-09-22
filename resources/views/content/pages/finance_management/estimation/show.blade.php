@extends('layouts/contentNavbarLayout')

@section('title', 'Estimate Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Estimate Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('estimations.edit', $estimation->id) }}"
                class="btn  btn-primary d-flex align-items-center gap-1">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('estimations.index') }}" class="btn  btn-secondary d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">

                {{-- Client --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Client</label>
                    <p class="form-control-plaintext">{{ $estimation->company->name ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Bill To</label>
                    <p class="form-control-plaintext">{{ $estimation->bill_to }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Ship To</label>
                    <p class="form-control-plaintext">{{ $estimation->ship_to }}</p>
                </div>

                {{-- Project --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Project</label>
                    <p class="form-control-plaintext">{{ $estimation->project->name ?? '-' }}</p>
                </div>

                {{-- Estimate By --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Estimate By</label>
                    <p class="form-control-plaintext">{{ $estimation->user->name ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Amount</label>
                    <p class="form-control-plaintext">
                        {{ $estimation->amount }}
                        {{ $estimation->currency === 'taka' ? '৳' : ($estimation->currency === 'rupee' ? '₹' : ($estimation->currency === 'dollar' ? '$' : '£')) }}
                    </p>
                </div>

                {{-- Dates --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Estimate Date</label>
                    <p class="form-control-plaintext">
                        {{ $estimation->estimate_date ? \Carbon\Carbon::parse($estimation->estimate_date)->format('d M, Y') : '-' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Expiry Date</label>
                    <p class="form-control-plaintext">
                        {{ $estimation->expiry_date ? \Carbon\Carbon::parse($estimation->expiry_date)->format('d M, Y') : '-' }}
                    </p>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <p>
                        <span
                            class="badge 
                            @if ($estimation->status === 'draft') bg-secondary
                            @elseif ($estimation->status === 'sent') bg-info
                            @elseif ($estimation->status === 'accepted') bg-success
                            @else bg-danger @endif">
                            {{ ucfirst($estimation->status) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Tags</label>
                    <div>
                        @php
                            $tags = $estimation->tags;

                            // Ensure it's always an array
                            if (is_string($tags)) {
                                $tags = json_decode($tags, true) ?? [];
                            } elseif (!is_array($tags)) {
                                $tags = [];
                            }
                        @endphp

                        @forelse ($tags as $tag)
                            <span class="badge bg-primary me-1">{{ $tag }}</span>
                        @empty
                            <p class="text-muted mb-0">No tags</p>
                        @endforelse
                    </div>
                </div>

                {{-- Attachment --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Attachment</label>
                    @if ($estimation->attachment)
                        <a href="{{ asset('uploads/estimation/' . $estimation->attachment) }}" target="_blank"
                            class="d-block">
                            <i class="bi bi-paperclip"></i> View Attachment
                        </a>
                    @else
                        <p class="text-muted">No attachment</p>
                    @endif
                </div>

                {{-- Description --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Description</label>
                    <p class="form-control-plaintext">{{ $estimation->description ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
