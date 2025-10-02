@extends('layouts/contentNavbarLayout')

@section('title', 'View Pipeline')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Pipeline Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('pipelines.edit', $pipeline->id) }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('pipelines.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                {{-- Pipeline Name --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Pipeline Name</label>
                    <input type="text" class="form-control" value="{{ ucfirst($pipeline->name) }}" readonly>
                </div>

                {{-- Total Deal Value --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Total Deal Value</label>
                    <input type="text" class="form-control"
                        value="{{ number_format($pipeline->total_deal_value, 2) }} Tk" readonly>
                </div>

                {{-- Number of Deals --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Number of Deals</label>
                    <input type="text" class="form-control" value="{{ $pipeline->no_of_deals }}" readonly>
                </div>

                {{-- Stage --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Stage</label>
                    <input type="text" class="form-control"
                        value="{{ ucfirst(str_replace('_', ' ', $pipeline->stage)) ?? '-' }}" readonly>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <input type="text" class="form-control" value="{{ $pipeline->status }}" readonly>
                </div>
            </div>
        </div>
    </div>
@endsection
