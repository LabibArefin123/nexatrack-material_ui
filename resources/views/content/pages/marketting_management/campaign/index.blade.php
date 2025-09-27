@extends('layouts/contentNavbarLayout')

@section('title', 'Campaign List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h3 class="mb-2 fw-bold">Campaign Dashboard</h3>
        <a href="{{ route('campaigns.create') }}" class="btn btn-success  d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>+ Add New Campaign</span>
        </a>
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
