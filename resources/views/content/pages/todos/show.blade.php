@extends('adminlte::page')

@section('title', 'Todo Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Todo Details</h1>
        <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning btn-sm">
            Edit
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body position-relative">

            {{-- Priority Badge --}}
            <span class="badge position-absolute p-2"
                style="top:10px; right:10px;
                   background-color: {{ $todo->priority == 1 ? '#dc3545' : ($todo->priority == 2 ? '#ffc107' : '#6c757d') }};
                   color:#fff; z-index:10;">
                {{ $todo->priority_text }}
            </span>

            <div class="card-header bg-primary text-white mb-3">
                <h3 class="mb-0">{{ $todo->title }}</h3>
            </div>

            <div class="row g-3">

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <input type="text" readonly class="form-control" value="{{ $todo->status_text }}"
                        style="background-color: #f8f9fa;">
                </div>

                {{-- Due Date --}}
                <div class="col-md-6">
                    <label class="form-label">Due Date</label>
                    <input type="text" readonly class="form-control"
                        value="{{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('d M Y') : '-' }}"
                        style="background-color: #f8f9fa;">
                </div>

                {{-- Category --}}
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" readonly class="form-control" value="{{ $todo->category ?? '-' }}"
                        style="background-color: #f8f9fa;">
                </div>

                {{-- Assigned To --}}
                <div class="col-md-6">
                    <label class="form-label">Assigned To</label>
                    <input type="text" readonly class="form-control" value="{{ $todo->user?->name ?? '-' }}"
                        style="background-color: #f8f9fa;">
                </div>

                {{-- Description (full width) --}}
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" readonly rows="4" style="background-color: #f8f9fa;">{{ $todo->description ?? '-' }}</textarea>
                </div>

            </div>
        </div>
    </div>
@stop
