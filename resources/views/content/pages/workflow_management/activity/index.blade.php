@extends('layouts/contentNavbarLayout')

@section('title', 'All Activities')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">All Activities</h3>
        <a href="{{ route('activities.create') }}" class="btn btn-primary">Add New Activity</a>
    </div>

    <!-- Filter Form -->
    <div class="card mb-3 p-3">
        <form action="{{ route('activities.index') }}" method="GET" class="row g-2">

            <div class="col-md-2">
                <label class="form-label fw-bold">Activity Type</label>
                <select name="activity_type" class="form-select">
                    <option value="">-- All Types --</option>
                    @foreach ($activityTypes as $type)
                        <option value="{{ $type }}" {{ request('activity_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">Owner</label>
                <select name="owner_id" class="form-select">
                    <option value="">-- All Owners --</option>
                    @foreach (\App\Models\User::all() as $owner)
                        <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }}>
                            {{ $owner->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Apply Filter</button>
            </div>
        </form>

    </div>

    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Title</th>
                            <th>Activity Type</th>
                            <th>Due Date</th>
                            <th>Owner</th>
                            <th>Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activities as $activity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $activity->title }}</td>
                                <td>{{ ucfirst($activity->activity_type) }}</td>
                                <td>{{ $activity->due_date->format('d M Y, h:i a') }}</td>
                                <td>
                                    @if ($activity->owner)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $activity->owner->profile_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($activity->owner->name) }}"
                                                alt="{{ $activity->owner->name }}" class="rounded-circle me-2"
                                                width="35" height="35">
                                            <span>{{ $activity->owner->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">No Owner</span>
                                    @endif
                                </td>
                                <td>{{ $activity->created_at->format('d M Y, h:i a') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('activities.show', $activity->id) }}"
                                            class="btn btn-sm btn-secondary">Show</a>
                                        <a href="{{ route('activities.edit', $activity->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No activities found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
@endsection
