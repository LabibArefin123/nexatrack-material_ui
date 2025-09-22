@extends('layouts/contentNavbarLayout')

@section('title', 'User Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h3 class="mb-0">User Details</h3>
        <button class="btn btn-warning  d-flex align-items-center gap-1" onclick="history.back()">
            <i class="fas fa-arrow-left mr-1"></i> Go Back
        </button>
    </div>
    <div class="container-fluid">

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 20%">Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone 1</th>
                                <td>{{ $user->phone ?? 'Not Provided' }}</td>
                            </tr>
                            <tr>
                                <th>User Role</th>
                                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
