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
    public function index()
    {
        $leads = Lead::all();
        return view('content.pages.business_management.leads.index', compact('leads'));
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
