@extends('layouts/contentNavbarLayout')

@section('title', 'View Deal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Deal Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('deals.edit', $deal->id) }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bx bx-edit-alt"></i> Edit
            </a>
            <a href="{{ route('deals.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                {{-- Name --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" class="form-control" value="{{ $deal->name }}" readonly>
                </div>

                {{-- Stage --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Stage</label>
                    <input type="text" class="form-control"
                        value="{{ ucwords(str_replace('_', ' ', $deal->deal_stage)) }}" readonly>
                </div>

                {{-- Amount --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Amount</label>
                    <input type="text" class="form-control"
                        value="{{ number_format($deal->amount, 2) }} {{ $deal->currency }}" readonly>
                </div>

                {{-- Start Date --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Start Date</label>
                    <input type="text" class="form-control"
                        value="{{ \Carbon\Carbon::parse($deal->start_date)->format('d M Y') }}" readonly>
                </div>

                {{-- End Date --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">End Date</label>
                    <input type="text" class="form-control"
                        value="{{ \Carbon\Carbon::parse($deal->end_date)->format('d M Y') }}" readonly>
                </div>

                {{-- Client --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Client</label>
                    <input type="text" class="form-control" value="{{ $deal->client_option }}" readonly>
                </div>

                {{-- Company --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Company</label>
                    <input type="text" class="form-control" value="{{ $deal->company_option }}" readonly>
                </div>

                {{-- Deal Type --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Deal Type</label>
                    <input type="text" class="form-control"
                        value="{{ ucwords(str_replace('_', ' ', $deal->deal_type)) }}" readonly>
                </div>

                {{-- Source --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Source</label>
                    <input type="text" class="form-control" value="{{ ucwords(str_replace('_', ' ', $deal->source)) }}"
                        readonly>
                </div>
                <div class="w-100"></div>
                {{-- Responsibles --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Responsibles</label>
                    <div class="border p-2 rounded" style="max-height:200px; overflow-y:auto;">
                        @forelse ($deal->responsibles ?? [] as $responsible)
                            @php
                                $user = $users->firstWhere('id', $responsible);
                                $roles = $user ? $user->getRoleNames()->join(', ') : 'N/A';
                            @endphp
                            <input type="text" class="form-control mb-1"
                                value="{{ $user->name ?? 'Unknown' }} ({{ $roles }})" readonly>
                        @empty
                            <div class="text-muted">No responsibles assigned</div>
                        @endforelse
                    </div>
                </div>

                {{-- Observers --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Observers</label>
                    <div class="border p-2 rounded" style="max-height:200px; overflow-y:auto;">
                        @forelse ($deal->observer ?? [] as $observer)
                            <input type="text" class="form-control mb-1" value="{{ $observer }}" readonly>
                        @empty
                            <div class="text-muted">No observers added</div>
                        @endforelse
                    </div>
                </div>

                {{-- Comment --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Comment</label>
                    <textarea class="form-control" rows="5" readonly>{!! $deal->comment !!}</textarea>
                </div>

                {{-- Source Info --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Source Information</label>
                    <textarea class="form-control" rows="5" readonly>{!! $deal->source_information !!}</textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
