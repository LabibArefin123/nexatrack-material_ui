<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::with('user');

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range (created_at)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Sort by due date if filter applied
        if ($request->filled('due_date_sort')) {
            $query->orderBy('due_date', $request->due_date_sort);
        } else {
            // Default: sort by priority (High -> Low)
            $query->orderBy('priority');
        }

        $todos = $query->get()->map(function ($todo) {
            $todo->due_date = $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('d M Y') : null;
            return $todo;
        });

        $total = $todos->count();
        $pending = $todos->where('status', 1)->count();
        $completed = $todos->where('status', 3)->count();

        return view('content.pages.workflow_management.todos.index', compact('todos', 'total', 'pending', 'completed'));
    }

    public function create()
    {
        $users = User::all();
        return view('content.pages.workflow_management.todos.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:1,2,3',
            'status' => 'required|in:1,2,3,4',
            'due_date' => 'required|date',
            'category' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        Todo::create($request->all());
        return redirect()->route('todos.index')->with('success', 'Todo created successfully.');
    }

    public function show(Todo $todo)
    {
        $todo->load('user'); // eager load assigned user
        return view('content.pages.workflow_management.todos.show', compact('todo'));
    }

    public function edit(Todo $todo)
    {
        $users = User::all();
        return view('content.pages.workflow_management.todos.edit', compact('todo', 'users'));
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:1,2,3',
            'status' => 'required|in:1,2,3,4',
            'due_date' => 'required|date',
            'category' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $todo->update($request->all());
        return redirect()->route('todos.index')->with('success', 'Todo updated successfully.');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['message' => 'No todos selected'], 400);
        }

        Todo::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Selected todos deleted successfully']);
    }
}
