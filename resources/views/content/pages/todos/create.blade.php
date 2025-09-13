@extends('adminlte::page')

@section('title', 'Create Todo')

@section('content_header')
    <h1>Create Todo</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('todos.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Priority</label>
                            <select name="priority" class="form-control">
                                <option value="1">High</option>
                                <option value="2">Medium</option>
                                <option value="3">Low</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Pending</option>
                                <option value="2">Inprogress</option>
                                <option value="3">Completed</option>
                                <option value="4">Onhold</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Due Date</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Assign To</label>
                            <select name="assigned_to" class="form-control">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Create Todo</button>
                </form>
            </div>
        </div>
    </div>

@stop
