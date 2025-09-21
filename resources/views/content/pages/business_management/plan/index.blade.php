@extends('layouts/contentNavbarLayout')

@section('title', 'Plan List')

@section('content')
    @php
        $query = request()->getQueryString();
    @endphp

    <!-- Action Buttons -->
    <div class="d-flex flex-wrap gap-2 my-3">
        <a href="{{ route('plans.export.pdf') . '?' . $query }}" class="btn btn-outline-danger btn-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('plans.export.excel') . '?' . $query }}" class="btn btn-outline-success btn-sm">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('plans.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle"></i> Add New Plan
        </a>
        @if (auth()->user()->hasRole(['superadmin', 'admin']))
            <button type="button" id="delete-selected" class="btn btn-danger btn-sm">
                <i class="fas fa-trash-alt"></i> Delete Selected
            </button>
        @endif
    </div>

    <div class="card shadow-sm">
        <!-- Search & Filter -->
        <div class="card-header">
            <form method="GET" action="{{ route('plans.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-10">
                        <input type="search" name="q" class="form-control" placeholder="🔍 Search plans..."
                            value="{{ request('q') }}">
                    </div>
                    <div class="col-md-2 text-md-end text-center">
                        <button type="button" class="btn btn-outline-primary w-100" id="toggleFilter">
                            <i class="fas fa-filter"></i> Filters
                        </button>
                    </div>
                </div>

                <!-- Filter Box -->
                <div id="inlineFilterBox" class="card mt-3 border-0 shadow-sm d-none">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Apply Filters</h6>
                        <button type="button" class="btn-close"
                            onclick="inlineFilterBox.classList.add('d-none');"></button>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Filter By</label>
                                <select name="filter_field" id="filter_field" class="form-select">
                                    <option value="">-- Select Field --</option>
                                    @foreach (['area', 'city', 'country', 'source', 'software'] as $f)
                                        <option value="{{ $f }}"
                                            {{ request('filter_field') == $f ? 'selected' : '' }}>
                                            {{ ucfirst($f) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Select</label>
                                <select name="filter_value" id="filter_value" class="form-select">
                                    <option value="">-- Select --</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end justify-content-end">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check-circle"></i> Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

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
                            <td><input type="checkbox" name="selected[]" value="{{ $plan->id }}"></td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $plan->software }}</td>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->email }}</td>
                            <td>{{ $plan->phone }}</td>
                            <td>{{ $plan->company_name }}</td>
                            <td>{{ $plan->address }}</td>
                            <td>{{ $plan->area }}</td>
                            <td>{{ $plan->city }}</td>
                            <td>{{ $plan->country }}</td>
                            <td>{{ $plan->post_code }}</td>
                            <td>{{ $plan->plan }}</td>
                            <td>{{ $plan->source }}</td>
                            <td class="text-center">
                                <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
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

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterField = document.getElementById('filter_field');
            const filterValue = document.getElementById('filter_value');
            const toggleFilterBtn = document.getElementById('toggleFilter');
            const inlineFilterBox = document.getElementById('inlineFilterBox');

            toggleFilterBtn.addEventListener('click', () => inlineFilterBox.classList.toggle('d-none'));

            function loadFilterValues() {
                const field = filterField.value;
                if (!field) {
                    filterValue.innerHTML = '<option value="">-- Select --</option>';
                    return;
                }

                fetch(`{{ route('plans.index') }}?ajax=1&filter_field=${field}`)
                    .then(res => res.json())
                    .then(data => {
                        filterValue.innerHTML = '<option value="">-- Select --</option>';
                        data.forEach(val => {
                            const opt = document.createElement('option');
                            opt.value = val;
                            opt.text = val;
                            if (val == "{{ request('filter_value') }}") opt.selected = true;
                            filterValue.appendChild(opt);
                        });
                    });
            }

            filterField.addEventListener('change', loadFilterValues);
            if (filterField.value) loadFilterValues();
        });
    </script>
@stop
