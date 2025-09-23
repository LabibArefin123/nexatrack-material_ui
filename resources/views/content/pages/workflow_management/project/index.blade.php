@extends('layouts/contentNavbarLayout')

@section('title', 'Projects')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Projects</h3>
        <a href="{{ route('projects.create') }}" class="btn  btn-primary">+ Add Project</a>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-3 p-3">
        <form action="{{ route('projects.index') }}" method="GET" class="row g-2">
            <div class="col-md-2">
                <label class="form-label fw-bold">Priority</label>
                <select name="priority" class="form-select">
                    <option value="">-- All Priorities --</option>
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                            {{ ucfirst($priority) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">Pipeline Stage</label>
                <select name="pipeline_stage" class="form-select">
                    <option value="">-- All Stages --</option>
                    @foreach ($pipelineStages as $stage)
                        <option value="{{ $stage }}" {{ request('pipeline_stage') == $stage ? 'selected' : '' }}>
                            {{ ucfirst($stage) }}
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

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Projects Table --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Priority</th>
                        <th>Pipeline Stage</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration + ($projects->currentPage() - 1) * $projects->perPage() }}</td>
                            <td>
                                <img src="{{ $project->project_photo
                                    ? asset('uploads/images/projects/' . $project->project_photo)
                                    : asset('uploads/images/default.jpg') }}"
                                    alt="Project" width="40" height="40" class="rounded me-1">
                                {{ $project->name }}
                            </td>
                            <td>
                                <img src="{{ $project->customer && $project->customer->image
                                    ? asset('uploads/images/project/client/' . $project->customer->image)
                                    : asset('uploads/images/default.jpg') }}"
                                    alt="Client" width="40" height="40" class="rounded me-1">
                                {{ $project->customer->name ?? 'N/A' }}
                            </td>
                            <td>{{ ucfirst($project->priority) }}</td>
                            <td>{{ ucfirst($project->pipeline_stage) }}</td>
                            <td>
                                <span class="badge {{ $project->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $project->status }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('projects.show', $project->id) }}" class="btn  btn-info">View</a>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn  btn-warning">Edit</a>
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this project?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn  btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@stop
