<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index(Request $request)
    {
        $query = Invoice::query();

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by project
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('due_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        $invoices = $query->latest()->paginate(15)->withQueryString();

        // Pass clients and projects for filter dropdowns
        $clients = Organization::select('id', 'name')->get();
        $projects = Project::select('id', 'name')->get();
        $statuses = ['paid', 'unpaid', 'partially paid', 'overdue'];

        return view('content.pages.finance_management.invoice.index', compact(
            'invoices',
            'clients',
            'projects',
            'statuses'
        ));
    }
    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $clients = Organization::all();
        $projects = Project::all();
        return view('content.pages.finance_management.invoice.create', compact('clients', 'projects'));
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
        return view('content.pages.finance_management.invoice.edit', compact('invoice', 'clients', 'projects'));
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
        return view('content.pages.finance_management.invoice.show', compact('invoice'));
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
