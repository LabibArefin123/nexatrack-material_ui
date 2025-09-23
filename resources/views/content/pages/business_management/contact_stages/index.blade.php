@extends('layouts/contentNavbarLayout')

@section('title', 'Contract Stages List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Contract Stages List</h3>
        <a href="{{ route('contact_stages.create') }}" class="btn btn-success">+ Add</a>
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
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stages as $stage)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $stage->title }}</td>
                            <td class="text-center">
                                @if ($stage->status === 'Active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ auth()->user()->getRoleNames()->first() ?? '-' }}
                            </td>


                            <td class="text-center">
                                {{ $stage->created_at ? $stage->created_at->format('d M Y, h:i A') : '-' }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('contact_stages.show', $stage->id) }}"
                                        class="btn btn-warning btn-sm">Show</a>
                                    <a href="{{ route('contact_stages.edit', $stage->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('contact_stages.destroy', $stage->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure to delete this stage?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No contract stages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $stages->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
