@extends('layouts/contentNavbarLayout')

@section('title', 'Payments List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Payments List</h3>
        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-secondary">Back to Invoices</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
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
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
                            <td>#{{ $payment->invoice_id ?? '-' }}</td>
                            <td>
                                @if ($payment->client)
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $payment->client->image ? asset('uploads/images/organization/' . $payment->client->image) : asset('uploads/images/default.jpg') }}"
                                            alt="Client Image" width="50" height="30">
                                        {{ $payment->client->name ?? '-' }}
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
                            <td>{{ $payment->transaction_id ?? '-' }}</td>
                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}"
                                    class="btn btn-sm btn-warning">Show</a>
                                <a href="{{ route('payments.edit', $payment->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                        class="btn btn-sm btn-danger">
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
        </div>
    </div>
@endsection
