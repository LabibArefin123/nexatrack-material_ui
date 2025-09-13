@extends('layouts/contentNavbarLayout')

@section('title', 'Invoice Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Invoice #{{ $invoice->id }}</h3>
        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">Edit</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-bold">Invoice ID</label>
                    <input type="text" class="form-control" value="{{ $invoice->invoice_id }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Client</label>
                    <input type="text" class="form-control" value="{{ $invoice->client->name ?? '' }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Bill To</label>
                    <input type="text" class="form-control" value="{{ $invoice->bill_to }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Ship To</label>
                    <input type="text" class="form-control" value="{{ $invoice->ship_to }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Project</label>
                    <input type="text" class="form-control" value="{{ $invoice->project->name ?? '' }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Amount</label>
                    <input type="text" class="form-control" value="{{ $invoice->amount }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Currency</label>
                    <input type="text" class="form-control" value="{{ strtoupper($invoice->currency) }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Date</label>
                    <input type="text" class="form-control" value="{{ $invoice->invoice_date }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Open Till</label>
                    <input type="text" class="form-control" value="{{ $invoice->due_date }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Payment Method</label>
                    <input type="text" class="form-control" value="{{ ucfirst($invoice->payment_method) }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($invoice->status) }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Transaction ID</label>
                    <input type="text" class="form-control" value="{{ $invoice->transaction_id }}" readonly>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Description</label>
                    <textarea class="form-control" rows="3" readonly>{{ $invoice->description }}</textarea>
                </div>
            </div>

            {{-- Invoice Items --}}
            <div class="mt-4">
                <h5 class="fw-bold">Invoice Items</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th width="120">Quantity</th>
                            <th width="120">Price</th>
                            <th width="120">Discount</th>
                            <th width="120">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ $item['price'] }}</td>
                                <td>{{ $item['discount'] }}</td>
                                <td>{{ $item['amount'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Notes --}}
            <div class="mt-4">
                <label class="form-label fw-bold">Notes</label>
                <textarea class="form-control" rows="2" readonly>{{ $invoice->notes }}</textarea>
            </div>

            {{-- Terms --}}
            <div class="mt-3">
                <label class="form-label fw-bold">Terms & Conditions</label>
                <textarea class="form-control" rows="3" readonly>{{ $invoice->terms }}</textarea>
            </div>
        </div>
    </div>
@endsection
