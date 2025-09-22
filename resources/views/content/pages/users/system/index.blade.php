@extends('adminlte::page')

@section('title', 'System Users | List')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>System Users List</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add New User</a>
    </div>
@stop

@section('content')
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>SL</th>
                <th>User Name</th>
                <th>Role Name</th>
                <th>Email</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->getRoleNames()->first() ?? 'No Role' }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->createdBy->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $row->id) }}" class="btn  btn-warning">Edit</a>
                        <form action="{{ route('users.destroy', $row->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn  btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
