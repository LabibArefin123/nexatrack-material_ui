<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <style>
        .menu-item .menu-sub {
            display: none;
            padding-left: 1rem;
        }

        .menu-item.open>.menu-sub {
            display: block;
        }

        .menu-item.open>.menu-link {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .menu-link.menu-toggle::after {
            content: '\25BC';
            font-size: 0.6rem;
            float: right;
            transition: transform 0.2s ease;
        }

        .menu-item.open>.menu-link.menu-toggle::after {
            transform: rotate(-180deg);
        }
    </style>

    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                <img src="{{ asset('uploads/images/logor.png') }}" alt="Logo" height="30">
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">
                {{ config('variables.templateName') }}
                <br>
                <small style="font-size: 10px">Stay Ahead, Stay Connected</small>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-block align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            @if (!isset($menu->permission) || auth()->user()->can($menu->permission))
                @if (isset($menu->menuHeader))
                    <li class="menu-header mt-7">
                        <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                    </li>
                @else
                    @php
                        // Check active for main or sub routes dynamically for each menu
                        $isActive = isset($menu->url) && request()->is(trim($menu->url, '/') . '*');

                        $hasActiveChild =
                            isset($menu->submenu) &&
                            collect($menu->submenu)->contains(function ($child) {
                                // Check for children recursively
                                if (isset($child->submenu)) {
                                    return collect($child->submenu)->contains(function ($subchild) {
                                        return request()->is(trim($subchild->url ?? '', '/') . '*');
                                    });
                                }
                                return request()->is(trim($child->url ?? '', '/') . '*');
                            });
                    @endphp

                    <li class="menu-item {{ $isActive || $hasActiveChild ? 'open active' : '' }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="menu-link {{ isset($menu->submenu) ? 'menu-toggle' : '' }}"
                            @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        </a>

                        @if (isset($menu->submenu))
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endif
                    </li>
                @endif
            @endif
        @endforeach
    </ul>

</aside>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggles = document.querySelectorAll(".menu-toggle");

            toggles.forEach(toggle => {
                toggle.addEventListener("click", function(e) {
                    e.preventDefault();
                    const parentItem = this.closest(".menu-item");
                    parentItem.classList.toggle("open");
                });
            });
        });
    </script>
@endpush
