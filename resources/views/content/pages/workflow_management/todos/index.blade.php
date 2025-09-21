@extends('layouts/contentNavbarLayout')

@section('title', 'Todo List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Todo List</h1>
        <a href="{{ route('todos.create') }}" class="btn btn-success">
            Add Todo
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Filters + Delete Selected (One Row - Always Inline) --}}
            <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-nowrap">

                <form class="d-flex align-items-center gap-2 flex-nowrap m-0" method="GET">
                    <select name="priority" class="form-select form-select-sm" style="min-width: 150px;">
                        <option value="">All Priorities</option>
                        <option value="1" @if (request('priority') == 1) selected @endif>High</option>
                        <option value="2" @if (request('priority') == 2) selected @endif>Medium</option>
                        <option value="3" @if (request('priority') == 3) selected @endif>Low</option>
                    </select>

                    <select name="status" class="form-select form-select-sm" style="min-width: 150px;">
                        <option value="">All Status</option>
                        <option value="1" @if (request('status') == 1) selected @endif>Pending</option>
                        <option value="2" @if (request('status') == 2) selected @endif>In Progress</option>
                        <option value="3" @if (request('status') == 3) selected @endif>Completed</option>
                        <option value="4" @if (request('status') == 4) selected @endif>On Hold</option>
                    </select>

                    <button class="btn btn-primary btn-sm">Filter</button>
                </form>

                <button id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                    Delete Selected
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
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todos->sortBy('priority') as $todo)
                            <tr>
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
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('todos.edit', $todo) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                    <a href="{{ route('todos.show', $todo) }}" class="btn btn-sm btn-info">
                                        View
                                    </a>
                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this todo?');"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
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
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Select all checkboxes
            $('#selectAll').on('click', function() {
                $('.selectItem').prop('checked', this.checked);
            });

            // Bulk delete
            $('#bulkDeleteBtn').on('click', function(e) {
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
                        success: function() {
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
@endsection
