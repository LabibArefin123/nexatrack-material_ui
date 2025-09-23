@extends('layouts/contentNavbarLayout')

@section('title', 'Proposals List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Proposals List</h3>
        <a href="{{ route('proposals.create') }}" class="btn btn-primary">+ Add New Proposal</a>
    </div>
    <div class="card mb-3 p-3">
        <form action="{{ route('proposals.index') }}" method="GET" class="row g-2">

            {{-- Status --}}
            <div class="col-md-2">
                <label for="status" class="form-label fw-bold">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                </select>
            </div>

            {{-- Start Date --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>

            {{-- End Date --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>

            {{-- Submit --}}
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
                        <th>Subject</th>
                        <th>Client</th>
                        <th>Project</th>
                        <th>Deal</th>
                        <th>Currency</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Tags</th>
                        <th>Date</th>
                        <th>Open Till</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposals as $proposal)
                        <tr>
                            <td>{{ $proposal->subject }}</td>
                            <td>{{ $proposal->customer->name ?? '-' }}</td>
                            <td>{{ $proposal->project->name ?? '-' }}</td>
                            <td>{{ $proposal->deal->name ?? '-' }}</td>
                            <td>{{ $proposal->currency ?? '-' }}</td>
                            <td>{{ ucfirst($proposal->status ?? '-') }}</td>
                            <td>
                                @php
                                    // Normalize to array safely
                                    if (is_array($proposal->assigned_to)) {
                                        $assignedUsers = $proposal->assigned_to;
                                    } elseif (is_string($proposal->assigned_to)) {
                                        $assignedUsers = json_decode($proposal->assigned_to ?? '[]', true);
                                    } else {
                                        $assignedUsers = [];
                                    }
                                @endphp

                                @if (!empty($assignedUsers) && is_array($assignedUsers))
                                    @foreach ($assignedUsers as $user_id)
                                        @php
                                            $user = \App\Models\User::find($user_id);
                                        @endphp
                                        <span class="badge bg-info">{{ $user->name ?? 'User' }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @php
                                    if (is_array($proposal->tags)) {
                                        $tags = $proposal->tags;
                                    } elseif (is_string($proposal->tags)) {
                                        $tags = json_decode($proposal->tags ?? '[]', true);
                                    } else {
                                        $tags = [];
                                    }
                                @endphp

                                @if (!empty($tags))
                                    @foreach ($tags as $tag)
                                        <span class="badge bg-info">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $proposal->date ? $proposal->date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $proposal->open_till ? $proposal->open_till->format('d/m/Y') : '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('proposals.edit', $proposal->id) }}"
                                        class="btn  btn-primary">Edit</a>
                                    <a href="{{ route('proposals.show', $proposal->id) }}"
                                        class="btn  btn-warning">Show</a>
                                    <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST"
                                        class="d-inline">
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
            <div class="d-flex justify-content-end mt-3">
                {{ $proposals->links('pagination::bootstrap-5') }}
            </div>
            @if ($proposals->isEmpty())
                <div class="text-center text-muted mt-3">No proposals found.</div>
            @endif
        </div>
    </div>
@stop
