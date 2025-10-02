@extends('layouts/contentNavbarLayout')

@section('title', 'Deal List')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div>
            <h3 class="mb-2 fw-bold">Deal List</h3>
        </div>
        <a href="{{ route('deals.create') }}" class="btn btn-success  d-flex align-items-center gap-2">
            <span>Add New</span>
        </a>
    </div>

    <!-- Filter Form -->
    <div class="card mb-3 p-3">
        <form action="{{ route('deals.index') }}" method="GET" class="row g-2">
            <div class="col-md-2">
                <label class="form-label fw-bold">Deal Name</label>
                <select name="deal_name" class="form-select">
                    <option value="">-- All Deals --</option>
                    @foreach ($dealNames as $name)
                        <option value="{{ $name }}" {{ request('deal_name') == $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">Deal Stage</label>
                <select name="deal_stage" class="form-select">
                    <option value="">-- All Stages --</option>
                    @foreach (['new', 'create_stage', 'invoice', 'in_progress', 'final_invoice', 'deal_won', 'deal_lost', 'analyze_failure'] as $stage)
                        <option value="{{ $stage }}" {{ request('deal_stage') == $stage ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $stage)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">Source</label>
                <select name="source" class="form-select">
                    <option value="">-- All Sources --</option>
                    @foreach (['call', 'email', 'website', 'advertising', 'existing_client', 'by_recommendation', 'show_or_exhibition', 'crm_form', 'callback', 'sales_boost', 'online_store', 'other'] as $source)
                        <option value="{{ $source }}" {{ request('source') == $source ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $source)) }}</option>
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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="deals-table" style="width:20%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Stage</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Client</th>
                            <th>Company</th>
                            <th>Deal Type</th>
                            <th>Source</th>
                            <th>Responsible</th>
                            <th>Observer</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="deal-body">
                        @foreach ($deals as $index => $deal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $deal->name }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $deal->deal_stage)) }}</td>
                                <td>{{ number_format($deal->amount, 2) }}</td>
                                <td>{{ $deal->currency }}</td>
                                <td class="width: 50%">{{ \Carbon\Carbon::parse($deal->start_date)->format('d M Y') }}</td>
                                <td class="width: 50%">{{ \Carbon\Carbon::parse($deal->end_date)->format('d M Y') }}</td>
                                <td>{{ $deal->client_option }}</td>
                                <td>{{ $deal->company_option }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $deal->deal_type)) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $deal->source)) }}</td>
                                <td>
                                    @if (is_array($deal->responsibles))
                                        {{ implode(', ', \App\Models\User::whereIn('id', $deal->responsibles)->pluck('name')->toArray()) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if (is_array($deal->observer))
                                        @php
                                            $userIds = [];
                                            $customerIds = [];

                                            foreach ($deal->observer as $obs) {
                                                if (str_starts_with($obs, 'user_')) {
                                                    $userIds[] = (int) str_replace('user_', '', $obs);
                                                } elseif (str_starts_with($obs, 'customer_')) {
                                                    $customerIds[] = (int) str_replace('customer_', '', $obs);
                                                }
                                            }

                                            $userNames = \App\Models\User::whereIn('id', $userIds)
                                                ->pluck('name')
                                                ->map(fn($n) => 'User: ' . $n)
                                                ->toArray();
                                            $customerNames = \App\Models\Customer::whereIn('id', $customerIds)
                                                ->pluck('name')
                                                ->toArray();

                                            $obsNames = array_merge($userNames, $customerNames);
                                        @endphp
                                        {{ implode(', ', $obsNames) ?: '-' }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    {{ implode(' ', array_slice(explode(' ', strip_tags($deal->comment)), 0, 5)) }}
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('deals.show', $deal->id) }}" class="btn  btn-warning me-1">
                                            <i class="fas fa-edit">Show</i>
                                        </a>
                                        <a href="{{ route('deals.edit', $deal->id) }}" class="btn  btn-primary me-1">
                                            <i class="fas fa-edit">Edit</i>
                                        </a>
                                        <form action="{{ route('deals.destroy', $deal->id) }}" method="POST"
                                            style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn  btn-danger"><i
                                                    class="fas fa-trash"></i>Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="d-flex justify-content-end mt-3">
                    {{ $deals->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@stop
