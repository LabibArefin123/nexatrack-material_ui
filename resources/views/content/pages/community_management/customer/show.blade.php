@extends('layouts/contentNavbarLayout')

@section('title', 'Customer Details')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <!-- Left: Title -->
        <h1 class="mb-0">Customer Details</h1>

        <!-- Right: Buttons -->
        <div class="d-flex" style="gap: 10px;">
            <a href="javascript:history.back()" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                Edit
            </a>
        </div>
    </div>
@stop


@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    {{-- customer Number --}}
                    <div class="form-group col-md-6">
                        <label class="text">Software</label>
                        <div class="data-box">{{ $customer->software }}</div>
                    </div>

                    {{-- Title --}}
                    <div class="form-group col-md-6">
                        <label class="text">Name</label>
                        <div class="data-box">{{ $customer->name }}</div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="text">Email</label>
                        <div class="data-box">{{ $customer->email }}</div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="text">Company Name</label>
                        <div class="data-box">{{ $customer->company_name }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text">Address</label>
                        <div class="data-box">{{ $customer->address }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text">Area Name</label>
                        <div class="data-box">{{ $customer->area }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text">City Name</label>
                        <div class="data-box">{{ $customer->city }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text">Country Name</label>
                        <div class="data-box">{{ $customer->country }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text">Post Code</label>
                        <div class="data-box">{{ $customer->post_code }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text">Source</label>
                        <div class="data-box">{{ $customer->source }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text">Note</label>
                        <div class="data-box">{{ $customer->note }}</div>
                    </div>

                    <div class="form-group col-md-12">
                        <strong>Customer Memo Correspondence</strong>

                        <table class="table table-striped table-hover table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">SL</th>
                                    <th>Remarks</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customerMemos as $key => $memo)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $memo['remarks'] ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $memo['date'] }}</td>
                                        <td class="text-center">{{ $memo['time'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No customer memos yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    @endsection

    @section('css')
        <style>
            .data-box {
                background-color: #f1f1f1;
                padding: 10px 15px;
                border-radius: 5px;
                font-weight: 500;
                min-height: 45px;
                display: flex;
                align-items: center;

            }
        </style>
    @endsection
