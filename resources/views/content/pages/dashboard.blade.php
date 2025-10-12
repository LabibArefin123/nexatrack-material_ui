@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')
    {{-- For Dashboard (Top Section) Start Part --}}
    <style>
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
    {{-- For Dashboard (Top Section) End Part --}}

    {{-- For Notification (Bottom Right Section) Start Part --}}
    <style>
        #notification-box:hover {
            transform: scale(1.05);
        }

        #notification-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.95);
            width: 85%;
            max-width: 900px;
            max-height: 80vh;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            overflow-y: auto;
            z-index: 99999;
            padding: 20px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        #notification-popup.active {
            display: block;
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        .notification-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }

        /* 💬 Notification Card Base */
        .notification-card {
            position: relative;
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: all 0.3s ease;
            color: #333;
        }

        .notification-card:hover {
            transform: scale(1.04);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .notification-card strong {
            font-size: 14px;
            color: #222;
        }

        .notification-card .text-muted {
            font-size: 12px;
        }

        .notification-card i {
            font-size: 13px;
        }

        #notification-box {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #fff;
            padding: 12px 18px;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            z-index: 9999;
        }

        #notification-box:hover {
            transform: translateY(-3px);
            background: #fff8e1;
        }

        /* 🔳 Popup Overlay */
        #notification-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            width: 80%;
            max-width: 1000px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
            padding: 25px;
            z-index: 9998;
            display: none;
            transition: all 0.3s ease-in-out;
        }

        #notification-popup.active {
            display: block;
            transform: translate(-50%, -50%) scale(1);
        }

        /* 🔔 Invoice Notification Box */
        #invoice-notification-box {
            position: fixed;
            bottom: 90px;
            /* space above deal notifications */
            right: 25px;
            background: #fff;
            padding: 12px 18px;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            z-index: 9999;
        }

        #invoice-notification-box:hover {
            transform: translateY(-3px);
            background: #e6ffed;
            /* light green hover */
        }

        /* 🔳 Popup Overlay */
        #invoice-notification-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            width: 80%;
            max-width: 1000px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
            padding: 25px;
            z-index: 9998;
            display: none;
            transition: all 0.3s ease-in-out;
        }

        #invoice-notification-popup.active {
            display: block;
            transform: translate(-50%, -50%) scale(1);
        }

        /* 🧩 Notification Grid */
        #invoice-notification-popup .notification-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }

        /* 💬 Notification Card */
        #invoice-notification-popup .notification-card {
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: all 0.3s ease;
            color: #333;
            position: relative;
        }

        #invoice-notification-popup .notification-card:hover {
            transform: scale(1.04);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* 🟢 Source Icon Circle */
        .source-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
    {{-- For Notification (Bottom Right Section) End Part --}}

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

        {{-- Plan Users --}}
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

    {{-- 🔔 Notification Section --}}
    @if (!empty($totalNotifications))
        <div id="notification-box">
            <i class="fas fa-bell text-warning fa-lg"></i>
            <div>
                <strong>You have {{ count($totalNotifications) }} Notifications</strong><br>
                <small class="text-muted">Click to view details</small>
            </div>
        </div>

        <div id="notification-popup">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-bell text-warning me-2"></i>All Notifications
                </h5>
                <button id="close-popup" class="btn btn-sm btn-outline-secondary">×</button>
            </div>

            {{-- Group notifications by type --}}
            @php
                $groupedNotifications = collect($totalNotifications)->groupBy('type');
            @endphp

            @foreach ($groupedNotifications as $type => $notes)
                <div class="mb-4">
                    <h6 class="fw-bold text-uppercase border-bottom pb-2 mb-3">
                        <i
                            class="fas {{ $type === 'invoice' ? 'fa-file-invoice-dollar text-danger' : 'fa-handshake text-warning' }}"></i>
                        {{ ucfirst($type) }} Notifications ({{ count($notes) }})
                    </h6>

                    <div class="notification-grid">
                        @foreach ($notes as $note)
                            @php
                                $colorClass = '';
                                $icon = 'fa-info-circle';
                                $iconColor = '#9e9e9e';

                                if ($note['type'] === 'deal') {
                                    $endDate = \Carbon\Carbon::parse($note['end_date']);
                                    $daysLeft = now()->diffInDays($endDate, false);
                                    $colorClass =
                                        $daysLeft > 30
                                            ? 'color-orange-light'
                                            : ($daysLeft > 15
                                                ? 'color-orange'
                                                : ($daysLeft > 7
                                                    ? 'color-red'
                                                    : 'color-red-deep'));
                                    $icon = 'fa-handshake';
                                    $iconColor = '#ff9800';
                                } elseif ($note['type'] === 'invoice') {
                                    $days = $note['days'];
                                    $colorClass =
                                        $days == 3
                                            ? 'color-orange-light'
                                            : ($days == 2
                                                ? 'color-orange'
                                                : 'color-red-deep');
                                    $icons = [
                                        'unpaid' => ['fa-exclamation-circle', '#f44336'],
                                        'partially paid' => ['fa-hourglass-half', '#ff9800'],
                                        'overdue' => ['fa-times-circle', '#d32f2f'],
                                    ];
                                    [$icon, $iconColor] = $icons[$note['status']] ?? ['fa-question-circle', '#9e9e9e'];
                                }
                            @endphp

                            <div class="notification-card {{ $colorClass }}"
                                onclick="window.location='{{ $note['type'] === 'invoice' ? route('invoices.index') : route('deals.index') }}'">
                                <div class="source-icon" style="background-color: {{ $iconColor }}">
                                    <i class="fas {{ $icon }}"></i>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <strong>{{ ucfirst($note['type']) }} Notification</strong>
                                </div>
                                <div style="font-size: 13px; color: #000;">{{ Str::limit($note['message'], 80) }}</div>
                                <small class="mt-2 d-block">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $note['type'] === 'deal'
                                        ? \Carbon\Carbon::parse($note['end_date'])->diffForHumans()
                                        : \Carbon\Carbon::parse($note['due_date'])->diffForHumans() }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <script>
            const notifBox = document.getElementById('notification-box');
            const notifPopup = document.getElementById('notification-popup');
            const closeBtn = document.getElementById('close-popup');
            notifBox.addEventListener('click', () => notifPopup.classList.add('active'));
            closeBtn.addEventListener('click', () => notifPopup.classList.remove('active'));
        </script>
    @endif
@endsection
