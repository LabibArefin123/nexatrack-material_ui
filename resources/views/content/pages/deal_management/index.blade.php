@extends('layouts/contentNavbarLayout')

@section('title', 'Deal List')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <div>
            <h3 class="mb-2 fw-bold">Deal List</h3>
        </div>
        <a href="{{ route('deals.create') }}" class="btn btn-success btn-sm d-flex align-items-center gap-2">
            <span>Add New</span>
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="search" class="form-control" placeholder="Search deals...">
                </div>
                <div class="col-md-4">
                    <select id="filter_field" class="form-control">
                        <option value="">-- Filter By --</option>
                        <option value="deal_stage">Stage</option>
                        <option value="currency">Currency</option>
                        <option value="deal_type">Deal Type</option>
                        <option value="source">Source</option>
                        <option value="client_option">Client</option>
                        <option value="company_option">Company</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" id="filter_value" class="form-control" placeholder="Filter value...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="deals-table" style="width:100%">
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
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $deal->name }}</td>
                                <td>{{ $deal->deal_stage }}</td>
                                <td>{{ number_format($deal->amount, 2) }}</td>
                                <td>{{ $deal->currency }}</td>
                                <td>{{ $deal->start_date }}</td>
                                <td>{{ $deal->end_date }}</td>
                                <td>{{ $deal->client_option }}</td>
                                <td>{{ $deal->company_option }}</td>
                                <td>{{ $deal->deal_type }}</td>
                                <td>{{ $deal->source }}</td>
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
                                            $obsNames = [];
                                            foreach ($deal->observer as $obs) {
                                                if (str_starts_with($obs, 'user_')) {
                                                    $id = str_replace('user_', '', $obs);
                                                    $user = \App\Models\User::find($id);
                                                    if ($user) {
                                                        $obsNames[] = 'User: ' . $user->name;
                                                    }
                                                } elseif (str_starts_with($obs, 'customer_')) {
                                                    $id = str_replace('customer_', '', $obs);
                                                    $customer = \App\Models\Customer::find($id);
                                                    if ($customer) {
                                                        $obsNames[] = $customer->name;
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ implode(', ', $obsNames) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ strip_tags($deal->comment) }}</td>
                                <td>
                                    <a href="{{ route('deals.edit', $deal->id) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit">Edit</i>
                                    </a>
                                    <form action="{{ route('deals.destroy', $deal->id) }}" method="POST"
                                        style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                class="fas fa-trash"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {

            function fetchDeals() {
                var search = $('#search').val();
                var field = $('#filter_field').val();
                var value = $('#filter_value').val();

                $.ajax({
                    url: "{{ route('deals.index') }}",
                    type: "GET",
                    data: {
                        q: search,
                        filter_field: field,
                        filter_value: value
                    },
                    success: function(res) {
                        var tbody = '';
                        $.each(res.data, function(i, deal) {
                            tbody += '<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + deal.name + '</td>' +
                                '<td>' + deal.deal_stage + '</td>' +
                                '<td>' + deal.amount + '</td>' +
                                '<td>' + deal.currency + '</td>' +
                                '<td>' + deal.start_date + '</td>' +
                                '<td>' + deal.end_date + '</td>' +
                                '<td>' + deal.client_option + '</td>' +
                                '<td>' + deal.company_option + '</td>' +
                                '<td>' + deal.deal_type + '</td>' +
                                '<td>' + deal.source + '</td>' +
                                '<td>' + deal.responsibles + '</td>' +
                                '<td>' + deal.observer + '</td>' +
                                '<td>' + deal.comment + '</td>' +
                                '<td>' + deal.action + '</td>' +
                                '</tr>';
                        });
                        $('#deal-body').html(tbody);
                    }
                });
            }

            // Trigger search/filter on input change
            $('#search, #filter_field, #filter_value').on('input change', function() {
                fetchDeals();
            });
        });
    </script>

@stop
