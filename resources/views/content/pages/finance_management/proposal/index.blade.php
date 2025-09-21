@extends('layouts/contentNavbarLayout')

@section('title', 'Proposals List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Proposals List</h3>
    <a href="{{ route('proposals.create') }}" class="btn btn-sm btn-success">Add New Proposal</a>
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
                                $assignedUsers = is_array($proposal->assigned_to)
                                    ? $proposal->assigned_to
                                    : json_decode($proposal->assigned_to, true);
                            @endphp
                            @if ($assignedUsers && is_array($assignedUsers))
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
                            @if ($proposal->tags)
                                @foreach (json_decode($proposal->tags, true) as $tag)
                                    <span class="badge bg-info">{{ $tag }}</span>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $proposal->date ? $proposal->date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $proposal->open_till ? $proposal->open_till->format('d/m/Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('proposals.edit', $proposal->id) }}"
                                class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('proposals.show', $proposal->id) }}"
                                class="btn btn-sm btn-warning">Show</a>
                            <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($proposals->isEmpty())
            <div class="text-center text-muted mt-3">No proposals found.</div>
        @endif
    </div>
</div>
@stop
