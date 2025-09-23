<?php

namespace App\Http\Controllers\Auth\main;

use App\Models\Lead;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lead::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        // Filter by assigned user
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $leads = $query->latest()->paginate(15)->withQueryString();

        // Dropdown data
        $statuses    = Lead::select('status')->distinct()->pluck('status');
        $plans       = Lead::select('plan')->distinct()->pluck('plan');
        $assignedUsers = \App\Models\User::select('id', 'name')->get();

        return view('content.pages.business_management.leads.index', compact('leads', 'statuses', 'plans', 'assignedUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $plans = Plan::all();
        $users = User::all();

        return view('content.pages.business_management.leads.create', compact('customers', 'plans', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'phone' => 'required|string',
            'customer_id' => 'required|exists:customers,id',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:contacted,not_contacted,closed,lost',
            'amount' => 'nullable|numeric',
        ]);

        Lead::create($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return view('content.pages.business_management.leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        $customers = Customer::all();
        $plans = Plan::all();
        $users = User::all();

        return view('content.pages.business_management.leads.edit', compact('lead', 'customers', 'plans', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'phone' => 'required|string',
            'customer_id' => 'required|exists:customers,id',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:contacted,not_contacted,closed,lost',
            'amount' => 'nullable|numeric',
        ]);

        $lead->update($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}
