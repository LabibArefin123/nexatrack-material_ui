@extends('layouts/contentNavbarLayout')

@section('title', 'Invoice List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Invoice List</h3>
        <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-success">Add New Invoice</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Client</th>
                        <th>Project</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Paid Amount</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td class="fw-bold">#{{ $invoice->invoice_id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $invoice->client_image ? asset('uploads/images/clients/' . $invoice->client_image) : 'uploads/images/default.jpg' }}"
                                        class="rounded-circle" width="40" height="40" alt="client">
                                    <span>{{ $invoice->client->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $invoice->project_image ? asset('uploads/images/projects/' . $invoice->project_image) : 'uploads/images/default.jpg' }}"
                                        class="rounded-circle" width="40" height="40" alt="project">
                                    <span>{{ $invoice->project->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>
                            <td>{{ number_format($invoice->amount, 0, '.', ',') }} Tk</td>
                            <td>{{ number_format($invoice->paid_amount, 0, '.', ',') }} Tk</td>
                            <td class="fw-bold">#{{ $invoice->transaction_id }}</td>
                            <td>
                                @php
                                    $statusClass = match (strtolower($invoice->status)) {
                                        'paid' => 'success',
                                        'unpaid' => 'danger',
                                        'partially paid' => 'warning',
                                        'overdue' => 'dark',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($invoice->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->id) }}"
                                    class="btn btn-sm btn-warning">Show</a>
                                <a href="{{ route('invoices.edit', $invoice->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
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
                            <td colspan="9" class="text-center text-muted">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
