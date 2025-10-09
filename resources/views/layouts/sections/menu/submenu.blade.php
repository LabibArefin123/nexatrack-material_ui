@php
    use Illuminate\Support\Facades\Route;
@endphp

<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            @if (!isset($submenu->permission) || auth()->user()->can($submenu->permission))
                @php
                    $isActive = isset($submenu->url) && request()->is(trim($submenu->url, '/') . '*');

                    // Recursively check if child submenu has active route
                    $hasActiveChild =
                        isset($submenu->submenu) &&
                        collect($submenu->submenu)->contains(function ($child) {
                            return request()->is(trim($child->url ?? '', '/') . '*');
                        });
                @endphp

                <li class="menu-item {{ $isActive || $hasActiveChild ? 'open active' : '' }}">
                    <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                        class="menu-link {{ isset($submenu->submenu) ? 'menu-toggle' : '' }}"
                        @if (isset($submenu->target) && !empty($submenu->target)) target="_blank" @endif>
                        @if (isset($submenu->icon))
                            <i class="{{ $submenu->icon }}"></i>
                        @endif
                        <div>{{ $submenu->name ?? '' }}</div>
                    </a>

                    @if (isset($submenu->submenu))
                        @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                    @endif
                </li>
            @endif
        @endforeach
    @endif
</ul>
