<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
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
                    <li class="menu-item {{ $menu->activeClass ?? '' }}">
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
