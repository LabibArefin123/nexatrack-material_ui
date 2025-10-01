@extends('layouts/contentNavbarLayout')

@section('title', 'Deal Report')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h3 class="mb-2 fw-bold">Deal Report</h3>
    </div>

    <!-- Filter Box -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('reports.deal') }}" method="GET" class="row g-2 align-items-end">

                <!-- Deal Stage -->
                <div class="col-md-auto">
                    <label class="form-label fw-bold"> Deal Stage</label>
                    <select name="deal_stage" class="form-select">
                        <option value="">All</option>
                        @foreach ($stages as $stage)
                            <option value="{{ $stage }}" {{ request('deal_stage') == $stage ? 'selected' : '' }}>
                                {{ ucfirst($stage) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Deal Type -->
                <div class="col-md-2">
                    <label class="form-label fw-bold">Filter by Deal Type</label>
                    <select name="deal_type" class="form-select">
                        <option value="">All</option>
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ request('deal_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Source -->
                <div class="col-md-2">
                    <label class="form-label fw-bold">Filter by Source</label>
                    <select name="source" class="form-select">
                        <option value="">All</option>
                        @foreach ($sources as $src)
                            <option value="{{ $src }}" {{ request('source') == $src ? 'selected' : '' }}>
                                {{ ucfirst($src) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div class="col-md-auto">
                    <label class="form-label fw-bold">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                        class="form-control">
                </div>
                <div class="col-md-auto">
                    <label class="form-label fw-bold">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                        class="form-control">
                </div>

                <!-- Actions -->
                <div class="col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-filter"></i> Apply
                    </button>
                    <a href="{{ route('reports.deal') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                    @if (auth()->user()->hasAnyRole(['superadmin', 'admin']))
                        <a href="{{ route('reports.deal.pdf', request()->all()) }}" target="_blank" class="btn btn-danger">
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
                            <th>Name</th>
                            <th>Stage</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Source</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($deals as $deal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $deal->name }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $deal->deal_stage)) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $deal->deal_type)) }}</td>
                                <td>{{ number_format($deal->amount) }}</td>
                                <td>{{ $deal->currency }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $deal->source)) }}</td>
                                <td>{{ $deal->start_date }}</td>
                                <td>{{ $deal->end_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No deal report found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="7" class="text-end">Total Deals:</td>
                            <td colspan="4">{{ $deals->count() }}</td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-end">Total Amount:</td>
                            <td colspan="4">{{ number_format($deals->sum('amount')) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    {{ $deals->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@stop
