@extends('layouts/contentNavbarLayout')

@section('title', 'Lead Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Lead Details</h3>
        <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Customer -->
                <div class="col-md-6 form-group">
                    <label>Customer</label>
                    <input type="text" class="form-control" value="{{ $lead->customer->name ?? 'N/A' }}" disabled>
                </div>

                <!-- Name -->
                <div class="col-md-6 form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ $lead->name }}" disabled>
                </div>

                <!-- Email -->
                <div class="col-md-6 form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" value="{{ $lead->email }}" disabled>
                </div>

                <!-- Phone -->
                <div class="col-md-6 form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" value="{{ $lead->phone }}" disabled>
                </div>

                <!-- Plan -->
                <div class="col-md-6 form-group">
                    <label>Plan</label>
                    <input type="text" class="form-control" value="{{ $lead->plan }}" disabled>
                </div>

                <!-- Assigned User -->
                <div class="col-md-6 form-group">
                    <label>Assigned User</label>
                    <input type="text" class="form-control" value="{{ $lead->assignedUser->name ?? 'N/A' }}" disabled>
                </div>

                <!-- Status -->
                <div class="col-md-6 form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($lead->status) }}" disabled>
                </div>

                <!-- Amount -->
                <div class="col-md-6 form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" value="{{ number_format($lead->amount, 2) }}" disabled>
                </div>
            </div>
        </div>
    </div>
@stop
