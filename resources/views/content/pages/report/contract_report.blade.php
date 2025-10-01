@extends('layouts/contentNavbarLayout')

@section('title', 'Contract Report')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">Contract Report</h3>
    </div>

    {{-- Filter --}}
    <div class="card mb-3 p-3">
        <form action="{{ route('reports.contract') }}" method="GET" class="row g-2">

            {{-- Type --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Customer --}}
            <div class="col-md-3">
                <label class="form-label fw-bold">Customer</label>
                <select name="customer_id" class="form-select">
                    <option value="">All Customers</option>
                    @foreach ($customers as $id => $name)
                        <option value="{{ $id }}" {{ request('customer_id') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Start Date --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>

            {{-- End Date --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>

            {{-- Buttons --}}
            <div class="col-md-12 d-flex align-items-end gap-2 mt-2">
                <button type="submit" class="btn btn-success">Apply Filter</button>
                <a href="{{ route('reports.contract') }}" class="btn btn-secondary">Reset</a>
                @if (auth()->user()->hasAnyRole(['superadmin', 'admin']))
                    <a href="{{ route('reports.contract.pdf', request()->all()) }}" target="_blank" class="btn btn-danger">
                        Download PDF
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reportData as $contract)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $contract->subject }}</td>
                            <td>{{ $contract->customer->name ?? '-' }}</td>
                            <td>{{ $contract->type_name }}</td>
                            <td>{{ number_format($contract->value, 2) }}</td>
                            <td>{{ $contract->start_date }}</td>
                            <td>{{ $contract->end_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No contracts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $reportData->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
