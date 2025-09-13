@extends('adminlte::page')

@section('title', 'Campaign List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h1 class="mb-2 fw-bold">Campaign Dashboard</h1>
        <a href="{{ route('campaigns.create') }}" class="btn btn-success btn-sm d-flex align-items-center gap-2">
            <span>Add New Campaign</span>
        </a>
    </div>
@stop

@section('content')
    {{-- Top Summary Boxes --}}
    <div class="row mb-3">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $campaigns->count() }}</h3>
                    <p>Campaign</p>
                    <small>{{ $campaigns->sum('progress') / ($campaigns->count() ?: 1) }}% Progress</small>
                </div>
                <div class="icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $campaigns->sum('sent') }}</h3>
                    <p>Sent</p>
                </div>
                <div class="icon"><i class="fas fa-paper-plane"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $campaigns->sum('opened') }}</h3>
                    <p>Opened</p>
                </div>
                <div class="icon"><i class="fas fa-envelope-open"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $campaigns->sum('closed') }}</h3>
                    <p>Completed</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
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
            @include('pages.campaign.partials.table', [
                'campaigns' => $campaigns->where('status', 'Active'),
            ])
        </div>
        <div class="tab-pane fade" id="completed" role="tabpanel">
            @include('pages.campaign.partials.table', [
                'campaigns' => $campaigns->where('status', 'Completed'),
            ])
        </div>
        <div class="tab-pane fade" id="archived" role="tabpanel">
            @include('pages.campaign.partials.table', [
                'campaigns' => $campaigns->where('status', 'Archived'),
            ])
        </div>
    </div>
@stop
