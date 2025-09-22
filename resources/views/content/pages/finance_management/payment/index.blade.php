@extends('layouts/contentNavbarLayout')

@section('title', 'Payments List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Payments List</h3>
        <a href="{{ route('invoices.index') }}" class="btn  btn-secondary">Back to Invoices</a>
    </div>

    <!-- Filter Form -->
    <div class="card mb-3 p-3">
        <form action="{{ route('payments.index') }}" method="GET" class="row g-2">
            <div class="col-md-2">
                <label class="form-label fw-bold">Client</label>
                <select name="client_id" class="form-select">
                    <option value="">-- All Clients --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">Payment Method</label>
                <select name="payment_method" class="form-select">
                    <option value="">-- All Methods --</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                    <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Apply Filter</button>
            </div>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Invoice ID</th>
                        <th>Client</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>#{{ $payment->invoice_id ?? '-' }}</td>
                            <td>
                                @if ($payment->client)
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $payment->client->image ? asset('uploads/images/organization/' . $payment->client->image) : asset('uploads/images/default.jpg') }}"
                                            alt="Client Image" width="50" height="30">
                                        {{ implode(' ', array_slice(explode(' ', $payment->client->name), 0, 2)) }}

                                    </div>
                                @elseif($payment->invoice && $payment->invoice->client)
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $payment->invoice->client->image ? asset('uploads/images/clients/' . $payment->invoice->client->image) : asset('uploads/images/default.jpg') }}"
                                            alt="Client Image" class="rounded-circle" width="30" height="30">
                                        {{ $payment->invoice->client->name ?? '-' }}
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ number_format($payment->amount, 2) }} Tk</td>
                            <td>{{ $payment ? \Carbon\Carbon::parse($payment->due_date)->format('d M Y') : '-' }}
                            </td>
                            <td>{{ ucfirst($payment->payment_method ?? '-') }}</td>
                            <td>#{{ $payment->transaction_id ?? '-' }}</td>
                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn  btn-warning">Show</a>
                                <a href="{{ route('payments.edit', $payment->id) }}" class="btn  btn-primary">Edit</a>
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                        class="btn  btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
