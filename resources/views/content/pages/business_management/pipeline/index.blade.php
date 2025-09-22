@extends('layouts/contentNavbarLayout')

@section('title', 'Pipelines List')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div>
            <h3 class="mb-2 fw-bold">Pipeline List</h3>
        </div>

        <a href="{{ route('pipelines.create') }}" class="btn btn-success  d-flex align-items-center gap-2">
            <span>Add New</span>
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card mb-3 p-3">
        <form action="{{ route('pipelines.index') }}" method="GET" class="row g-2">
            <div class="col-md-2">
                <label class="form-label fw-bold">Pipeline Name</label>
                <select name="name" class="form-select">
                    <option value="">-- All Names --</option>
                    @foreach ($names as $name)
                        <option value="{{ $name }}" {{ request('name') == $name ? 'selected' : '' }}>
                            {{ ucfirst($name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Stage</label>
                <select name="stage" class="form-select">
                    <option value="">-- All Stages --</option>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage }}" {{ request('stage') == $stage ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $stage)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Apply Filter</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered" id="pipeline-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pipeline Name</th>
                        <th class="text-center">Total Deal Value</th>
                        <th class="text-center">No of Deals</th>
                        <th class="text-center">Stage</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pipelines as $pipeline)
                        <tr>
                            <td>{{ $pipeline->id }}</td>
                            <td>{{ ucfirst($pipeline->name) }}</td>
                            <td class="text-center">{{ number_format($pipeline->total_deal_value, 2) }} Tk</td>
                            <td class="text-center">{{ $pipeline->no_of_deals }}</td>
                            <td class="text-center">
                                {{ ucfirst(str_replace('_', ' ', $pipeline->stage)) }}
                            </td>
                            <td class="text-center">
                                <span {{ $pipeline->status == 'Active' ? 'badge-success' : 'badge-secondary' }}>
                                    {{ $pipeline->status }}
                                </span>
                            </td>
                            <td class="created-date text-center" data-date="{{ $pipeline->created_at }}"></td>
                            <td class="text-center">
                                <a href="{{ route('pipelines.show', $pipeline->id) }}" class="btn btn-info ">View</a>
                                <a href="{{ route('pipelines.edit', $pipeline->id) }}" class="btn btn-warning ">Edit</a>
                                <form action="{{ route('pipelines.destroy', $pipeline->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger "
                                        onclick="return confirm('Delete this lead?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateCells = document.querySelectorAll('.created-date');

            dateCells.forEach(cell => {
                const dateStr = cell.getAttribute('data-date');
                if (dateStr) {
                    const date = new Date(dateStr);
                    const options = {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    };
                    cell.textContent = date.toLocaleDateString('en-US', options); // e.g., 25 Sep 2025
                } else {
                    cell.textContent = '-';
                }
            });
        });
    </script>
@endsection
