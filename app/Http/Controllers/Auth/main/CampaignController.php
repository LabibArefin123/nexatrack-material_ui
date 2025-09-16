<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Pipeline;
use App\Models\Campaign;
use App\Models\Plan;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = Campaign::with(['pipeline'])->get();

        return view('content.pages.campaign.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pipelines = Pipeline::all();
        return view('content.pages.campaign.create', compact('pipelines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'pipeline_id' => 'nullable|exists:pipelines,id',
            'plan' => 'required|string',
            'total_members' => 'nullable|integer',
            'sent' => 'nullable|integer',
            'opened' => 'nullable|integer',
            'delivered' => 'nullable|integer',
            'closed' => 'nullable|integer',
            'unsubscribe' => 'nullable|integer',
            'bounced' => 'nullable|integer',
            'progress' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:Active,Completed,Archived',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Campaign::create($request->all());

        return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        return view('pages.campaign.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        $pipelines = Pipeline::all();
        $plans = Plan::all();

        return view('pages.campaign.edit', compact('campaign', 'pipelines', 'plans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'pipeline_id' => 'nullable|exists:pipelines,id',
            'plan_id' => 'nullable|exists:plans,id',
            'total_members' => 'nullable|integer',
            'sent' => 'nullable|integer',
            'opened' => 'nullable|integer',
            'delivered' => 'nullable|integer',
            'closed' => 'nullable|integer',
            'unsubscribe' => 'nullable|integer',
            'bounced' => 'nullable|integer',
            'progress' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:Active,Completed,Archived',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $campaign->update($request->all());

        return redirect()->route('campaigns.index')->with('success', 'Campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('campaigns.index')->with('success', 'Campaign deleted successfully.');
    }
}
