@extends('layouts/contentNavbarLayout')

@section('title', 'View Pipeline')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Pipeline Details</h3>
        <a href="{{ route('pipelines.edit', $pipeline->id) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $pipeline->id }}</td>
                </tr>
                <tr>
                    <th>Pipeline Name</th>
                    <td>{{ ucfirst($pipeline->name) }}</td>
                </tr>
                <tr>
                    <th>Total Deal Value</th>
                    <td>{{ number_format($pipeline->total_deal_value, 2) }} Tk</td>
                </tr>
                <tr>
                    <th>No of Deals</th>
                    <td>{{ $pipeline->no_of_deals }}</td>
                </tr>
                <tr>
                    <th>Stage</th>
                    <td>{{ ucfirst(str_replace('_', ' ', $pipeline->stage)) ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span {{ $pipeline->status == 'Active' ? 'badge-success' : 'badge-secondary' }}>
                            {{ $pipeline->status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Created Date</th>
                    <td>{{ $pipeline->created_at->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
