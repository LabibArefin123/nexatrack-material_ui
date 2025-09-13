@extends('layouts/contentNavbarLayout')

@section('title', 'Create Project')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Create Project</h3>
        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- Project Name --}}
                    <div class="col-md-6 form-group mb-3">
                        <label for="name">Project Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Client Name --}}
                    <div class="col-md-6 form-group mb-3">
                        <label for="client">Client Name <span class="text-danger">*</span></label>
                        <select name="client" id="client" class="form-control @error('client') is-invalid @enderror">
                            <option value="">-- Select Client --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('client', isset($project) ? $project->client : '') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->software }} → {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="col-md-6 form-group mb-3">
                        <label for="priority">Priority <span class="text-danger">*</span></label>
                        <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror">
                            <option value="">Select Priority</option>
                            <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Pipeline Stage --}}
                    <div class="col-md-6 form-group mb-3">
                        <label for="pipeline_stage">Pipeline Stage <span class="text-danger">*</span></label>
                        <select name="pipeline_stage" id="pipeline_stage"
                            class="form-control @error('pipeline_stage') is-invalid @enderror">
                            <option value="">Select Stage</option>
                            <option value="plan" {{ old('pipeline_stage') == 'plan' ? 'selected' : '' }}>Plan</option>
                            <option value="design" {{ old('pipeline_stage') == 'design' ? 'selected' : '' }}>Design
                            </option>
                            <option value="develop" {{ old('pipeline_stage') == 'develop' ? 'selected' : '' }}>Develop
                            </option>
                            <option value="completed" {{ old('pipeline_stage') == 'completed' ? 'selected' : '' }}>
                                Completed</option>

                        </select>
                        @error('pipeline_stage')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 form-group mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Select Status</option>
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-6 form-group mb-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                            class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- End Date --}}
                    <div class="col-md-6 form-group mb-3">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                            class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                        @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="iconInput" class="form-label">Upload Project Image <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="project_photo" id="iconInput"
                                class="form-control @error('project_photo') is-invalid @enderror" accept="image/*">
                            <input type="hidden" name="icon" id="iconData" />
                            @error('project_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Client Image Preview</label>
                        <div class="border p-2 rounded bg-light text-center">
                            <img id="clientImagePreview" src="{{ asset('uploads/images/default.jpg') }}"
                                alt="Client Image Preview" class="img-fluid" style="max-height: 150px; margin:auto;">
                        </div>
                        <small class="text-muted d-block">* Client image will be auto-fetched from Customer or
                            default.</small>
                    </div>

                    <!-- Preview -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Project Image Preview</label>
                        <div class="border p-2 rounded bg-light text-center">
                            <img id="imagePreview" src="{{ asset('uploads/images/no-image.png') }}" alt="Preview Image"
                                class="img-fluid" style="max-height: 150px; margin:auto;">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">Save</button>
            </form>
        </div>
    </div>
@stop
