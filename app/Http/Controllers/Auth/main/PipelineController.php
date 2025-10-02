<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Pipeline;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    // Display all pipelines
    public function index(Request $request)
    {
        $query = Pipeline::query();

        // Filter by pipeline name
        if ($request->filled('name')) {
            $query->where('name', $request->name);
        }

        // Filter by stage
        if ($request->filled('stage')) {
            $query->where('stage', $request->stage);
        }

        // Filter by date range (created_at)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $pipelines = $query->latest()->paginate(15)->withQueryString();

        // Pass options for filters
        $names = Pipeline::select('name')->distinct()->pluck('name');
        $stages = Pipeline::select('stage')->distinct()->pluck('stage');

        return view('content.pages.business_management.pipeline.index', compact('pipelines', 'names', 'stages'));
    }

    // Show create form
    public function create()
    {
        return view('content.pages.business_management.pipeline.create');
    }

    // Store new pipeline
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_deal_value' => 'required|numeric',
            'no_of_deals' => 'required|integer',
            'stage' => 'required|in:win,in_pipeline,conversation,lost',
            'status' => 'required|in:Active,Inactive',
        ]);

        Pipeline::create($request->all());

        return redirect()->route('pipelines.index')->with('success', 'Pipeline created successfully.');
    }

    // Show single pipeline
    public function show(Pipeline $pipeline)
    {
        return view('content.pages.business_management.pipeline.show', compact('pipeline'));
    }

    // Show edit form
    public function edit(Pipeline $pipeline)
    {
        return view('content.pages.business_management.pipeline.edit', compact('pipeline'));
    }

    // Update existing pipeline
    public function update(Request $request, Pipeline $pipeline)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_deal_value' => 'required|numeric',
            'no_of_deals' => 'required|integer',
            'stage' => 'required|in:win,in_pipeline,conversation,lost',
            'status' => 'required|in:Active,Inactive',
        ]);

        $pipeline->update($request->all());

        return redirect()->route('pipelines.index')->with('success', 'Pipeline updated successfully.');
    }

    // Delete pipeline
    public function destroy(Pipeline $pipeline)
    {
        $pipeline->delete();

        return redirect()->route('pipelines.index')->with('success', 'Pipeline deleted successfully.');
    }
}
