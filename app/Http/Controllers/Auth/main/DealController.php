<?php

namespace App\Http\Controllers\Auth\main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Deal;
use App\Models\Customer;
use App\Models\User;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Deal::query();

        // Filter by deal name
        if ($request->filled('deal_name')) {
            $query->where('name', $request->deal_name);
        }

        // Filter by deal_stage
        if ($request->filled('deal_stage')) {
            $query->where('deal_stage', $request->deal_stage);
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Filter by date range (created_at / end_date)
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $deals = $query->orderBy('end_date', 'asc')->paginate(15)->withQueryString();

        // Fetch unique deal names from Deal table for filter dropdown
        $dealNames = Deal::select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');

        return view('content.pages.business_management.deal.index', compact('deals', 'dealNames'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Customer::select('name')->distinct()->orderBy('name')->get();
        $customers = Customer::select('id', 'name', 'company_name')->get();

        $companiesByClient = [];
        foreach ($customers as $customer) {
            $clientName = $customer->name;
            $companyName = $customer->company_name;
            $companiesByClient[$clientName] ??= [];
            if (!in_array($companyName, $companiesByClient[$clientName])) {
                $companiesByClient[$clientName][] = $companyName;
            }
        }

        $users = User::all();

        // 👇 include customers also
        return view('content.pages.business_management.deal.create', compact('clients', 'users', 'companiesByClient', 'customers'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'deal_stage' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:5',
            'end_date' => 'required|date',
            'client_option' => 'required|string|max:255',
            'company_option' => 'nullable|string|max:255',
            'deal_type' => 'required|string',
            'source' => 'required|string|max:255',
            'source_information' => 'nullable|string',
            'start_date' => 'required|date',

            // responsible IDs (users only)
            'responsibles' => 'nullable|array',
            'responsibles.*' => 'nullable|integer|exists:users,id',

            // observers (can be "user_1" or "customer_5") → so string
            'observers' => 'nullable|array',
            'observers.*' => 'nullable|string',

            'comment' => 'nullable|string',
        ]);

        $deal = Deal::create([
            'name' => $request->name,
            'deal_stage' => $request->deal_stage,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'end_date' => $request->end_date,
            'client_option' => $request->client_option,
            'company_option' => $request->company_option,
            'deal_type' => $request->deal_type,
            'source' => $request->source,
            'source_information' => $request->source_information,
            'start_date' => $request->start_date,
            'responsibles' => $request->responsibles ?? [],
            'observer' => $request->observers ?? [],
            'comment' => $request->comment,
        ]);


        return redirect()->route('deals.index')->with('success', 'Deal created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $deal = Deal::findOrFail($id);

        $clients = Customer::select('name')->distinct()->get();
        $customers = Customer::select('id', 'name', 'company_name')->get();

        $companiesByClient = [];
        foreach ($customers as $customer) {
            $companiesByClient[$customer->name][] = $customer->company_name;
        }

        $users = User::all();

        return view('content.pages.business_management.deal.edit', compact(
            'deal',
            'clients',
            'companiesByClient',
            'users',
            'customers'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'deal_stage' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:5',
            'end_date' => 'required|date',
            'client_option' => 'required|string|max:255',
            'company_option' => 'nullable|string|max:255',
            'deal_type' => 'required|string',
            'source' => 'required|string|max:255',
            'source_information' => 'nullable|string',
            'start_date' => 'required|date',

            // ✅ responsibles must exist (user IDs only)
            'responsibles'   => 'nullable|array',
            'responsibles.*' => 'nullable|integer|exists:users,id',

            // ✅ observers can be user_X or customer_Y (string)
            'observers'   => 'nullable|array',
            'observers.*' => 'nullable|string',

            'comment' => 'nullable|string',
        ]);

        $deal->update([
            'name' => $request->name,
            'deal_stage' => $request->deal_stage,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'end_date' => $request->end_date,
            'client_option' => $request->client_option,
            'company_option' => $request->company_option,
            'deal_type' => $request->deal_type,
            'source' => $request->source,
            'source_information' => $request->source_information,
            'start_date' => $request->start_date,

            // ✅ save as JSON arrays (thanks to $casts in model)
            'responsibles' => $request->responsibles ?? [],
            'observer'     => $request->observers ?? [],

            'comment' => $request->comment,
        ]);

        return redirect()->route('deals.index')->with('success', 'Deal updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->delete();
        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully.');
    }
}
