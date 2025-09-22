@extends('layouts/contentNavbarLayout')

@section('title', 'Estimated List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Estimated List</h3>
        <a href="{{ route('estimations.create') }}" class="btn  btn-success">Add New Estimate</a>
    </div>

    <div class="card mb-3 p-3">
        <form action="{{ route('estimations.index') }}" method="GET" class="row g-2">
            {{-- Deal Name --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Deal Name</label>
                <select name="deal_name" class="form-select">
                    <option value="">-- All Deals --</option>
                    @foreach ($allNames as $name)
                        <option value="{{ $name }}" {{ request('deal_name') == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div class="col-md-2">
                <label for="status" class="form-label fw-bold">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                </select>
            </div>

            {{-- Start Date --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>

            {{-- End Date --}}
            <div class="col-md-2">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>

            {{-- Submit --}}
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Apply Filter</button>
            </div>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Project</th>
                        <th>Estimation By</th>
                        <th>Estimate Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estimateds as $estimate)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $estimate->company->name ?? '' }}</td>
                            <td>{{ $estimate->amount ?? ('-')($estimate->currency) }}</td>
                            <td>{{ $estimate->project->name ?? '' }}</td>
                            <td>{{ $estimate->user->name ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($estimate->estimate_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($estimate->expiry_date)->format('d M Y') }}</td>
                            <td>{{ ucfirst($estimate->status ?? '-') }}</td>
                            <td>
                                <a href="{{ route('estimations.edit', $estimate->id) }}" class="btn  btn-primary">Edit</a>
                                <a href="{{ route('estimations.show', $estimate->id) }}" class="btn  btn-warning">Show</a>
                                <form action="{{ route('estimations.destroy', $estimate->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn  btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $estimateds->links('pagination::bootstrap-5') }}
            </div>

            @if ($estimateds->isEmpty())
                <div class="text-center text-muted mt-3">No estimate found.</div>
            @endif
        </div>
    </div>
@stop
