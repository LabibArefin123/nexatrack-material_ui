@extends('layouts/contentNavbarLayout')

@section('title', 'Projects')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Projects</h3>
        <a href="{{ route('projects.create') }}" class="btn btn-sm btn-primary">+ Add Project</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $project->project_photo
                                    ? asset('uploads/images/projects/' . $project->project_photo)
                                    : asset('uploads/images/default.jpg') }}"
                                    alt="Project" width="40" height="40" class="rounded me-1">
                                {{ $project->name }}
                            </td>
                            <td>
                                <img src="{{ $project->client_image
                                    ? asset('uploads/images/project/client/' . $project->client_image)
                                    : asset('uploads/images/default.jpg') }}"
                                    alt="Client" width="40" height="40" class="rounded me-1">
                                {{ $project->client }}
                            </td>

                            <td>{{ ucfirst($project->priority) }}</td>
                            <td>{{ ucfirst($project->pipeline_stage) }}</td>
                            <td>
                                <span class="badge {{ $project->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $project->status }}
                                </span>
                            </td>
                            <td>{{ $project->start_date ?? '-' }}</td>
                            <td>{{ $project->end_date ?? '-' }}</td>
                            <td>
                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('projects.edit', $project->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
