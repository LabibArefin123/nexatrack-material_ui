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
    public function index()
    {
        $contracts = Contract::latest()->get();
        return view('content.pages.business_management.contract.index', compact('contracts'));
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
