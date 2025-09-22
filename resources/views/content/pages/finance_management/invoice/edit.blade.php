@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Invoice')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Invoice</h3>
        <a href="{{ route('invoices.index') }}" class="btn  btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Invoice ID <span class="text-danger">*</span></label>
                        <input type="text" name="invoice_id"
                            class="form-control @error('invoice_id') is-invalid @enderror"
                            value="{{ old('invoice_id', $invoice->invoice_id) }}">
                        @error('invoice_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Client --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Client</label>
                        <div class="d-flex gap-2">
                            <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
                                <option value="">Select Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $invoice->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('client_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bill To --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Bill To <span class="text-danger">*</span></label>
                        <input type="text" name="bill_to" class="form-control @error('bill_to') is-invalid @enderror"
                            value="{{ old('bill_to', $invoice->bill_to) }}">
                        @error('bill_to')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Ship To --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ship To <span class="text-danger">*</span></label>
                        <input type="text" name="ship_to" class="form-control @error('ship_to') is-invalid @enderror"
                            value="{{ old('ship_to', $invoice->ship_to) }}">
                        @error('ship_to')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Project --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Project</label>
                        <div class="d-flex gap-2">
                            <select name="project_id" class="form-control @error('project_id') is-invalid @enderror">
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ $invoice->project_id == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            <a href="{{ route('projects.create') }}" class="btn  btn-success">Add New</a>
                        </div>
                        @error('project_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount"
                            class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount', $invoice->amount) }}">
                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Currency <span class="text-danger">*</span></label>
                        <select name="currency" class="form-control @error('currency') is-invalid @enderror">
                            <option value="">Select Currency</option>
                            <option value="usd" {{ $invoice->currency == 'usd' ? 'selected' : '' }}>$</option>
                            <option value="bdt" {{ $invoice->currency == 'bdt' ? 'selected' : '' }}>৳</option>
                            <option value="inr" {{ $invoice->currency == 'inr' ? 'selected' : '' }}>₹</option>
                            <option value="gbp" {{ $invoice->currency == 'gbp' ? 'selected' : '' }}>£</option>
                        </select>
                        @error('currency')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Invoice Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date</label>
                        <input type="date" name="invoice_date"
                            class="form-control @error('invoice_date') is-invalid @enderror"
                            value="{{ old('invoice_date', $invoice->invoice_date) }}">
                        @error('invoice_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Open Till</label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                            value="{{ old('due_date', $invoice->due_date) }}">
                        @error('due_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-control @error('payment_method') is-invalid @enderror">
                            <option value="cash" {{ $invoice->payment_method == 'cash' ? 'selected' : '' }}>Cash
                            </option>
                            <option value="bank" {{ $invoice->payment_method == 'bank' ? 'selected' : '' }}>Bank
                                Transfer
                            </option>
                            <option value="card" {{ $invoice->payment_method == 'card' ? 'selected' : '' }}>Credit/Debit
                                Card</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partially paid" {{ $invoice->status == 'partially paid' ? 'selected' : '' }}>
                                Partially Paid</option>
                            <option value="overdue" {{ $invoice->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Transaction ID <span class="text-danger">*</span></label>
                        <input type="text" name="transaction_id"
                            class="form-control @error('transaction_id') is-invalid @enderror"
                            value="{{ old('transaction_id', $invoice->transaction_id) }}">
                        @error('transaction_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $invoice->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Invoice Items --}}
                <div class="mt-4">
                    <h5 class="fw-bold">Invoice Items</h5>
                    <table class="table table-bordered" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th width="120">Quantity</th>
                                <th width="120">Price</th>
                                <th width="120">Discount</th>
                                <th width="120">Amount</th>
                                <th width="50">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->items as $index => $item)
                                <tr>
                                    <td><input type="text" name="items[{{ $index }}][name]"
                                            class="form-control" value="{{ $item['name'] }}"></td>
                                    <td><input type="number" name="items[{{ $index }}][quantity]"
                                            class="form-control" value="{{ $item['quantity'] }}"></td>
                                    <td><input type="number" step="0.01" name="items[{{ $index }}][price]"
                                            class="form-control" value="{{ $item['price'] }}"></td>
                                    <td><input type="number" step="0.01" name="items[{{ $index }}][discount]"
                                            class="form-control" value="{{ $item['discount'] }}"></td>
                                    <td><input type="number" step="0.01" name="items[{{ $index }}][amount]"
                                            class="form-control" value="{{ $item['amount'] }}"></td>
                                    <td><button type="button" class="btn  btn-danger removeRow">X</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" id="addRow" class="btn  btn-success">+ Add New</button>
                </div>

                {{-- Notes --}}
                <div class="mt-4">
                    <label class="form-label fw-bold">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $invoice->notes) }}</textarea>
                </div>

                {{-- Terms --}}
                <div class="mt-3">
                    <label class="form-label fw-bold">Terms & Conditions</label>
                    <textarea name="terms" class="form-control" rows="3">{{ old('terms', $invoice->terms) }}</textarea>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update Invoice</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let rowIndex = {{ count($invoice->items) }};
        document.getElementById('addRow').addEventListener('click', function() {
            let table = document.querySelector('#itemsTable tbody');
            let newRow = `
    <tr>
        <td><input type="text" name="items[${rowIndex}][name]" class="form-control"></td>
        <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control"></td>
        <td><input type="number" step="0.01" name="items[${rowIndex}][price]" class="form-control"></td>
        <td><input type="number" step="0.01" name="items[${rowIndex}][discount]" class="form-control"></td>
        <td><input type="number" step="0.01" name="items[${rowIndex}][amount]" class="form-control"></td>
        <td><button type="button" class="btn  btn-danger removeRow">X</button></td>
    </tr>`;
            table.insertAdjacentHTML('beforeend', newRow);
            rowIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeRow')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection
