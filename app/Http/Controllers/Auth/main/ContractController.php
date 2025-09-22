<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Contract;

class ContractController extends Controller
{
    /**
     * Display a listing of the contracts.
     */
    public function index(Request $request)
    {
        $query = Contract::query()->with('customer');

        // Filter by Contract Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by Customer
        if ($request->filled('customer_id')) {
            $query->where('client_id', $request->customer_id);
        }

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $contracts = $query->latest()->paginate(12);

        $customers = \App\Models\Customer::all();

        // Contract types list (for filter + readable names)
        $contractTypes = [
            'contracts_under_seal' => 'Contracts Under Seal',
            'implied_contracts'    => 'Implied Contracts',
            'executory_contracts'  => 'Executory Contracts',
            'voidable_contracts'   => 'Voidable Contracts',
        ];

        return view('content.pages.business_management.contract.index', compact('contracts', 'customers', 'contractTypes'));
    }


    /**
     * Show the form for creating a new contract.
     */
    public function create()
    {
        $clients = Customer::all();
        return view('content.pages.business_management.contract.create', compact('clients'));
    }

    /**
     * Store a newly created contract in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'client_id' => 'nullable|exists:customers,id',
            'type' => 'nullable|string|max:50',
            'value' => 'nullable|string',
            'attachment' => 'nullable|file|max:5120', // 5 MB
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Ymd_His') . '_contract.' . $extension;
            $file->move(public_path('uploads/contracts'), $filename);
            $data['attachment'] =  $filename;
        }

        Contract::create($data);

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully.');
    }


    /**
     * Display the specified contract.
     */
    public function show(Contract $contract)
    {
        return view('content.pages.business_management.contract.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified contract.
     */
    public function edit(Contract $contract)
    {
        $clients = Customer::all();
        return view('content.pages.business_management.contract.edit', compact('contract', 'clients'));
    }

    /**
     * Update the specified contract in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'client_id' => 'nullable|exists:customers,id',
            'type' => 'nullable|string|max:50',
            'value' => 'nullable|string|max:50',
            'attachment' => 'nullable|file|max:5120', // 5 MB
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($contract->attachment && file_exists(public_path($contract->attachment))) {
                unlink(public_path($contract->attachment));
            }

            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Ymd_His') . '_contract.' . $extension;
            $file->move(public_path('uploads/contracts'), $filename);
            $data['attachment'] =  $filename;
        }

        $contract->update($data);

        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully.');
    }


    /**
     * Remove the specified contract from storage.
     */
    public function destroy(Contract $contract)
    {
        if ($contract->attachment && file_exists(public_path('uploads/contracts/' . $contract->attachment))) {
            unlink(public_path('uploads/contracts/' . $contract->attachment));
        }
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully.');
    }
}
