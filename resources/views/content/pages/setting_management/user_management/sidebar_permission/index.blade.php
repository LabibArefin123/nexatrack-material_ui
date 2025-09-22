@extends('adminlte::page')

@section('title', 'View Permissions List')

@section('content_header')
    <h1>Sidebar Permissions List</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
            <!-- Add View Permission Form -->
            <form method="POST" action="{{ route('sidebar_permissions.store') }}">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add New View Access</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Role -->
                            <div class="form-group col-md-4">
                                <label for="role">Select Role <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">Choose role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- View -->
                            <div class="form-group col-md-4">
                                <label for="view_name">Select View <span class="text-danger">*</span></label>
                                <select name="view_name" class="form-control" required>
                                    <option value="">Choose view</option>
                                    @foreach ($viewList as $viewKey => $viewRoles)
                                        <option value="{{ $viewKey }}">{{ ucfirst(str_replace('_', ' ', $viewKey)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="form-group col-md-4">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="active" selected>Can See</option>
                                    <option value="inactive">Hidden</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>

            <!-- View Permissions Table -->
            <table id="viewPermissionsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Role</th>
                        <th>View Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($viewPermissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst(optional($permission->roleModel)->name) }}</td>

                            <td>{{ ucfirst(str_replace('_', ' ', $permission->view_name)) }}</td>
                            <td>
                                @if ($permission->status === 'active')
                                    <span class="badge bg-success">Can See</span>
                                @else
                                    <span class="badge bg-secondary">Hidden</span>
                                @endif
                            </td>
                            <td>

                                <form action="{{ route('sidebar_permissions.destroy', $permission->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure you want to delete this view access?')"
                                        type="submit" class="btn btn-danger ">
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

@section('js')
    <script>
        $(document).ready(function() {
            $('#viewPermissionsTable').DataTable();
        });
    </script>
@stop
