@extends('layouts/contentNavbarLayout')

@section('title', 'Estimated List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Estimated List</h3>
        <a href="{{ route('estimations.create') }}" class="btn btn-sm btn-success">Add New Estimate</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Project</th>
                        <th>Estimation By</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estimateds as $estimate)
                        <tr>
                            <td>{{ $estimate->company->name ?? '' }}</td>
                            <td>{{ $estimate->amount ?? ('-')($estimate->currency) }}</td>
                            <td>{{ $estimate->project->name ?? '' }}</td>
                            <td>{{ $estimate->user->name ?? '' }}</td>

                            <td>{{ ucfirst($estimate->status ?? '-') }}</td>
                            <td>
                                <a href="{{ route('estimations.edit', $estimate->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('estimations.show', $estimate->id) }}"
                                    class="btn btn-sm btn-warning">Show</a>
                                <form action="{{ route('estimations.destroy', $estimate->id) }}" method="POST"
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

            @if ($estimateds->isEmpty())
                <div class="text-center text-muted mt-3">No estimate found.</div>
            @endif
        </div>
    </div>
@stop
