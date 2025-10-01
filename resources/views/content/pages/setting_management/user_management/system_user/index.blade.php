@extends('layouts/contentNavbarLayout')

@section('title', 'System Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">System User List</h3>
        <a href="{{ route('system_users.create') }}" class="btn btn-success">+ Add</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class="text-center">Role</th>
                            <th>Email</th>
                            <th>Phone </th>
                            <th class="text-center">Username</th>
                            @if (auth()->user()->hasRole('superadmin'))
                                <th class="text-center">Password</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="text-center">{{ $user->roles->pluck('name')->join(', ') }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'Not Provided' }}</td>
                                <td class="text-center">{{ $user->username ?? 'Not Provided' }}</td>
                                @if (auth()->user()->hasRole('superadmin'))
                                    <td class="text-center">{{ $user->plain_password ?? '********' }}</td>
                                @endif
                                <td>
                                    <a href="{{ route('system_users.show', $user->id) }}" class="btn btn-info me-2">View</a>
                                    <a href="{{ route('system_users.edit', $user->id) }}"
                                        class="btn btn-warning me-2">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@stop
