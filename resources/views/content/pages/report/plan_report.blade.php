@extends('layouts/contentNavbarLayout')

@section('title', 'Plan Report')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Plan Report</h3>
    </div>

    <style>
        .plan-row td {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .plan-row td:hover {
            background-color: #ff9900 !important;
            color: #fff !important;
            font-weight: 500;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }
    </style>
    {{-- Filter --}}
    <div class="card mb-3 p-3">
        <form action="{{ route('reports.plan') }}" method="GET" class="row g-2">
            {{-- Filter by Plan --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Plan</label>
                <select name="plan" class="form-select">
                    <option value="">All Plans</option>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->plan }}" {{ request('plan') == $plan->plan ? 'selected' : '' }}>
                            {{ $plan->plan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter by Source --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Source</label>
                <select name="source" class="form-select">
                    <option value="">All Sources</option>
                    @foreach ($sources as $source)
                        <option value="{{ $source }}" {{ request('source') == $source ? 'selected' : '' }}>
                            {{ $source }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter by Software --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Software</label>
                <select name="software" class="form-select">
                    <option value="">All Softwares</option>
                    @foreach ($softwares as $software)
                        <option value="{{ $software }}" {{ request('software') == $software ? 'selected' : '' }}>
                            {{ $software }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter by Country --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Country</label>
                <select name="country" class="form-select">
                    <option value="">All Countries</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Date filters --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>

            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-success w-100">Apply Filter</button>
                @if (auth()->user()->hasAnyRole(['superadmin', 'admin']))
                    <a href="{{ route('reports.plan.pdf', request()->all()) }}" target="_blank" class="btn btn-danger">
                        Download PDF
                    </a>
                @endif
            </div>
        </form>
    </div>
    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>SL</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Company Name</th>
                        <th class="text-center">Area</th>
                        <th>City</th>
                        <th>Plan</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">Source</th>
                        <th class="text-center">Software</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $plan)
                        <tr class="plan-row" data-id="{{ $plan->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $plan->name), 0, 2)) }}</td>
                            <td>{{ $plan->email }}</td>
                            <td>{{ $plan->company_name }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $plan->area), 0, 2)) }}</td>
                            <td>{{ $plan->city }}</td>
                            <td>{{ $plan->plan }}</td>
                            <td>{{ $plan->country }}</td>
                            <td>{{ $plan->source }}</td>
                            <td>{{ $plan->software }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No plan report found.</td>
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

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".plan-row").forEach(function(row) {
                row.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    window.location.href = "{{ url('plans') }}/" + id;
                });
            });
        });
    </script>
@endsection
