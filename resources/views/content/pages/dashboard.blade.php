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

        /* Notification styles */


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
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .notification-card {
            cursor: pointer;
            border-radius: 10px;
            background-color: #fff8e1;
            border-left: 5px solid #ffc107;
            transition: transform 0.2s ease;
            padding: 8px;
        }

        .notification-card:hover {
            transform: scale(1.05);
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

    {{-- 🔔 Notification section --}}
    @if (!empty($notifications))
        <style>
            /* 🔔 Notification Box (Bottom-right floating) */
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

            /* 🧩 Notification Grid */
            .notification-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 15px;
            }

            /* 💬 Notification Card Base */
            .notification-card {
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

            /* 🎨 Color Variants */
            .color-orange-light {
                background: #fff3cd;
                border-left: 6px solid #ffca28;
            }

            .color-orange {
                background: #ffe0b2;
                border-left: 6px solid #ffa726;
            }

            .color-red {
                background: #ffccbc;
                border-left: 6px solid #ff7043;
            }

            .color-red-deep {
                background: #ffcdd2;
                border-left: 6px solid #e53935;
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
        </style>

        {{-- 🔔 Floating Notification Box --}}
        <div id="notification-box">
            <i class="fas fa-bell text-warning fa-lg"></i>
            <div>
                <strong>You have {{ count($notifications) }} Deal notifications</strong><br>
                <small class="text-muted">Click to view details</small>
            </div>
        </div>

        {{-- 💬 Notification Popup --}}
        <div id="notification-popup">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-bell text-warning me-2"></i>Deal Notifications
                </h5>
                <button id="close-popup" class="btn btn-sm btn-outline-secondary">×</button>
            </div>

            <div class="notification-grid">
                @foreach ($notifications as $note)
                    @php
                        $endDate = \Carbon\Carbon::parse($note['end_date']);
                        $daysLeft = now()->diffInDays($endDate, false);

                        // 🔥 Color based on days left
                        if ($daysLeft > 30) {
                            $colorClass = 'color-orange-light';
                        } elseif ($daysLeft > 15) {
                            $colorClass = 'color-orange';
                        } elseif ($daysLeft > 7) {
                            $colorClass = 'color-red';
                        } else {
                            $colorClass = 'color-red-deep';
                        }

                        // 🧭 Source Icon Map
                        $source = $note['source'] ?? 'other';
                        switch ($source) {
                            case 'call':
                                $icon = 'fa-phone';
                                $iconColor = '#4caf50';
                                break;
                            case 'email':
                                $icon = 'fa-envelope';
                                $iconColor = '#2196f3';
                                break;
                            case 'website':
                                $icon = 'fa-globe';
                                $iconColor = '#6f42c1';
                                break;
                            case 'advertising':
                                $icon = 'fa-bullhorn';
                                $iconColor = '#ff9800';
                                break;
                            case 'existing_client':
                                $icon = 'fa-user-check';
                                $iconColor = '#009688';
                                break;
                            case 'by_recommendation':
                                $icon = 'fa-handshake';
                                $iconColor = '#8bc34a';
                                break;
                            case 'show_or_exhibition':
                                $icon = 'fa-store';
                                $iconColor = '#3f51b5';
                                break;
                            case 'crm_form':
                                $icon = 'fa-list-alt';
                                $iconColor = '#9c27b0';
                                break;
                            case 'callback':
                                $icon = 'fa-reply';
                                $iconColor = '#795548';
                                break;
                            case 'sales_boost':
                                $icon = 'fa-chart-line';
                                $iconColor = '#f44336';
                                break;
                            case 'online_store':
                                $icon = 'fa-shopping-cart';
                                $iconColor = '#e91e63';
                                break;
                            default:
                                $icon = 'fa-question-circle';
                                $iconColor = '#9e9e9e';
                                break;
                        }
                    @endphp

                    <div class="notification-card {{ $colorClass }}"
                        onclick="window.location='{{ route('deals.index') }}'">
                        <!-- 🔵 Source Icon (Top-right circle) -->
                        <div class="source-icon" style="background-color: {{ $iconColor }}">
                            <i class="fas {{ $icon }}"></i>
                        </div>

                        <!-- 📝 Notification Content -->
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-bell text-warning me-2"></i>
                            <strong>{{ ucfirst(str_replace('_', ' ', $source)) }}</strong>
                        </div>
                        <div style="font-size: 13px; color: #000;">
                            {{ Str::limit($note['message'], 70) }}
                        </div>
                        <small class="mt-2 d-block">
                            <i class="fas fa-clock me-1"></i>
                            {{ $endDate->diffForHumans() }}
                        </small>
                    </div>
                @endforeach
            </div>

            <style>
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

                /* 🎨 Color Levels */
                .color-orange-light {
                    background: #fff3cd;
                    border-left: 6px solid #ffca28;
                }

                .color-orange {
                    background: #ffe0b2;
                    border-left: 6px solid #ffa726;
                }

                .color-red {
                    background: #ffccbc;
                    border-left: 6px solid #ff7043;
                }

                .color-red-deep {
                    background: #ffcdd2;
                    border-left: 6px solid #e53935;
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

        </div>

        {{-- ⚙️ Script --}}
        <script>
            const notifBox = document.getElementById('notification-box');
            const notifPopup = document.getElementById('notification-popup');
            const closeBtn = document.getElementById('close-popup');

            notifBox.addEventListener('click', () => notifPopup.classList.add('active'));
            closeBtn.addEventListener('click', () => notifPopup.classList.remove('active'));
        </script>
    @endif

    {{-- 🧾 Invoice Notifications --}}
    @if (!empty($invoiceNotifications))
        {{-- 🔔 Invoice Notification CSS --}}
        <style>
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

            /* 🎨 Color Variants */
            .color-orange-light {
                background: #fff3cd;
                border-left: 6px solid #ffca28;
            }

            .color-orange {
                background: #ffe0b2;
                border-left: 6px solid #ffa726;
            }

            .color-red {
                background: #ffccbc;
                border-left: 6px solid #ff7043;
            }

            .color-red-deep {
                background: #ffcdd2;
                border-left: 6px solid #e53935;
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

        {{-- 🔔 Floating Box --}}
        <div id="invoice-notification-box">
            <i class="fas fa-file-invoice-dollar text-success fa-lg"></i>
            <div>
                <strong>You have {{ count($invoiceNotifications) }} Invoice notifications</strong><br>
                <small class="text-muted">Click to view details</small>
            </div>
        </div>

        {{-- 💬 Popup --}}
        <div id="invoice-notification-popup">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-file-invoice-dollar text-success me-2"></i>Invoice Notifications
                </h5>
                <button id="close-invoice-popup" class="btn btn-sm btn-outline-secondary">×</button>
            </div>

            <div class="notification-grid">
                @foreach ($invoiceNotifications as $note)
                    @php
                        $dueDate = \Carbon\Carbon::parse($note['due_date']);
                        $daysLeft = $note['days'];

                        // Color based on days left
                        $colorClass =
                            $daysLeft == 3
                                ? 'color-orange-light'
                                : ($daysLeft == 2
                                    ? 'color-orange'
                                    : 'color-red-deep');

                        // Icon based on status
                        $icons = [
                            'unpaid' => ['fa-exclamation-circle', '#f44336'],
                            'partially paid' => ['fa-hourglass-half', '#ff9800'],
                            'overdue' => ['fa-times-circle', '#d32f2f'],
                            'other' => ['fa-question-circle', '#9e9e9e'],
                        ];
                        $icon = $icons[$note['status']][0] ?? 'fa-question-circle';
                        $iconColor = $icons[$note['status']][1] ?? '#9e9e9e';
                    @endphp

                    <div class="notification-card {{ $colorClass }}"
                        onclick="window.location='{{ route('invoices.index') }}'">
                        <div class="source-icon" style="background-color: {{ $iconColor }}">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <i class="fas fa-file-invoice-dollar text-success me-2"></i>
                            <strong>{{ ucfirst($note['status']) }}</strong>
                        </div>
                        <div style="font-size: 13px; color: #000;">{{ $note['message'] }}</div>
                        <small class="mt-2 d-block"><i
                                class="fas fa-clock me-1"></i>{{ $dueDate->diffForHumans() }}</small>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ⚙️ Script --}}
        <script>
            const invBox = document.getElementById('invoice-notification-box');
            const invPopup = document.getElementById('invoice-notification-popup');
            const invClose = document.getElementById('close-invoice-popup');

            invBox.addEventListener('click', () => invPopup.classList.add('active'));
            invClose.addEventListener('click', () => invPopup.classList.remove('active'));
        </script>
    @endif
@endsection
