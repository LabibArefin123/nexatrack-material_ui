@extends('layouts/contentNavbarLayout')

@section('title', 'Task Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Task Details</h3>
        <div>
            <a href="{{ route('tasks.edit', $task->id) }}" class="btn  btn-primary me-1">Edit</a>
            <a href="{{ route('tasks.index') }}" class="btn  btn-secondary">Back</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                {{-- Title --}}
                <div class="form-group col-md-6">
                    <label class="fw-bold">Title:</label>
                    <p class="form-control-plaintext">{{ $task->title }}</p>
                </div>

                {{-- Category --}}
                <div class="form-group col-md-6">
                    <label class="fw-bold">Category:</label>
                    <p class="form-control-plaintext">{{ $task->category ?? '-' }}</p>
                </div>

                {{-- Responsible Persons --}}
                <div class="form-group col-md-6">
                    <label class="fw-bold">Responsible Persons:</label>
                    <p class="form-control-plaintext">
                        {{ implode(', ',\App\Models\User::whereIn('id', $task->responsibles ?? [])->pluck('name')->toArray()) }}
                    </p>
                </div>

                {{-- Start Date --}}
                <div class="form-group col-md-6">
                    <label class="fw-bold">Start Date:</label>
                    <p class="form-control-plaintext">{{ $task->start_date?->format('d/m/Y') }}</p>
                </div>

                {{-- Due Date --}}
                <div class="form-group col-md-6">
                    <label class="fw-bold">Due Date:</label>
                    <p class="form-control-plaintext">{{ $task->due_date?->format('d/m/Y') }}</p>
                </div>

                {{-- Priority --}}
                <div class="form-group col-md-6">
                    <label class="fw-bold">Priority:</label>
                    <p class="form-control-plaintext">{{ $task->priority }}</p>
                </div>

                {{-- Status --}}
                <div class="form-group col-md-6">
                    <label class="fw-bold">Status:</label>
                    <p class="form-control-plaintext">{{ $task->status }}</p>
                </div>

                {{-- Tags --}}
                <div class="form-group col-md-6">
                    <label class="fw-bold">Tags:</label>
                    <div>
                        @if ($task->tags)
                            @foreach ($task->tags as $tag)
                                <span class="badge bg-info me-1">{{ $tag }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">No tags</span>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-group col-12">
                    <label class="fw-bold">Description:</label>
                    <div class="p-2 border rounded bg-light">
                        {!! nl2br(e($task->description)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
