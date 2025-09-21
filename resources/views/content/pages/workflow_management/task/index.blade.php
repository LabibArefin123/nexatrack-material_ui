@extends('layouts/contentNavbarLayout')

@section('title', 'Tasks List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Tasks List</h3>
        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-success">Add New Task</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
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
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-warning">Show</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
