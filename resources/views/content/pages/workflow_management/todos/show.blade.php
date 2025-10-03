@extends('layouts/contentNavbarLayout')

@section('title', 'View Todo')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Todo Details</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('todos.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">

                {{-- Title --}}
                <div class="col-md-6 form-group">
                    <label class="form-label fw-bold">Title:</label>
                    <p class="form-control">{{ $todo->title }}</p>
                </div>

                {{-- Priority --}}
                <div class="col-md-6 form-group">
                    <label class="form-label fw-bold">Priority:</label>
                    <p class="form-control">
                        @if ($todo->priority == 1)
                            High
                        @elseif ($todo->priority == 2)
                            Medium
                        @else
                            Low
                        @endif
                    </p>
                </div>

                {{-- Status --}}
                <div class="col-md-6 form-group">
                    <label class="form-label fw-bold">Status:</label>
                    <p class="form-control">
                        @switch($todo->status)
                            @case(1)
                                Pending
                            @break

                            @case(2)
                                In Progress
                            @break

                            @case(3)
                                Completed
                            @break

                            @case(4)
                                On Hold
                            @break
                        @endswitch
                    </p>
                </div>

                {{-- Due Date --}}
                <div class="col-md-6 form-group">
                    <label class="form-label fw-bold">Due Date:</label>
                    <p class="form-control">{{ \Carbon\Carbon::parse($todo->due_date)->format('d M Y') }}</p>
                </div>

                {{-- Category --}}
                <div class="col-md-6 form-group">
                    <label class="form-label fw-bold">Category:</label>
                    <p class="form-control">{{ $todo->category }}</p>
                </div>

                {{-- Assigned To --}}
                <div class="col-md-6 form-group">
                    <label class="form-label fw-bold">Assigned To:</label>
                    <p class="form-control">{{ $todo->assignedUser->name ?? 'N/A' }}</p>
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <label class="form-label fw-bold">Description:</label>
                    <p class="form-control">{{ $todo->description }}</p>
                </div>

            </div>
        </div>
    </div>
@endsection
