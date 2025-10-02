@extends('layouts/contentNavbarLayout')

@section('title', 'Lead Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Lead Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bx bx-edit-alt"></i> Edit
            </a>
            <a href="{{ route('leads.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <!-- Customer -->
                <div class="col-md-6 form-group">
                    <label>Customer</label>
                    <input type="text" class="form-control" value="{{ $lead->customer->name ?? 'N/A' }}" readonly>
                </div>

                <!-- Name -->
                <div class="col-md-6 form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ $lead->name }}" readonly>
                </div>

                <!-- Email -->
                <div class="col-md-6 form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" value="{{ $lead->email }}" readonly>
                </div>

                <!-- Phone -->
                <div class="col-md-6 form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" value="{{ $lead->phone }}" readonly>
                </div>

                <!-- Plan -->
                <div class="col-md-6 form-group">
                    <label>Plan</label>
                    <input type="text" class="form-control" value="{{ $lead->plan }}" readonly>
                </div>

                <!-- Assigned User -->
                <div class="col-md-6 form-group">
                    <label>Assigned User</label>
                    <input type="text" class="form-control" value="{{ $lead->assignedUser->name ?? 'N/A' }}" readonly>
                </div>

                <!-- Status -->
                <div class="col-md-6 form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($lead->status) }}" readonly>
                </div>

                <!-- Amount -->
                <div class="col-md-6 form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" value="{{ number_format($lead->amount, 2) }}" readonly>
                </div>
            </div>
        </div>
    </div>
@stop
