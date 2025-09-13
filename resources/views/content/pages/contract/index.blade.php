@extends('layouts/contentNavbarLayout')

@section('title', 'Contracts List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Contracts List</h3>
        <a href="{{ route('contracts.create') }}" class="btn btn-sm btn-success">Add New Contract</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Customer</th>
                        <th>Contract Type</th>
                        <th>Contract Value</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contracts as $contract)
                        <tr>
                            <td>{{ $contract->subject }}</td>
                            <td>{{ $contract->customer->name ?? '-' }}</td>
                            <td>{{ $contract->type }}</td>
                            <td>{{ $contract->value }} Tk</td>
                            <td>
                                {{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('j F Y') : '-' }}
                            </td>
                            <td>
                                {{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('j F Y') : '-' }}
                            </td>

                            <td>
                                <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('contracts.show', $contract->id) }}"
                                    class="btn btn-sm btn-warning">Show</a>
                                <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($contracts->isEmpty())
                <div class="text-center text-muted mt-3">No contracts found.</div>
            @endif
        </div>
    </div>
@stop
