@extends('layouts/contentNavbarLayout')

@section('title', 'Customer Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <!-- Left: Title -->
        <h3 class="mb-0">Customer Details</h3>

        <!-- Right: Buttons -->
        <div class="d-flex" style="gap: 10px;">
            <a href="javascript:history.back()" class="btn btn-primary d-flex align-items-center gap-1">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Customer Info Card -->
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white fw-bold">Customer Information</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Software</label>
                            <div class="form-control">{{ $customer->software }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name</label>
                            <div class="form-control">{{ $customer->name }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="form-control">{{ $customer->email }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Company Name</label>
                            <div class="form-control">{{ $customer->company_name }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address</label>
                            <div class="form-control">{{ $customer->address }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Area</label>
                            <div class="form-control">{{ $customer->area }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">City</label>
                            <div class="form-control">{{ $customer->city }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Country</label>
                            <div class="form-control">{{ $customer->country }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Post Code</label>
                            <div class="form-control">{{ $customer->post_code }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Source</label>
                            <div class="form-control">{{ $customer->source }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Note</label>
                            <div class="form-control">{{ $customer->note }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Memo Card -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white fw-bold">Customer Memo Correspondence</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered mb-0">
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
                                        <td colspan="4" class="text-center text-muted">No customer memos yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .form-control {
            background-color: #f9f9f9;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-weight: 500;
            min-height: 45px;
            display: flex;
            align-items: center;
        }
    </style>
@endsection
