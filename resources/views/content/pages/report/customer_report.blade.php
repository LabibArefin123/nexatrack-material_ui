@extends('layouts/contentNavbarLayout')

@section('title', 'Customer Report')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Customer Report</h3>
    </div>

    <style>
        .customer-row td {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .customer-row td:hover {
            background-color: #ff9900 !important;
            color: #fff !important;
            font-weight: 500;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }
    </style>

    {{-- Filter + Company Name + Download PDF --}}
    <div class="card mb-3 p-3">
        <form action="{{ route('reports.customer') }}" method="GET" class="row g-2">
            <div class="col-md-3">
                <label class="form-label fw-bold">Customer</label>
                <select name="customer_id" class="form-select">
                    <option value="">All Customers</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Company Name</label>
                <input type="text" name="company_name" value="{{ request('company_name') }}" class="form-control"
                    placeholder="Search Company">
            </div>

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
                    <a href="{{ route('reports.customer.pdf', request()->all()) }}" target="_blank" class="btn btn-danger">
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
                        <th class="text-center">Country</th>
                        <th class="text-center">Source</th>
                        <th class="text-center">Software</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $customer)
                        <tr class="customer-row" data-id="{{ $customer->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $customer->name), 0, 2)) }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->company_name }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $customer->area), 0, 2)) }}</td>
                            <td>{{ $customer->city }}</td>
                            <td>{{ $customer->country }}</td>
                            <td>{{ $customer->source }}</td>
                            <td>{{ $customer->software }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No customer report found.</td>
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
            document.querySelectorAll(".customer-row").forEach(function(row) {
                row.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    window.location.href = "{{ url('customers') }}/" + id;
                });
            });
        });
    </script>
@endsection
