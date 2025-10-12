@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';
    $totalNotifications = $totalNotifications ?? []; // ✅ Prevent undefined variable
@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

@if (isset($navbarFull))
    <div class="navbar-brand custom-brand d-none d-xl-flex py-0 me-6">
        <a href="{{ url('/') }}" class="custom-brand-link gap-2">
            <span class="custom-brand-logo">
                <img src="{{ asset('uploads/images/logor.png') }}" alt="Logo" height="40" class="custom-logo-img">
            </span>
            <span class="custom-brand-text ms-1">
                {{ config('variables.templateName') }}
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="ri-close-fill align-middle"></i>
        </a>
    </div>
    <style>
        .custom-brand {
            display: flex;
            align-items: center;
        }

        .custom-brand-link {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .custom-logo-img {
            height: 40px;
            width: auto;
            border-radius: 6px;
        }

        .custom-brand-text {
            font-size: 20px;
            font-weight: 600;
            color: #ff6600;
            text-transform: uppercase;
        }
    </style>
@endif

@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="ri-menu-fill ri-24px"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="ri-search-line ri-22px me-1_5"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search..."
                aria-label="Search...">
        </div>
    </div>
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">

        <!-- Fullscreen -->
        <li class="nav-item me-2">
            <a class="btn btn-light btn-icon rounded-circle" href="javascript:void(0);" id="fullscreen-toggle"
                title="Fullscreen">
                <i class="ri-fullscreen-line ri-22px"></i>
            </a>
        </li>

        <!-- 🔔 Notifications -->
        <li class="nav-item dropdown me-2">
            @php
                $notificationCount = is_array($totalNotifications) ? count($totalNotifications) : 0;
            @endphp

            <a class="btn btn-light btn-icon rounded-circle position-relative" href="javascript:void(0);"
                id="notificationDropdown" data-bs-toggle="dropdown" title="Notifications">
                <i class="ri-notification-3-line ri-20px"></i>
                @if ($notificationCount > 0)
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $notificationCount }}</span>
                @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end mt-3 py-2 shadow-lg" aria-labelledby="notificationDropdown"
                style="width: 330px; max-height: 430px; overflow-y: auto;">
                <li class="px-3 py-2 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">Recent Updates</h6>
                    <small class="text-muted">Here’s what’s new for you</small>
                </li>

                @php
                    $sortedNotifications = collect($totalNotifications)->sortByDesc(function ($note) {
                        $dateField = $note['type'] === 'deal' ? 'end_date' : 'due_date';
                        return isset($note[$dateField]) ? Carbon::parse($note[$dateField]) : now();
                    });

                    $latestNotifications = $sortedNotifications->take(8);
                @endphp

                @forelse ($latestNotifications as $note)
                    @php
                        $icon = 'fa-info-circle';
                        $iconColor = 'text-secondary';
                        $friendlyText = 'New update available';
                        $redirectUrl = route('deals.index');

                        if (($note['type'] ?? '') === 'deal') {
                            $icon = 'fa-handshake';
                            $iconColor = 'text-warning';
                            $friendlyText = 'Deal Reminder: ' . Str::limit($note['message'] ?? 'No details', 50);
                            $redirectUrl = route('deals.index');
                        } elseif (($note['type'] ?? '') === 'invoice') {
                            $icons = [
                                'unpaid' => ['fa-exclamation-circle', 'text-danger', 'Invoice pending payment'],
                                'partially paid' => ['fa-hourglass-half', 'text-warning', 'Invoice partially paid'],
                                'overdue' => ['fa-times-circle', 'text-danger', 'Invoice overdue!'],
                            ];

                            [$icon, $iconColor, $prefix] = $icons[$note['status']] ?? [
                                'fa-question-circle',
                                'text-secondary',
                                'Invoice update',
                            ];

                            $friendlyText = $prefix . ': ' . Str::limit($note['message'] ?? 'No details', 50);
                            $redirectUrl = route('invoices.index');
                        }

                        $timeField = ($note['type'] ?? '') === 'deal' ? 'end_date' : 'due_date';
                        $timeAgo = isset($note[$timeField])
                            ? Carbon::parse($note[$timeField])->diffForHumans()
                            : 'just now';
                    @endphp

                    <li>
                        <a class="dropdown-item d-flex align-items-start py-2 notification-item"
                            href="{{ $redirectUrl }}" style="white-space: normal;">
                            <i class="fas {{ $icon }} me-3 {{ $iconColor }}" style="margin-top: 3px;"></i>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark">{{ $friendlyText }}</div>
                                <small class="text-muted">{{ $timeAgo }}</small>
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="text-center py-3 text-muted">
                        <i class="ri-notification-off-line ri-20px mb-1"></i><br>
                        You're all caught up — no new notifications 🎉
                    </li>
                @endforelse

                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item text-center text-primary fw-semibold"
                        href="{{ route('user_profile_show') }}">
                        See all notifications
                    </a>
                </li>
            </ul>
        </li>

        {{-- 🔸 Hover effect --}}
        <style>
            .notification-item:hover {
                background-color: #ff9900 !important;
                color: #fff !important;
                transition: 0.2s ease;
            }

            .notification-item:hover small {
                color: #fff !important;
            }
        </style>

        <!-- 👤 User -->
        <li class="nav-item dropdown">
            <a class="btn btn-light btn-icon rounded-circle" href="javascript:void(0);" data-bs-toggle="dropdown"
                title="User Menu">
                <img src="{{ asset('uploads/images/default.jpg') }}" alt class="w-px-30 h-auto rounded-circle">
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-2">
                                <div class="avatar avatar-online">
                                    <img src="{{ asset('uploads/images/default.jpg') }}" alt
                                        class="w-px-40 h-auto rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 small">{{ Auth::user()->name ?? 'Guest User' }}</h6>
                                <small
                                    class="text-muted">{{ Auth::user()->getRoleNames()->first() ?? 'No Role' }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user_profile_show') }}">
                        <i class="ri-user-3-line ri-22px me-2"></i>
                        <span class="align-middle">My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('settings.index') }}">
                        <i class="ri-settings-4-line ri-22px me-2"></i>
                        <span class="align-middle">Settings</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="d-grid px-4 pt-2 pb-1">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-danger d-flex justify-content-center align-items-center">
                                <i class="ri-logout-box-r-line ri-16px me-2"></i>
                                <small>Logout</small>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- JS for fullscreen --}}
    <script>
        document.getElementById("fullscreen-toggle").addEventListener("click", function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        });
    </script>
</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
