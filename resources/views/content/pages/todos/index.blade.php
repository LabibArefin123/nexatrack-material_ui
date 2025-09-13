@extends('adminlte::page')

@section('title', 'Todo List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Todo List</h1>
        <a href="{{ route('todos.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle mr-1"></i> Add
        </a>
    </div>
@stop

@section('content')

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Bulk Delete / Sort --}}
            <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                <form class="d-flex gap-2 flex-wrap" method="GET">
                    <select name="priority" class="form-select form-select-sm">
                        <option value="">All Priorities</option>
                        <option value="1">High</option>
                        <option value="2">Medium</option>
                        <option value="3">Low</option>
                    </select>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="1">Pending</option>
                        <option value="2">In Progress</option>
                        <option value="3">Completed</option>
                    </select>
                    <button class="btn btn-primary btn-sm">Sort</button>
                </form>

                <button id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>

            {{-- Todo List Table --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle" id="todoTable">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Title</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todos->sortBy('priority') as $todo)
                            <tr class="align-middle">
                                <td><input type="checkbox" class="selectItem" value="{{ $todo->id }}"></td>
                                <td>{{ $todo->title }}</td>
                                <td>{{ $todo->due_date ?? 'N/A' }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        @if ($todo->priority == 1) bg-danger
                                        @elseif($todo->priority == 2) bg-warning
                                        @else bg-secondary @endif">
                                        {{ $todo->priority_text }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge 
                                        @if ($todo->status == 1) bg-warning
                                        @elseif($todo->status == 2) bg-info
                                        @elseif($todo->status == 3) bg-success
                                        @else bg-secondary @endif">
                                        {{ $todo->status_text }}
                                    </span>
                                </td>
                                <td>{{ $todo->user?->name ?? 'N/A' }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('todos.edit', $todo) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('todos.show', $todo) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No todos found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // Select all checkboxes
            $('#selectAll').click(function() {
                $('.selectItem').prop('checked', this.checked);
            });

            // Bulk delete
            $('#bulkDeleteBtn').click(function(e) {
                e.preventDefault();
                let ids = $('.selectItem:checked').map(function() {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    alert('Please select at least one todo to delete.');
                    return;
                }

                if (confirm('Are you sure you want to delete selected todos?')) {
                    $.ajax({
                        url: '{{ route('todos.delete_selected') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: ids,
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            // Reload page after delete
                            location.reload();
                        },
                        error: function() {
                            alert('Something went wrong.');
                        }
                    });
                }
            });

        });
    </script>
@stop
