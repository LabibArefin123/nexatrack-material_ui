@extends('layouts/contentNavbarLayout')

@section('title', 'Lead Report')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h3 class="mb-2 fw-bold">Lead Report</h3>
    </div>

    <!-- Filter Box -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('reports.lead') }}" method="GET" class="d-flex flex-wrap gap-3 align-items-end">

                <!-- Status -->
                <div>
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Plan -->
                <div>
                    <label class="form-label fw-bold">Plan</label>
                    <select name="plan" class="form-select">
                        <option value="">All</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan }}" {{ request('plan') == $plan ? 'selected' : '' }}>
                                {{ ucfirst($plan) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Assigned To -->
                <div>
                    <label class="form-label fw-bold">Assigned To</label>
                    <select name="assigned_to" class="form-select">
                        <option value="">All</option>
                        @foreach ($assignedUsers as $user)
                            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- Date Range -->
                <div>
                    <label class="form-label fw-bold">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div>
                    <label class="form-label fw-bold">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-filter"></i> Apply
                    </button>
                    <a href="{{ route('reports.lead') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                    @if (auth()->user()->hasAnyRole(['superadmin', 'admin']))
                        <a href="{{ route('reports.lead.pdf', request()->all()) }}" target="_blank" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Report Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Assigned To</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leads as $lead)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lead->customer->name ?? '-' }}</td>
                                <td>{{ $lead->customer->email ?? '-' }}</td>
                                <td>{{ $lead->customer->phone ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge 
                                    @if ($lead->status === 'contacted') bg-success 
                                    @elseif($lead->status === 'not_contacted') bg-warning 
                                    @elseif($lead->status === 'closed') bg-primary 
                                    @elseif($lead->status === 'lost') bg-danger 
                                    @else bg-secondary @endif">
                                        {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                    </span>
                                </td>
                                <td>{{ $lead->plan }}</td>
                                <td>{{ number_format($lead->amount) }} Tk</td>
                                <td>{{ $lead->assignedUser->name ?? '-' }}</td>
                                <td>{{ $lead->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No leads found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="6" class="text-end">Total Leads:</td>
                            <td colspan="3">{{ $leads->count() }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-end">Total Amount:</td>
                            <td colspan="3">{{ number_format($leads->sum('amount')) }} Tk</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    {{ $leads->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@stop
