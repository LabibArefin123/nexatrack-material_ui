@extends('layouts/contentNavbarLayout')

@section('title', 'Source List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Source List</h3>
        <a href="{{ route('sources.create') }}" class="btn btn-success">+ Add</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">SL</th>
                        <th>Title</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Created At</th>
                        <th width="220" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sources as $reason)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $reason->title }}</td>
                            <td class="text-center">
                                @if ($reason->status === 'Active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ auth()->user()->getRoleNames()->first() ?? '-' }}
                            </td>
                            <td class="text-center">
                                {{ $reason->created_at ? $reason->created_at->format('d M Y, h:i A') : '-' }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('sources.show', $reason->id) }}"
                                        class="btn btn-warning btn-sm">Show</a>
                                    <a href="{{ route('sources.edit', $reason->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('sources.destroy', $reason->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure to delete this reason?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No Source found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $sources->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
