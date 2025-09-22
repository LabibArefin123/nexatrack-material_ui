@extends('layouts/contentNavbarLayout')

@section('title', 'Create Invoice')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Create Invoice</h3>
        <a href="{{ route('invoices.index') }}" class="btn  btn-secondary">Back</a>
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
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Invoice ID <span class="text-danger">*</span></label>
                        <input type="text" name="invoice_id"
                            class="form-control @error('invoice_id') is-invalid @enderror" value="{{ old('invoice_id') }}">
                        @error('invoice_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Client --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Client <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2">
                            <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
                                <option value="">Select Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
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
                            value="{{ old('bill_to') }}">
                        @error('bill_to')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Ship To --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ship To <span class="text-danger">*</span></label>
                        <input type="text" name="ship_to" class="form-control @error('ship_to') is-invalid @enderror"
                            value="{{ old('ship_to') }}">
                        @error('ship_to')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Amount --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount"
                            class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Currency <span class="text-danger">*</span></label>
                        <select name="currency" class="form-control @error('currency') is-invalid @enderror">
                            <option value="">Select Currency</option>
                            <option value="usd">$</option>
                            <option value="bdt">৳</option>
                            <option value="inr">₹</option>
                            <option value="gbp">£</option>
                        </select>
                        @error('currency')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Invoice Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Invoice Date <span class="text-danger">*</span></label>
                        <input type="date" name="invoice_date"
                            class="form-control @error('invoice_date') is-invalid @enderror">
                        @error('invoice_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Due Date <span class="text-danger">*</span></label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror">
                        @error('due_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-control @error('payment_method') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="card">Credit/Debit Card</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Project --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Project <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2">
                            <select name="project_id" class="form-control @error('project_id') is-invalid @enderror">
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('projects.create') }}" class="btn  btn-success">Add New</a>
                        </div>
                        @error('project_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Transaction ID --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Transaction ID <span class="text-danger">*</span></label>
                        <input type="text" name="transaction_id" value="{{ old('transaction_id') }}"
                            class="form-control @error('transaction_id') is-invalid @enderror">
                        @error('transaction_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partially paid" {{ old('status') == 'partially paid' ? 'selected' : '' }}>
                                Partially Paid</option>
                            <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
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
                            <tr>
                                <td><input type="text" name="items[0][name]" class="form-control"></td>
                                <td><input type="number" name="items[0][quantity]" class="form-control"></td>
                                <td><input type="number" step="0.01" name="items[0][price]" class="form-control">
                                </td>
                                <td><input type="number" step="0.01" name="items[0][discount]" class="form-control">
                                </td>
                                <td><input type="number" step="0.01" name="items[0][amount]" class="form-control">
                                </td>
                                <td><button type="button" class="btn  btn-danger removeRow">X</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="addRow" class="btn  btn-success">+ Add New</button>
                </div>

                {{-- Notes --}}
                <div class="mt-4">
                    <label class="form-label fw-bold">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>

                {{-- Terms --}}
                <div class="mt-3">
                    <label class="form-label fw-bold">Terms & Conditions</label>
                    <textarea name="terms" class="form-control" rows="3"></textarea>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Save Invoice</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let rowIndex = 1;

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
