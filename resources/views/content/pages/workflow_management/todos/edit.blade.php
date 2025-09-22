@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Todo')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Todo</h1>
        <a href="{{ route('todos.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $todo->title) }}"
                            required>
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="col-md-6">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="1" @selected(old('priority', $todo->priority) == 1)>High</option>
                            <option value="2" @selected(old('priority', $todo->priority) == 2)>Medium</option>
                            <option value="3" @selected(old('priority', $todo->priority) == 3)>Low</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" @selected(old('status', $todo->status) == 1)>Pending</option>
                            <option value="2" @selected(old('status', $todo->status) == 2)>In Progress</option>
                            <option value="3" @selected(old('status', $todo->status) == 3)>Completed</option>
                            <option value="4" @selected(old('status', $todo->status) == 4)>On Hold</option>
                        </select>
                    </div>

                    {{-- Due Date --}}
                    <div class="col-md-6">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control"
                            value="{{ old('due_date', $todo->due_date) }}">
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control"
                            value="{{ old('category', $todo->category) }}">
                    </div>

                    {{-- Assign To --}}
                    <div class="col-md-6">
                        <label class="form-label">Assign To</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('assigned_to', $todo->assigned_to) == $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $todo->description) }}</textarea>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Todo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
