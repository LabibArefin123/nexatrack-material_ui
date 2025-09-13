@extends('layouts/contentNavbarLayout')

@section('title', 'Plan List')

@section('content_header')
    @php
        $query = http_build_query(request()->only('filter_field', 'filter_value'));
    @endphp

    <div class="btn-group mt-2 mt-md-0">
        <a href="{{ route('plans.export.pdf') . '?' . $query }}" class="btn btn-danger btn-sm">PDF</a>
        <a href="{{ route('plans.export.excel') . '?' . $query }}" class="btn btn-success btn-sm">Excel</a>
        <a href="{{ route('plans.create') }}" class="btn btn-primary btn-sm">Add Plan</a>
        @if (auth()->user()->hasRole(['superadmin', 'admin']))
            <button type="button" id="delete-selected" class="btn btn-danger btn-sm ms-2">Delete Selected</button>
        @endif
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('plans.index') }}">
                <div class="row g-2">
                    <div class="col-md-10">
                        <input type="search" name="q" class="form-control" placeholder="Search plans..."
                            value="{{ request('q') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary w-100" id="toggleFilter">Filter</button>
                    </div>
                </div>

                <div id="inlineFilterBox" class="card mt-3 shadow border-0 d-none">
                    <div class="card-header d-flex justify-content-end">
                        <button type="button" class="btn-close"
                            onclick="inlineFilterBox.classList.add('d-none');"></button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Filter By</label>
                                <select name="filter_field" id="filter_field" class="form-control">
                                    <option value="">-- Select Field --</option>
                                    @foreach (['area', 'city', 'country', 'source', 'software'] as $f)
                                        <option value="{{ $f }}" {{ request('filter_field') == $f ? 'selected' : '' }}>
                                            {{ ucfirst($f) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Select</label>
                                <select name="filter_value" id="filter_value" class="form-control">
                                    <option value="">-- Select --</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end justify-content-end">
                                <button type="submit" class="btn btn-success">Apply Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0 mt-3">
            <table class="table table-bordered table-hover text-nowrap mb-0">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>SL</th>
                        <th>Software</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Area</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Post Code</th>
                        <th>Plan</th>
                        <th>Source</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allContacts as $index => $plan)
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
                            <td><a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-sm btn-primary">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
