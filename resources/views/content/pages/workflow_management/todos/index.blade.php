@extends('layouts/contentNavbarLayout')

@section('title', 'Todo List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Todo List</h1>
        <a href="{{ route('todos.create') }}" class="btn btn-primary">
            + Add Todo
        </a>
    </div>

    <div class="card mb-3 p-3 border shadow-sm">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-nowrap">

            <form class="d-flex align-items-end gap-3 flex-wrap m-0" method="GET">

                {{-- Priority --}}
                <div class="d-flex flex-column" style="min-width:150px;">
                    <label for="priority" class="form-label fw-bold mb-1">Priority</label>
                    <select id="priority" name="priority" class="form-select form-select-sm">
                        <option value="">All Priorities</option>
                        <option value="1" @if (request('priority') == 1) selected @endif>High</option>
                        <option value="2" @if (request('priority') == 2) selected @endif>Medium</option>
                        <option value="3" @if (request('priority') == 3) selected @endif>Low</option>
                    </select>
                </div>

                {{-- Status --}}
                <div class="d-flex flex-column" style="min-width:150px;">
                    <label for="status" class="form-label fw-bold mb-1">Status</label>
                    <select id="status" name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="1" @if (request('status') == 1) selected @endif>Pending</option>
                        <option value="2" @if (request('status') == 2) selected @endif>In Progress</option>
                        <option value="3" @if (request('status') == 3) selected @endif>Completed</option>
                        <option value="4" @if (request('status') == 4) selected @endif>On Hold</option>
                    </select>
                </div>

                {{-- Due Date Sort --}}
                <div class="d-flex flex-column" style="min-width:150px;">
                    <label for="due_date_sort" class="form-label fw-bold mb-1">Due Date</label>
                    <select id="due_date_sort" name="due_date_sort" class="form-select form-select-sm">
                        <option value="">Sort by</option>
                        <option value="asc" @if (request('due_date_sort') == 'asc') selected @endif>Oldest First</option>
                        <option value="desc" @if (request('due_date_sort') == 'desc') selected @endif>Latest First</option>
                    </select>
                </div>

                {{-- Start Date --}}
                <div class="d-flex flex-column" style="min-width:160px;">
                    <label for="start_date" class="form-label fw-bold mb-1">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                        class="form-control form-control-sm">
                </div>

                {{-- End Date --}}
                <div class="d-flex flex-column" style="min-width:160px;">
                    <label for="end_date" class="form-label fw-bold mb-1">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                        class="form-control form-control-sm">
                </div>

                {{-- Filter Button --}}
                <div class="d-flex flex-column">
                    <label class="form-label fw-bold mb-1 text-white">Filter</label>
                    <button class="btn btn-success">Apply Filter</button>
                </div>

            </form>

            {{-- Bulk Delete --}}
            <div class="d-flex flex-column">
                <label class="form-label fw-bold mb-1 text-white">Delete</label>
                <button id="bulkDeleteBtn" class="btn btn-danger ">Delete Selected</button>
            </div>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Todo List Table --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle" id="todoTable">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>SL</th>
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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ implode(' ', array_slice(explode(' ', $todo->title), 0, 3)) }}</td>
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
                                <td>
                                    <a href="{{ route('todos.edit', $todo) }}" class="btn  btn-primary">
                                        Edit
                                    </a>
                                    <a href="{{ route('todos.show', $todo) }}" class="btn  btn-info">
                                        View
                                    </a>
                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this todo?');"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn  btn-danger">
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
