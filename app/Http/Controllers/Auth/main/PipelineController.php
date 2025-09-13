<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Pipeline;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    // Display all pipelines
    public function index()
    {
        $pipelines = Pipeline::all();
        return view('content.pages.pipeline.index', compact('pipelines'));
    }

    // Show create form
    public function create()
    {
        return view('content.pages.pipeline.create');
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
        return view('content.pages.pipeline.show', compact('pipeline'));
    }

    // Show edit form
    public function edit(Pipeline $pipeline)
    {
        return view('content.pages.pipeline.edit', compact('pipeline'));
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
