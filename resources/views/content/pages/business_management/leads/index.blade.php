@extends('layouts/contentNavbarLayout')

@section('title', 'Leads List')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div>
            <h3 class="mb-2 fw-bold">Lead List</h3>

        </div>

        <a href="{{ route('leads.create') }}" class="btn btn-success  d-flex align-items-center gap-2">
            <span>Add New</span>
        </a>
    </div>

    <!-- Filter Form -->
    <div class="card mb-3 p-3">
        <form action="{{ route('leads.index') }}" method="GET" class="row g-2">

            <!-- Status Filter -->
            <div class="col-md-2">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Plan Filter -->
            <div class="col-md-2">
                <label class="form-label fw-bold">Plan</label>
                <select name="plan" class="form-select">
                    <option value="">All</option>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan }}" {{ request('plan') == $plan ? 'selected' : '' }}>
                            {{ ucfirst($plan) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Assigned To Filter -->
            <div class="col-md-2">
                <label class="form-label fw-bold">Assigned To</label>
                <select name="assigned_to" class="form-select">
                    <option value="">All</option>
                    @foreach ($assignedUsers as $user)
                        <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Apply + Reset -->
            <div class="col-md-3">
                <label class="form-label fw-bold invisible">Action</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Apply Filter</button>
                    <a href="{{ route('leads.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>

        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lead->customer->name ?? '-' }}</td>
                                <td>{{ $lead->customer->email ?? '-' }}</td>
                                <td>{{ $lead->customer->phone ?? '-' }}</td>
                                <td>
                                    <span class="" data-status="{{ $lead->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                    </span>
                                </td>
                                <td>{{ $lead->plan }}</td>
                                <td>{{ $lead->amount }} Tk</td>
                                <td>{{ $lead->assignedUser->name ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-info ">View</a>
                                        <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-warning ">Edit</a>
                                        <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger "
                                                onclick="return confirm('Delete this lead?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $leads->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- {{ $leads->links() }} --}}
@stop
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".status-badge").forEach(function(badge) {
                let status = badge.dataset.status;

                switch (status) {
                    case "contacted":
                        badge.classList.add("badge-success");
                        break;
                    case "not_contacted":
                        badge.classList.add("badge-warning");
                        break;
                    case "closed":
                        badge.classList.add("badge-primary");
                        break;
                    case "lost":
                        badge.classList.add("badge-danger");
                        break;
                    default:
                        badge.classList.add("badge-secondary");
                }
            });
        });
    </script>

@endsection
