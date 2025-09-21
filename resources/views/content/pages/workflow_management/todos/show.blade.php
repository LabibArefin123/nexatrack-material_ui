@extends('layouts/contentNavbarLayout')

@section('title', 'Todo Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Todo Details</h1>
        <div>
            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('todos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body position-relative">

            {{-- Priority Badge --}}
            <span class="badge position-absolute p-2"
                style="top:10px; right:10px;
                         background-color: {{ $todo->priority == 1 ? '#dc3545' : ($todo->priority == 2 ? '#ffc107' : '#6c757d') }};
                         color:#fff; z-index:10;">
                {{ $todo->priority_text }}
            </span>

            <div class="card-header bg-primary text-white mb-3 rounded">
                <h3 class="mb-0">{{ $todo->title }}</h3>
            </div>

            <div class="row g-3">

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <input type="text" readonly class="form-control-plaintext border p-2 rounded bg-light"
                        value="{{ $todo->status_text }}">
                </div>

                {{-- Due Date --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Due Date</label>
                    <input type="text" readonly class="form-control-plaintext border p-2 rounded bg-light"
                        value="{{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('d M Y') : '-' }}">
                </div>

                {{-- Category --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Category</label>
                    <input type="text" readonly class="form-control-plaintext border p-2 rounded bg-light"
                        value="{{ $todo->category ?? '-' }}">
                </div>

                {{-- Assigned To --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Assigned To</label>
                    <input type="text" readonly class="form-control-plaintext border p-2 rounded bg-light"
                        value="{{ $todo->user?->name ?? '-' }}">
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <label class="form-label fw-bold">Description</label>
                    <textarea class="form-control border rounded bg-light" readonly rows="4">{{ $todo->description ?? '-' }}</textarea>
                </div>

            </div>
        </div>
    </div>
@endsection
