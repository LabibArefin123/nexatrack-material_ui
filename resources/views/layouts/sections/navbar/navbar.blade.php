@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';

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
        /* Custom brand wrapper */
        .custom-brand {
            display: flex;
            align-items: center;
        }

        /* Brand link */
        .custom-brand-link {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        /* Logo style */
        .custom-logo-img {
            height: 40px;
            width: auto;
            border-radius: 6px;
            /* চাইলে rounded */
        }

        /* Text style */
        .custom-brand-text {
            font-size: 20px;
            font-weight: 600;
            color: #ff6600;
            /* তোমার theme অনুযায়ী */
            text-transform: uppercase;
            /* চাইলে সব বড় হরফে */
        }
    </style>
@endif

<!-- ! Not required for layout-without-menu -->
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

        <!-- Fullscreen Icon -->
        <li class="nav-item me-3">
            <a class="nav-link" href="javascript:void(0);" id="fullscreen-toggle">
                <i class="ri-fullscreen-line ri-22px"></i>
            </a>
        </li>

        <!-- Notifications -->
        <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative" href="javascript:void(0);" id="notificationDropdown"
                data-bs-toggle="dropdown">
                <i class="ri-notification-3-line ri-15px"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-3 py-2" aria-labelledby="notificationDropdown"
                style="width: 300px;">
                <li class="px-3 py-2 border-bottom">
                    <h6 class="mb-0">Notifications</h6>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="#">
                        <i class="ri-message-3-line me-2 text-primary"></i>
                        <span>New message from John</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="#">
                        <i class="ri-user-follow-line me-2 text-success"></i>
                        <span>Anna started following you</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="#">
                        <i class="ri-calendar-event-line me-2 text-warning"></i>
                        <span>Meeting at 3 PM</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item text-center text-primary" href="#">
                        View All Notifications
                    </a>
                </li>
            </ul>
        </li>

        <!-- GitHub Star Button -->
        {{-- <li class="nav-item lh-1 me-4">
            <a class="github-button" href="{{ config('variables.repository') }}" data-icon="octicon-star"
                data-size="large" data-show-count="true"
                aria-label="Star themeselection/materio-html-laravel-admin-template-free on GitHub">Star</a>
        </li> --}}

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ asset('uploads/images/default.jpg') }}" alt class="w-px-40 h-auto rounded-circle">
                </div>
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
                                <h6 class="mb-0 small">
                                    {{ Auth::user()->name ?? 'Guest User' }}
                                </h6>
                                <small class="text-muted">
                                    {{ Auth::user()->getRoleNames()->first() ?? 'No Role' }}
                                </small>
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
                        <i class='ri-settings-4-line ri-22px me-2'></i>
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
                            <button type="submit" class="btn btn-danger d-flex">
                                <small class="align-middle">Logout</small>
                                <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>

    {{-- JS for fullscreen --}}
    <script>
        document.getElementById("fullscreen-toggle").addEventListener("click", function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        });
    </script>

</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
