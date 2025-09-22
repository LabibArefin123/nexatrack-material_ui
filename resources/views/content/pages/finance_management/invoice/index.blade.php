@extends('layouts/contentNavbarLayout')

@section('title', 'Invoice List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Invoice List</h3>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">+ Add New Invoice</a>
    </div>

    <!-- Filter Form -->
    <div class="card mb-3 p-3">
        <form action="{{ route('invoices.index') }}" method="GET" class="row g-2">
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
                <label class="form-label fw-bold">Project</label>
                <select name="project_id" class="form-select">
                    <option value="">-- All Projects --</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="">-- All Status --</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
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

    <!-- Invoice Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
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
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">#{{ $invoice->invoice_id }}</td>
                            <td style="width: 40%">
                                <div class="d-flex align-items-center gap-2">
                                    @php
                                        $clientName = $invoice->client->name ?? null;
                                        $clientImage = 'uploads/images/default.jpg'; // default image
                                        $imageWidth = 40;
                                        $imageHeight = 40;
                                        $imageClass = 'img-thumbnail'; // default frame class
                                        $textStyle = ''; // default text style

                                        if ($clientName === 'TOTALOFFTEC') {
                                            $clientImage =
                                                'uploads/images/organization/01_09_2025_140557organization.png';
                                            $imageWidth = 30;
                                            $imageHeight = 20;
                                        } elseif ($clientName === 'Creative Tape Industries Ltd') {
                                            $clientImage =
                                                'uploads/images/organization/01_09_2025_143807organization.png';
                                            $imageWidth = 30;
                                            $imageHeight = 20;
                                        }
                                    @endphp

                                    <img src="{{ asset($clientImage) }}" class="{{ $imageClass }}"
                                        width="{{ $imageWidth }}" height="{{ $imageHeight }}" alt="client"
                                        style="object-fit: cover;">
                                    <span>{{ $clientName ?? 'N/A' }}</span>
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
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn  btn-warning">Show</a>
                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn  btn-primary">Edit</a>
                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
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
                            <td colspan="9" class="text-center text-muted">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
