@extends('layouts/contentNavbarLayout')

@section('title', 'System Logs')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5>Application Logs</h5>
            <div>
                <form id="filterForm" class="d-flex gap-2" method="GET" action="{{ route('settings.logs') }}">
                    <select name="filter" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="3days" {{ ($filter ?? 'week') == '3days' ? 'selected' : '' }}>Last 3 days</option>
                        <option value="week" {{ ($filter ?? 'week') == 'week' ? 'selected' : '' }}>Last week</option>
                        <option value="month" {{ ($filter ?? 'week') == 'month' ? 'selected' : '' }}>Last month</option>
                        <option value="all" {{ ($filter ?? 'week') == 'all' ? 'selected' : '' }}>All</option>
                    </select>
                </form>
            </div>
        </div>

        <form method="POST" action="{{ route('settings.logs.delete') }}">
            @csrf
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 600px; overflow-y:auto;">
                        <table class="table table-striped table-sm mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 40px;"><input type="checkbox" id="selectAll"></th>
                                    <th style="width: 180px;">Date</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($errorLogs as $log)
                                    <tr>
                                        <td><input type="checkbox" name="dates[]" value="{{ $log['date'] }}"></td>
                                        <td>{{ $log['date'] }}</td>
                                        <td><code>{{ $log['message'] }}</code></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No logs found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-danger " onclick="return confirm('Delete selected logs?')">Delete
                    Selected</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        // Select All checkbox
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="dates[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
