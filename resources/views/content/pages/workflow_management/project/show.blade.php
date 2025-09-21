@extends('layouts/contentNavbarLayout')

@section('title', 'Project Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Project Details</h3>
        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">Edit</a>

    </div>

    <div class="row g-3">
        {{-- Left Side: Project Info --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Project Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control" value="{{ $project->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Client</label>
                        <input type="text" class="form-control" value="{{ $project->client }}" readonly>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Priority</label>
                            <input type="text" class="form-control" value="{{ ucfirst($project->priority) }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Pipeline Stage</label>
                            <input type="text" class="form-control" value="{{ ucfirst($project->pipeline_stage) }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <input type="text" class="form-control" value="{{ $project->status }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Priority</label>
                            <input type="text" class="form-control" value="{{ ucfirst($project->priority) }}" readonly>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Start Date</label>
                            <input type="text" class="form-control" value="{{ $project->start_date ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">End Date</label>
                            <input type="text" class="form-control" value="{{ $project->end_date ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side: Images --}}
        <div class="col-md-6">
            {{-- Project Image Card --}}
            <div class="card shadow-sm mb-3 text-center">
                <div class="card-header bg-success text-white">
                    Project Image
                </div>
                <div class="card-body">
                    <img src="{{ $project->project_photo
                        ? asset('uploads/images/projects/' . $project->project_photo)
                        : asset('uploads/images/default.jpg') }}"
                        alt="Project" class="img-fluid rounded" style="max-height:100px;">
                </div>
            </div>

            {{-- Client Image Card --}}
            <div class="card shadow-sm mb-3 text-center">
                <div class="card-header bg-info text-white">
                    Client Image
                </div>
                <div class="card-body">
                    <img src="{{ $project->client_image ? asset($project->client_image) : asset('uploads/images/default.jpg') }}"
                        alt="Client" class="img-fluid rounded" style="max-height:100px;">
                </div>
            </div>
        </div>
    </div>
@stop
