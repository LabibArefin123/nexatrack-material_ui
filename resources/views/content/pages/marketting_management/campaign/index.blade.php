@extends('layouts/contentNavbarLayout')

@section('title', 'Campaign List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h3 class="mb-2 fw-bold">Campaign Dashboard</h3>
        <a href="{{ route('campaigns.create') }}" class="btn btn-success btn-sm d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Add New Campaign</span>
        </a>
    </div>

    {{-- Top Summary Cards --}}
    <div class="row mb-3">
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h4 class="fw-bold">{{ $campaigns->count() }}</h4>
                    <p class="mb-1">Campaign</p>

                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card text-center shadow-sm h-100 bg-success text-white">
                <div class="card-body">
                    <h4 class="fw-bold">{{ $campaigns->sum('sent') }}</h4>
                    <p class="mb-1">Sent</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card text-center shadow-sm h-100 bg-warning text-dark">
                <div class="card-body">
                    <h4 class="fw-bold">{{ $campaigns->sum('opened') }}</h4>
                    <p class="mb-1">Opened</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="card text-center shadow-sm h-100 bg-danger text-white">
                <div class="card-body">
                    <h4 class="fw-bold">{{ $campaigns->sum('closed') }}</h4>
                    <p class="mb-1">Completed</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" id="campaignTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#active" role="tab">Active
                Campaign</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="completed-tab" data-bs-toggle="tab" href="#completed" role="tab">Completed
                Campaign</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="archived-tab" data-bs-toggle="tab" href="#archived" role="tab">Archived Campaign</a>
        </li>
    </ul>

    <div class="tab-content" id="campaignTabContent">
        <div class="tab-pane fade show active" id="active" role="tabpanel">
            @include('content.pages.marketting_management.campaign.partials.table', [
                'campaigns' => $campaigns->where('status', 'Active'),
            ])
        </div>
        <div class="tab-pane fade" id="completed" role="tabpanel">
            @include('content.pages.marketting_management.campaign.partials.table', [
                'campaigns' => $campaigns->where('status', 'Completed'),
            ])
        </div>
        <div class="tab-pane fade" id="archived" role="tabpanel">
            @include('content.pages.marketting_management.campaign.partials.table', [
                'campaigns' => $campaigns->where('status', 'Archived'),
            ])
        </div>
    </div>
@endsection
