@extends('layouts/contentNavbarLayout')

@section('title', 'Permissions List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Permissions List</h3>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input.</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Add Permission Form -->
            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add New Permission</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Enter permission name" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Permission</button>
                    </div>
                </div>
            </form>

            <!-- Permissions Table -->
            <table id="permissionsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Permission Name</th>
                        <th>Guard</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                            <td>
                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" type="submit"
                                        class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
