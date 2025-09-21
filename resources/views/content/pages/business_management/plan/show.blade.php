@extends('layouts/contentNavbarLayout')

@section('title', 'Plan Details')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h3 class="mb-0">
            <i class="fas fa-info-circle text-primary"></i> Plan Details
        </h3>
        <div class="d-flex gap-2">
            <a href="javascript:history.back()" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('plans.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-4">
                <!-- Left -->
                <div class="col-md-6">
                    <label class="fw-bold text-muted">Software</label>
                    <div class="data-box">{{ $customer->software }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Name</label>
                    <div class="data-box">{{ $customer->name }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Email</label>
                    <div class="data-box">{{ $customer->email }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Company</label>
                    <div class="data-box">{{ $customer->company_name }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Address</label>
                    <div class="data-box">{{ $customer->address }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Area</label>
                    <div class="data-box">{{ $customer->area }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">City</label>
                    <div class="data-box">{{ $customer->city }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Country</label>
                    <div class="data-box">{{ $customer->country }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Post Code</label>
                    <div class="data-box">{{ $customer->post_code }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Plan</label>
                    <div class="data-box">{{ $customer->plan }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold text-muted">Source</label>
                    <div class="data-box">{{ $customer->source }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Memo Section -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="fas fa-sticky-note text-secondary"></i> Plan Memo History
            </h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">SL</th>
                        <th>Remarks</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customerMemos as $key => $memo)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $memo['remarks'] ?? 'N/A' }}</td>
                            <td class="text-center">{{ $memo['date'] }}</td>
                            <td class="text-center">{{ $memo['time'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No memos found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .data-box {
            background-color: #f9f9f9;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 500;
            min-height: 40px;
            display: flex;
            align-items: center;
            border: 1px solid #e5e5e5;
        }
    </style>
@endsection
