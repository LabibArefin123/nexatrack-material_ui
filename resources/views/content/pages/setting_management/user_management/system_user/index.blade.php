@extends('layouts/contentNavbarLayout')

@section('title', 'System Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h3 class="mb-0">System Users</h3>
        <a href="{{ route('system_users.create') }}" class="btn btn-success btn-sm">
            Add
        </a>
    </div>

    <div class="card"> <!-- Wrap the table in a card to align with AdminLTE's layout -->
        <div class="card-body"> <!-- Remove extra padding -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0"> <!-- Add mb-0 to remove bottom margin -->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Phone 1</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'Not Provided' }}</td>
                                <td>{{ $user->username ?? 'Not Provided' }}</td>
                                <td>
                                    <a href="{{ route('system_users.show', $user->id) }}"
                                        class="btn btn-info btn-sm me-2">View</a> <!-- Add me-2 -->
                                    <a href="{{ route('system_users.edit', $user->id) }}"
                                        class="btn btn-warning btn-sm me-2">Edit</a> <!-- Add me-2 -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@stop
