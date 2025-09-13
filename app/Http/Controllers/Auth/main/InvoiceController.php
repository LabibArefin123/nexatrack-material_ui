<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Project;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index()
    {
        $invoices = Invoice::latest()->get();
        return view('content.pages.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $clients = Organization::all();
        $projects = Project::all();
        return view('content.pages.invoice.create', compact('clients', 'projects'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_id' => 'required|string',
            'client_id' => 'required|exists:organizations,id',
            'bill_to' => 'required|string|max:255',
            'ship_to' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:10',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'transaction_id' => 'required|string',
            'description' => 'required|string',
            'items' => 'required|array',
            'items.*.name' => 'nullable|string',
            'items.*.quantity' => 'nullable|numeric',
            'items.*.price' => 'nullable|numeric',
            'items.*.discount' => 'nullable|numeric',
            'items.*.amount' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        $data['items'] = json_encode($data['items']); // JSON format

        Invoice::create($data);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        $clients = Organization::all();
        $projects = Project::all();
        $invoice->items = json_decode($invoice->items, true); // decode JSON to array
        return view('content.pages.invoice.edit', compact('invoice', 'clients', 'projects'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:organizations,id',
            'invoice_id' => 'required|string|max:255',
            'transaction_id' => 'required|string|max:255',
            'bill_to' => 'required|string|max:255',
            'ship_to' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:10',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'description' => 'required|string',
            'items' => 'required|array',
            'items.*.name' => 'nullable|string',
            'items.*.quantity' => 'nullable|numeric',
            'items.*.price' => 'nullable|numeric',
            'items.*.discount' => 'nullable|numeric',
            'items.*.amount' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        $data['items'] = json_encode($data['items']); // JSON format

        $invoice->update($data);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->items = json_decode($invoice->items, true); // decode JSON to array
        return view('content.pages.invoice.show', compact('invoice'));
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
