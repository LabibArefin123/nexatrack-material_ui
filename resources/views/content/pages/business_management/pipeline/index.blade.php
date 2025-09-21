@extends('layouts/contentNavbarLayout')

@section('title', 'Pipelines List')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div>
            <h3 class="mb-2 fw-bold">Pipeline List</h3>
        </div>

        <a href="{{ route('pipelines.create') }}" class="btn btn-success btn-sm d-flex align-items-center gap-2">
            <span>Add New</span>
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                        <th class="text-center">Created Date</th>
                        <th class="text-center">Status</th>
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
                            <td class="created-date text-center" data-date="{{ $pipeline->created_at }}"></td>
                            <td class="text-center">
                                <span {{ $pipeline->status == 'Active' ? 'badge-success' : 'badge-secondary' }}>
                                    {{ $pipeline->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pipelines.show', $pipeline->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('pipelines.edit', $pipeline->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pipelines.destroy', $pipeline->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
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
