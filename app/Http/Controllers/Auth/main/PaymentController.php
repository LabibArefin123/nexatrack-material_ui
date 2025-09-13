<?php


namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Invoice;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['invoice.client', 'client'])->latest()->get();
        return view('content.pages.payment.index', compact('payments'));
    }

    // New method to copy invoice data to payment table
    public function syncInvoices()
    {
        $invoices = Invoice::all();
        $createdCount = 0;

        foreach ($invoices as $invoice) {
            // Check if payment already exists
            $exists = Payment::where('invoice_id', $invoice->id)->exists();
            if (!$exists) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'client_id' => $invoice->client_id,
                    'amount' => $invoice->amount,
                    'due_date' => $invoice->due_date,
                    'payment_method' => $invoice->payment_method ?? null,
                    'transaction_id' => $invoice->transaction_id ?? null,
                ]);
                $createdCount++;
            }
        }

        return redirect()->back()->with('success', "$createdCount payments synced from invoices.");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
