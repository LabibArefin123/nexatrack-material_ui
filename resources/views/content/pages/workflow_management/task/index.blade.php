@extends('layouts/contentNavbarLayout')

@section('title', 'Tasks List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Tasks List</h3>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add New Task</a>
    </div>

    <!-- Filter Form -->
    <div class="card mb-3 p-3">
        <form action="{{ route('tasks.index') }}" method="GET" class="row g-2">

            <div class="col-md-2">
                <label class="form-label fw-bold">Priority</label>
                <select name="priority" class="form-select">
                    <option value="">-- Select Priority --</option>
                    <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="">-- Select Status --</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress
                    </option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
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

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Responsible Persons</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Tags</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->category ?? '-' }}</td>
                            <td>{{ implode(', ',\App\Models\User::whereIn('id', $task->responsibles ?? [])->pluck('name')->toArray()) }}
                            </td>
                            <td>{{ $task->start_date->format('d/m/Y') }}</td>
                            <td>{{ $task->due_date->format('d/m/Y') }}</td>
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->status }}</td>
                            <td>
                                @if ($task->tags)
                                    @foreach ($task->tags as $tag)
                                        <span class="badge bg-info">{{ $tag }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn  btn-primary">Edit</a>
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn  btn-warning">Show</a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn  btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
