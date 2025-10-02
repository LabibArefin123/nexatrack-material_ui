@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Contract')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Contract</h3>
        <a href="{{ route('contracts.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">

                    {{-- Subject --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject', $contract->subject) }}">
                        @error('subject')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Client --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Client <span class="text-danger">*</span></label>
                        <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ old('client_id', $contract->client_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Contract Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="contracts_under_seal"
                                {{ old('type', $contract->status) == 'contracts_under_seal' ? 'selected' : '' }}>
                                Contracts Under Seal</option>
                            <option value="implied_contracts"
                                {{ old('type', $contract->status) == 'implied_contracts' ? 'selected' : '' }}>Implied
                                Contracts
                            </option>
                            <option value="executory_contracts"
                                {{ old('type', $contract->status) == 'executory_contracts' ? 'selected' : '' }}>
                                Executory Contracts</option>
                            <option value="voidable_contracts"
                                {{ old('type', $contract->status) == 'voidable_contracts' ? 'selected' : '' }}>Voidable
                                Contracts</option>
                        </select>
                        @error('type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Contract Value --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Contract Value <span class="text-danger">*</span></label>
                        <input type="number" name="value" class="form-control @error('value') is-invalid @enderror"
                            value="{{ old('value', $contract->value) }}" placeholder="Enter contract value">
                        @error('value')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Dates --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date', $contract->start_date) }}">
                        @error('start_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date', $contract->end_date) }}">
                        @error('end_date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Attachment --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Attachment</label>
                        <input type="file" name="attachment" class="form-control">

                        @if ($contract->attachment)
                            <div class="mt-1">
                                <small class="text-muted">Current file:</small>
                                <a href="{{ asset('uploads/contracts/' . $contract->attachment) }}" target="_blank"
                                    class="d-block">
                                    {{ $contract->attachment }}
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $contract->description) }}</textarea>
                        @error('description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 text-end mt-2">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
