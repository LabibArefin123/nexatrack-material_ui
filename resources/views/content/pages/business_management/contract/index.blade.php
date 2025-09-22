@extends('layouts/contentNavbarLayout')

@section('title', 'Contracts List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Contracts List</h3>
        <a href="{{ route('contracts.create') }}" class="btn  btn-success">Add New Contract</a>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                {{-- Customer --}}
                <div class="col-md-3">
                    <select name="customer_id" class="form-control">
                        <option value="">-- Select Customer --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Type --}}
                <div class="col-md-3">
                    <select name="type" class="form-control">
                        <option value="">-- Contract Type --</option>
                        <option value="contracts_under_seal"
                            {{ request('type') == 'contracts_under_seal' ? 'selected' : '' }}>Contracts Under Seal</option>
                        <option value="implied_contracts" {{ request('type') == 'implied_contracts' ? 'selected' : '' }}>
                            Implied Contracts</option>
                        <option value="executory_contracts"
                            {{ request('type') == 'executory_contracts' ? 'selected' : '' }}>Executory Contracts</option>
                        <option value="voidable_contracts" {{ request('type') == 'voidable_contracts' ? 'selected' : '' }}>
                            Voidable Contracts</option>
                    </select>
                </div>

                {{-- Start Date --}}
                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>

                {{-- End Date --}}
                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- View Switch --}}
    <div class="d-flex justify-content-end mb-2">
        <button class="btn btn-outline-secondary  me-2" id="listViewBtn">List View</button>
        <button class="btn btn-outline-secondary " id="gridViewBtn">Grid View</button>
    </div>

    {{-- List/Grid Container --}}
    <div id="contractsContainer">
        {{-- Default List View --}}
        <div class="card shadow-sm" id="listView">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Customer</th>
                            <th>Contract Type</th>
                            <th>Value</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contracts as $contract)
                            <tr>
                                <td>{{ $contract->subject }}</td>
                                <td>{{ $contract->customer->name ?? '-' }}</td>
                                <td>{{ $contract->type_name }}</td>
                                <td>{{ number_format($contract->value) }} Tk</td>
                                <td>{{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('j F Y') : '-' }}
                                </td>
                                <td>{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('j F Y') : '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('contracts.show', $contract->id) }}" class="btn btn-warning">Show</a>
                                    <a href="{{ route('contracts.edit', $contract->id) }}"
                                        class="btn  btn-primary">Edit</a>
                                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No contracts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-end mt-3">
                    {{ $contracts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

        {{-- Grid View --}}
        <div class="row g-3 d-none" id="gridView">
            @forelse ($contracts as $contract)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $contract->subject }}</h5>
                            <p class="mb-1"><strong>Customer:</strong> {{ $contract->customer->name ?? '-' }}</p>
                            <p class="mb-1"><strong>Type:</strong> {{ $contract->type_name }}</p>
                            <p class="mb-1"><strong>Value:</strong> {{ number_format($contract->value) }} Tk</p>
                            <p class="mb-1"><strong>Start:</strong> {{ $contract->start_date }}</p>
                            <p class="mb-1"><strong>End:</strong> {{ $contract->end_date }}</p>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('contracts.show', $contract->id) }}" class="btn  btn-warning">Show</a>
                            <a href="{{ route('contracts.edit', $contract->id) }}" class="btn  btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted">No contracts found.</div>
            @endforelse

            <div class="d-flex justify-content-end mt-3">
                {{ $contracts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const listBtn = document.getElementById('listViewBtn');
        const gridBtn = document.getElementById('gridViewBtn');
        const listView = document.getElementById('listView');
        const gridView = document.getElementById('gridView');

        listBtn.addEventListener('click', () => {
            listView.classList.remove('d-none');
            gridView.classList.add('d-none');
        });

        gridBtn.addEventListener('click', () => {
            listView.classList.add('d-none');
            gridView.classList.remove('d-none');
        });
    </script>
@endsection
