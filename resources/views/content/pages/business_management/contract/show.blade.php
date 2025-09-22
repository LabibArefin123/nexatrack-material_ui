@extends('layouts/contentNavbarLayout')

@section('title', 'View Contract')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">View contract</h3>
        <a href="{{ route('contracts.edit', $contract->id) }}" class="btn  btn-primary">Edit Contract</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">

                {{-- Subject --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Subject</label>
                    <input type="text" class="form-control" value="{{ $contract->subject }}" readonly>
                </div>

                {{-- Client --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Client</label>
                    <input type="text" class="form-control" value="{{ $contract->customer->name ?? '-' }}" readonly>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($contract->type ?? '-') }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Contract Value</label>
                    <input type="text" class="form-control" value="{{ $contract->value }}" readonly>
                </div>

                {{-- Dates --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Start Date</label>
                    <input type="text" class="form-control"
                        value="{{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('j F Y') : '-' }}"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">End Date</label>
                    <input type="text" class="form-control"
                        value="{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('j F Y') : '-' }}"
                        readonly>
                </div>

                {{-- Attachment --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Attachment</label>
                    @if ($contract->attachment)
                        <div>
                            <a href="{{ asset('uploads/contracts/' . $contract->attachment) }}" target="_blank">
                                {{ $contract->attachment }}
                            </a>
                        </div>
                    @else
                        -
                    @endif
                </div>

                {{-- Description --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Description</label>
                    <textarea class="form-control" rows="4" readonly>{{ $contract->description }}</textarea>
                </div>

            </div>
        </div>
    </div>
@endsection
