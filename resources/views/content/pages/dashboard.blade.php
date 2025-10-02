@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')
    <style>
        /* === Dashboard Card Style === */
        .dashboard-title {
            font-weight: 700;
            font-size: 1.8rem;
            color: #333;
        }

        .dashboard-subtitle {
            font-size: 1rem;
            color: #777;
        }

        .small-box {
            border-radius: 18px;
            padding: 20px;
            color: #fff !important;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.35s ease-in-out;
        }

        .small-box .inner h3 {
            font-size: 2.4rem;
            font-weight: bold;
        }

        .small-box .inner p {
            font-size: 1.1rem;
            margin: 0;
            font-weight: 500;
        }

        .small-box .icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 60px;
            opacity: 0.2;
            transition: all 0.3s ease-in-out;
        }

        .small-box:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .small-box:hover .icon {
            opacity: 0.35;
        }

        /* Gradient backgrounds */
        .bg-skyblue {
            background: linear-gradient(135deg, #36d1dc, #5b86e5);
        }

        .bg-skygreen {
            background: linear-gradient(135deg, #56ab2f, #a8e063);
        }

        .bg-cyan {
            background: linear-gradient(135deg, #06beb6, #48b1bf);
        }

        .bg-lightpink {
            background: linear-gradient(135deg, #ff758c, #ff7eb3);
        }

        .bg-purple {
            background: linear-gradient(135deg, #7f00ff, #e100ff);
        }

        .bg-orange {
            background: linear-gradient(135deg, #f7971e, #ffd200);
        }

        .bg-teal {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }

        .bg-grey {
            background: linear-gradient(135deg, #757f9a, #d7dde8);
            color: #222 !important;
        }
    </style>

    <h1 class="dashboard-title mb-1">Welcome to the Dashboard</h1>
    <p class="dashboard-subtitle mb-4">Your centralized hub for managing contact submissions with ease.</p>

    <div class="row g-4">
        {{-- BidTrack Users --}}
        <div class="col-md-6 col-lg-3">
            <div onclick="window.location='{{ route('customers.index', ['filter_field' => 'software', 'filter_value' => 'Bidtrack']) }}'"
                class="small-box bg-skyblue">
                <div class="inner">
                    <h3>{{ $totalBidTrackUsers }}</h3>
                    <p>BidTrack Users</p>
                </div>
                <div class="icon"><i class="fas fa-project-diagram"></i></div>
            </div>
        </div>

        {{-- TimeTrack Users --}}
        <div class="col-md-6 col-lg-3">
            <div onclick="window.location='{{ route('customers.index', ['filter_field' => 'software', 'filter_value' => 'Timetrack']) }}'"
                class="small-box bg-skygreen">
                <div class="inner">
                    <h3>{{ $totalTimeTrackUsers }}</h3>
                    <p>TimeTrack Users</p>
                </div>
                <div class="icon"><i class="fas fa-stopwatch"></i></div>
            </div>
        </div>

        {{-- Other Users --}}
        <div class="col-md-6 col-lg-3">
            <div onclick="window.location='{{ route('customers.index', ['filter_field' => 'software', 'filter_value' => 'other']) }}'"
                class="small-box bg-cyan">
                <div class="inner">
                    <h3>{{ $otherUsers }}</h3>
                    <p>Other Users</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>

        {{-- Total Users --}}
        <div class="col-md-6 col-lg-3">
            <div onclick="window.location='{{ route('customers.index') }}'" class="small-box bg-lightpink">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon"><i class="fas fa-layer-group"></i></div>
            </div>
        </div>

        {{-- BidTrack Plan Users --}}
        <div class="col-md-6 col-lg-3">
            <div onclick="window.location='{{ route('plans.index', ['filter_field' => 'software', 'filter_value' => 'Bidtrack']) }}'"
                class="small-box bg-purple">
                <div class="inner">
                    <h3>{{ $totalBidTrackPlanUsers }}</h3>
                    <p>BidTrack Plan Users</p>
                </div>
                <div class="icon"><i class="fas fa-clipboard-list"></i></div>
            </div>
        </div>

        {{-- TimeTrack Plan Users --}}
        <div class="col-md-6 col-lg-3">
            <div onclick="window.location='{{ route('plans.index', ['filter_field' => 'software', 'filter_value' => 'Timetracks']) }}'"
                class="small-box bg-orange">
                <div class="inner">
                    <h3>{{ $totalTimetracksPlanUsers }}</h3>
                    <p>TimeTracks Plan Users</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-check"></i></div>
            </div>
        </div>

        {{-- Other Plan Users --}}
        <div class="col-md-6 col-lg-3">
            <div onclick="window.location='{{ route('plans.index', ['filter_field' => 'software', 'filter_value' => 'other']) }}'"
                class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ $otherPlanUsers }}</h3>
                    <p>Other Plan Users</p>
                </div>
                <div class="icon"><i class="fas fa-id-badge"></i></div>
            </div>
        </div>

        {{-- Total Plan Users --}}
        <div class="col-md-6 col-lg-3">
            <div class="small-box bg-grey" onclick="window.location='{{ route('plans.index') }}'">
                <div class="inner">
                    <h3>{{ $totalPlanUsers }}</h3>
                    <p>Total Plan Users</p>
                </div>
                <div class="icon"><i class="fas fa-database"></i></div>
            </div>
        </div>
    </div>
@endsection
