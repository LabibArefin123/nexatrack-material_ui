@extends('layouts/contentNavbarLayout')

@section('title', 'Plan List')

@section('content')
    @php
        $query = request()->getQueryString();
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Left side -->
        <h3 class="mb-0">Plans List</h3>

        <!-- Right side buttons -->
        <div class="d-flex gap-2">
            <a href="{{ route('plans.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Plan
            </a>
            <a href="{{ route('plans.export.pdf') . '?' . $query }}" class="btn btn-outline-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('plans.export.excel') . '?' . $query }}" class="btn btn-outline-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>

            @if (auth()->user()->hasRole(['superadmin', 'admin']))
                <button type="button" id="delete-selected" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Delete Selected
                </button>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('plans.index') }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-2">
                    <label class="form-label fw-bold">Filter By Country</label>
                    <select name="country" class="form-select">
                        <option value="">-- All Countries --</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                {{ $country }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Filter By Plan</label>
                    <select name="plan" class="form-select">
                        <option value="">-- All Plans --</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan }}" {{ request('plan') == $plan ? 'selected' : '' }}>
                                {{ $plan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Filter By Software</label>
                    <select name="software" class="form-select">
                        <option value="">-- All Softwares --</option>
                        @foreach ($softwares as $software)
                            <option value="{{ $software }}" {{ request('software') == $software ? 'selected' : '' }}>
                                {{ $software }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Filter By Source</label>
                    <select name="source" class="form-select">
                        <option value="">-- All Sources --</option>
                        @foreach ($sources as $source)
                            <option value="{{ $source }}" {{ request('source') == $source ? 'selected' : '' }}>
                                {{ $source }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-success">Apply Filter</button>
                    <a href="{{ route('plans.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">

        <!-- Table -->
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-nowrap">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>SL</th>
                        <th>Software</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Address</th>
                        <th>Area</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Post Code</th>
                        <th>Plan</th>
                        <th>Source</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allContacts as $index => $plan)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox" name="ids[]" value="{{ $plan->id }}">
                            </td>

                            <td>{{ $index + 1 }}</td>
                            <td>{{ $plan->software }}</td>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->email }}</td>
                            <td>{{ $plan->phone }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $plan->company_name), 0, 2)) }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $plan->address), 0, 2)) }}</td>
                            <td>{{ $plan->area }}</td>
                            <td>{{ $plan->city }}</td>
                            <td>{{ implode(' ', array_slice(explode(' ', $plan->country), 0, 2)) }}</td>
                            <td>{{ $plan->post_code }}</td>
                            <td>{{ $plan->plan }}</td>
                            <td>{{ $plan->source }}</td>
                            <td>
                                <a href="{{ route('plans.edit', $plan->id) }}" class="btn  btn-outline-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('plans.show', $plan->id) }}" class="btn  btn-outline-primary">
                                    <i class="fas fa-eye"></i> Show
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center text-muted">No plans found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $allContacts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@stop
