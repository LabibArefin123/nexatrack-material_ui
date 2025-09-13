@extends('adminlte::page')

@section('title', 'Role | Create')

@section('content_header')
    <h1>Create New</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name">
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Assign Role</label>
                    <select name="role" id="role" class="form-control">
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="name" class="form-control" placeholder="Enter name">
                    @if($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('name')  }}</span>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
