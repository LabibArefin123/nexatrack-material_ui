@extends('adminlte::page')

@section('title', 'Edit Todo')

@section('content_header')
    <h1>Edit Todo</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $todo->title) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Priority</label>
                            <select name="priority" class="form-control">
                                <option value="1" {{ $todo->priority == 1 ? 'selected' : '' }}>High</option>
                                <option value="2" {{ $todo->priority == 2 ? 'selected' : '' }}>Medium</option>
                                <option value="3" {{ $todo->priority == 3 ? 'selected' : '' }}>Low</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $todo->status == 1 ? 'selected' : '' }}>Pending</option>
                                <option value="2" {{ $todo->status == 2 ? 'selected' : '' }}>Inprogress</option>
                                <option value="3" {{ $todo->status == 3 ? 'selected' : '' }}>Completed</option>
                                <option value="4" {{ $todo->status == 4 ? 'selected' : '' }}>Onhold</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Due Date</label>
                            <input type="date" name="due_date" class="form-control"
                                value="{{ old('due_date', $todo->due_date) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control"
                                value="{{ old('category', $todo->category) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Assign To</label>
                            <select name="assigned_to" class="form-control">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $todo->assigned_to == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $todo->description) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Todo</button>
                </form>
            </div>
        </div>
    </div>
@stop
