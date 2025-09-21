@extends('layouts/contentNavbarLayout')

@section('title', 'Customer List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                    <h5 class="mb-0">Customer List</h5>
                    <div class="btn-group">

                        <a href="{{ route('customers.export.pdf') }}" class="btn btn-danger btn-sm">
                            <i class="ri-file-pdf-2-line me-1"></i> PDF
                        </a>
                        <a href="{{ route('customers.export.excel') }}" class="btn btn-success btn-sm">
                            <i class="ri-file-excel-2-line me-1"></i> Excel
                        </a>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
                            <i class="ri-user-add-line me-1"></i> Add Customer
                        </a>
                        @hasanyrole('admin|superadmin')
                            <button id="delete-selected" class="btn btn-sm btn-danger">
                                <i class="ri-delete-bin-line me-1"></i> Delete Selected
                            </button>
                        @endhasanyrole

                    </div>
                </div>

                <div class="card-body">
                    <!-- Search & Filter -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-10">
                            <input type="text" id="search" class="form-control" placeholder="Search customers...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="button" id="toggleFilter">Filter</button>
                        </div>
                    </div>

                    <div id="inlineFilterBox" class="card mt-3 shadow border-0 d-none">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="filter_field" class="form-control">
                                        <option value="">-- Select Field --</option>
                                        <option value="area">Area</option>
                                        <option value="city">City</option>
                                        <option value="country">Country</option>
                                        <option value="source">Source</option>
                                        <option value="software">Software</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="filter_value" class="form-control"
                                        placeholder="Filter value...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive mt-3">
                        <table id="customers-table" class="table table-bordered table-hover text-nowrap mb-0">
                            <thead>
                                <tr>
                                    @if (auth()->user()->hasAnyRole(['admin', 'superadmin']))
                                        <th>
                                            <input type="checkbox" id="select-all">
                                        </th>
                                    @endif
                                    <th>SL</th>
                                    <th>Software</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company Name</th>
                                    <th>Area</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Source</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            @php
                                // base colors (4 ta)
                                $highlightColors = ['table-danger', 'table-warning', 'table-info', 'table-success'];
                            @endphp

                            <tbody id="customer-body">
                                @foreach ($allContacts as $i => $customer)
                                    @php
                                        $highlightClass = '';
                                        if ($customer->memos->count() > 0 && !$customer->is_read) {
                                            // customer id diye fixed color select
                                            $highlightClass = $highlightColors[$customer->id % count($highlightColors)];
                                        }
                                    @endphp
                                    <tr data-id="{{ $customer->id }}" class="{{ $highlightClass }}">
                                        <td><input type="checkbox" class="select-customer" value="{{ $customer->id }}"></td>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $customer->software }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->company_name }}</td>
                                        <td>{{ $customer->area }}</td>
                                        <td>{{ $customer->city }}</td>
                                        <td>{{ $customer->country }}</td>
                                        <td>{{ $customer->source }}</td>
                                        <td>
                                            <a href="{{ route('customers.edit', $customer->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            @if (auth()->user()->hasRole('superadmin'))
                                                <form action="{{ route('customers.destroy', $customer->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('customer_memos.memo', $customer->id) }}"
                                                class="btn btn-sm btn-primary memo-btn">
                                                <i class="fas fa-sticky-note"></i> Memo
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $allContacts->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle filter
            $('#toggleFilter').click(function() {
                $('#inlineFilterBox').toggleClass('d-none');
            });

            // Select all checkboxes
            $('#select-all').on('change', function() {
                $('.select-customer').prop('checked', this.checked);
            });

            // Bulk delete
            $('#delete-selected').click(function() {
                let ids = [];
                $('.select-customer:checked').each(function() {
                    ids.push($(this).val());
                });

                if (ids.length === 0) {
                    alert("Please select at least one customer.");
                    return;
                }

                if (!confirm("Are you sure you want to delete selected customers?")) {
                    return;
                }

                $.ajax({
                    url: "{{ route('customers.deleteSelected') }}",
                    type: "POST",
                    data: {
                        ids: ids,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        alert(res.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Something went wrong!");
                    }
                });
            });

            // Live search & filter
            function fetchCustomers() {
                var search = $('#search').val();
                var field = $('#filter_field').val();
                var value = $('#filter_value').val();
                $.ajax({
                    url: "{{ route('customers.index') }}",
                    type: "GET",
                    data: {
                        q: search,
                        filter_field: field,
                        filter_value: value
                    },
                    success: function(res) {
                        var tbody = '';
                        $.each(res.data, function(i, customer) {
                            tbody += '<tr>' +
                                '<td><input type="checkbox" class="select-customer" value="' +
                                customer.id + '"></td>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + customer.software + '</td>' +
                                '<td>' + customer.name + '</td>' +
                                '<td>' + customer.email + '</td>' +
                                '<td>' + customer.phone + '</td>' +
                                '<td>' + customer.company_name + '</td>' +
                                '<td>' + customer.area + '</td>' +
                                '<td>' + customer.city + '</td>' +
                                '<td>' + customer.country + '</td>' +
                                '<td>' + customer.source + '</td>' +
                                '<td>' + customer.actions + '</td>' +
                                '</tr>';
                        });
                        $('#customer-body').html(tbody);
                    }
                });
            }

            $('#search, #filter_field, #filter_value').on('input change', fetchCustomers);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.memo-btn').on('click', function(e) {
                e.preventDefault();
                const row = $(this).closest('tr');
                const customerId = row.data('id');
                const url = `/customers/${customerId}/mark-read`;

                @if (auth()->user()->hasRole('superadmin'))
                    $.post(url, {
                            _token: '{{ csrf_token() }}'
                        })
                        .done(function(res) {
                            if (res.success) {
                                row.removeClass('table-danger'); // ✅ remove red color
                                window.location.href = row.find('.memo-btn').attr('href');
                            }
                        })
                        .fail(function() {
                            alert('Failed to mark as read');
                        });
                @else
                    window.location.href = row.find('.memo-btn').attr('href');
                @endif
            });
        });
    </script>

@endsection
