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
    public function index()
    {
        $tasks = Task::orderBy('id', 'asc')->get();
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
            'responsibles' => 'required',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'category' => $request->category,
            'responsibles' => is_array($request->responsibles) ? $request->responsibles : json_decode($request->responsibles, true),
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'tags' => $request->tags ? (is_array($request->tags) ? $request->tags : json_decode($request->tags, true)) : [],
            'priority' => $request->priority ?? 'Medium',
            'status' => $request->status ?? 'Pending',
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
