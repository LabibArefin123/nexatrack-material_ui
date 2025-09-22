@extends('layouts/contentNavbarLayout')

@section('title', 'Payment Details')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Payment Details</h3>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary ">Back</a>
        </div>

        <!-- Card -->
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <div class="row">
                    <!-- Left content -->
                    <div class="col-md-8">
                        <h5 class="fw-bold mb-3">Invoice Information</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th class="w-25">Invoice ID:</th>
                                <td>#{{ $payment->invoice_id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Client Name:</th>
                                <td>{{ $payment->client->name ?? ($payment->client->name ?? 'N/A') }}</td>
                            </tr>
                            <tr>
                                <th>Amount:</th>
                                <td><span class="fw-bold text-success">{{ number_format($payment->amount, 2) }} Tk</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Due Date:</th>
                                <td>{{ $payment->due_date ? \Carbon\Carbon::parse($payment->due_date)->format('d M Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Payment Method:</th>
                                <td>{{ ucfirst($payment->payment_method ?? '-') }}</td>
                            </tr>
                            <tr>
                                <th>Transaction ID:</th>
                                <td>#{{ $payment->transaction_id ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Right logo -->
                    <div class="col-md-4 text-end">
                        <img src="{{ $payment->client->image
                            ? asset('uploads/images/organization/' . $payment->client->image)
                            : asset('uploads/images/default.jpg') }}"
                            alt="Organization Logo" class="img-fluid border rounded" style="max-height: 120px;">
                    </div>
                </div>

                <!-- Footer -->
                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4 small">
                    <span>© 2025 All Rights Reserved, <strong>Nexatrack</strong></span>

                    <style>
                        @font-face {
                            font-family: 'OnStage';
                            src: url('{{ asset('fonts/OnStage_Regular.ttf') }}') format('truetype');
                            font-weight: normal;
                            font-style: normal;
                        }

                        .footer-brand {
                            font-weight: normal;
                            /* normal font for main text */
                        }

                        .footer-brand .total {
                            font-family: 'OnStage', sans-serif;
                            font-weight: bold;
                            color: #ff9900;
                        }

                        .footer-brand .offtec {
                            font-family: 'OnStage', sans-serif;
                            font-weight: bold;
                            color: #d9d9d9;
                        }
                    </style>

                    <span class="footer-brand">
                        Design and Developed by
                        <span class="total">total</span><span class="offtec">offtec</span>
                    </span>
                </div>

            </div>
        </div>
    </div>
@endsection
