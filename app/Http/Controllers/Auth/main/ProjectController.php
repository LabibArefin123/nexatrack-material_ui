<?php

namespace App\Http\Controllers\Auth\main;

use App\Models\Project;
use App\Models\Customer;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Pipeline stage filter
        if ($request->filled('pipeline_stage')) {
            $query->where('pipeline_stage', $request->pipeline_stage);
        }

        // Date filters
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', Carbon::parse($request->start_date));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', Carbon::parse($request->end_date));
        }


        $projects = $query->with('customer') // customer load হবে
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $priorities = ['Low', 'Medium', 'High'];
        $pipelineStages = ['plan', 'design', 'develop', 'completed'];

        return view('content.pages.workflow_management.project.index', compact('projects', 'priorities', 'pipelineStages'));
    }

    public function create()
    {
        $customers = Customer::orderBy('software', 'asc')
            ->orderBy('name', 'asc')
            ->get();
        return view('content.pages.workflow_management.project.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'project_photo'  => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'client'         => 'required|integer|exists:customers,id',
            'priority'       => 'required|string',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'pipeline_stage' => 'required|string',
            'status'         => 'required|string',
            'icon'           => 'nullable|string',
        ]);

        $filePath = null;
        $destination = 'uploads/images/projects/';

        if (!file_exists(public_path($destination))) {
            mkdir(public_path($destination), 0777, true);
        }

        // File name pattern
        $filename = now()->format('d_m_Y_His') . '_project';

        // ✅ Priority 1: Base64 image from Toast Editor
        if ($request->filled('icon') && preg_match('/^data:image\/(\w+);base64,/', $request->icon, $type)) {
            $image = substr($request->icon, strpos($request->icon, ',') + 1);
            $image = base64_decode($image);
            $ext = strtolower($type[1]);
            $fullName = $filename . '.' . $ext;
            file_put_contents(public_path($destination . $fullName), $image);
            $filePath = $fullName;
        }
        // ✅ Priority 2: Normal file upload
        elseif ($request->hasFile('project_photo')) {
            $file = $request->file('project_photo');
            $fullName = $filename . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($destination), $fullName);
            $filePath = $fullName;
        }

        // ✅ Client Image auto fetch from Customer
        $customer = Customer::find($request->client);
        $clientImage = $customer && $customer->image
            ? $customer->image
            : 'uploads/images/default.jpg';

        // ✅ Save Project
        Project::create([
            'name'           => $validated['name'],
            'client'         => $validated['client'],
            'priority'       => $validated['priority'],
            'start_date'     => $validated['start_date'] ?? null,
            'end_date'       => $validated['end_date'] ?? null,
            'pipeline_stage' => $validated['pipeline_stage'],
            'status'         => $validated['status'],
            'project_photo'  => $filePath, // ensure path saved
            'client_image'   => $clientImage,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }


    public function show(Project $project)
    {
        return view('content.pages.workflow_management.project.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $customers = Customer::all(); // Add this
        return view('content.pages.workflow_management.project.edit', compact('project', 'customers'));
    }


    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'project_photo'  => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'client'         => 'required|string|max:255',
            'client_image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'priority'       => 'required|string',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'pipeline_stage' => 'required|string',
            'status'         => 'required|string',
        ]);

        // Handle Project Image update
        if ($request->hasFile('project_photo')) {
            $projectFile = $request->file('project_photo');
            $projectName = now()->format('Ymd_His') . '_project.' . $projectFile->getClientOriginalExtension();
            $projectPath = public_path('uploads/images/projects');
            if (!file_exists($projectPath)) {
                mkdir($projectPath, 0777, true);
            }
            $projectFile->move($projectPath, $projectName);
            $validated['project_photo'] = $projectName;
        }

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
