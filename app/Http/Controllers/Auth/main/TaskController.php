<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', ucfirst(strtolower($request->priority))); // normalize to 'Low', 'Medium', 'High'
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        $tasks = $query->orderBy('id', 'asc')->get();

        return view('content.pages.workflow_management.task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $users = User::all(); // Responsible persons
        return view('content.pages.workflow_management.task.create', compact('users'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'responsibles' => 'required',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'tags' => 'required',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Pending,In Progress,Completed',
            'description' => 'required|string',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'category' => $request->category,
            'responsibles' => json_decode($request->responsibles, true),
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'tags' => json_decode($request->tags, true),
            'priority' => $request->priority,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }


    /**
     * Show the form for editing the task.
     */
    public function edit(Task $task)
    {
        $users = User::all();
        return view('content.pages.workflow_management.task.edit', compact('task', 'users'));
    }

    /**
     * Update the task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'responsibles' => 'required',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);

        $task->update([
            'title' => $request->title,
            'category' => $request->category,
            'responsibles' => $request->responsibles ? json_decode($request->responsibles, true) : [],
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'tags' => $request->tags ? json_decode($request->tags, true) : [],
            'priority' => $request->priority ?? 'Medium',
            'status' => $request->status ?? 'Pending',
            'description' => $request->description,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }


    /**
     * Remove the task from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    /**
     * Display the specified task (optional show page).
     */
    public function show(Task $task)
    {
        $users = User::all();
        return view('content.pages.workflow_management.task.show', compact('task', 'users'));
    }
}
