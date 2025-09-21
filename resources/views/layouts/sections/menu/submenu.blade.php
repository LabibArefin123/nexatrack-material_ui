@php
    use Illuminate\Support\Facades\Route;
@endphp
<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            @if (!isset($submenu->permission) || auth()->user()->can($submenu->permission))
                @php
                    $hasActiveChild =
                        isset($submenu->submenu) &&
                        collect($submenu->submenu)->contains(function ($s) {
                            return !empty($s->activeClass) && str_contains($s->activeClass, 'active');
                        });
                @endphp

                <li class="menu-item {{ $submenu->activeClass ?? '' }} {{ $hasActiveChild ? 'open' : '' }}">
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
