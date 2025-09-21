<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MenuHelper
{
    public static function filterMenu(array $menu)
    {
        $user = Auth::user();
        $currentRoute = Route::currentRouteName();   // Current route name
        $currentUrl   = url()->current();            // Current full URL

        // Return as stdClass for Blade
        return collect($menu)->filter(function ($item) use ($user) {
            // Permission check
            if (isset($item['permission']) && !$user->can($item['permission'])) {
                return false;
            }

            // Recursive submenu check
            if (isset($item['submenu'])) {
                $item['submenu'] = self::filterMenu($item['submenu'])->toArray();

                if (empty($item['submenu']) && !isset($item['url'])) {
                    return false;
                }
            }

            return true;
        })->map(function ($item) use ($currentRoute, $currentUrl) {

            $item['activeClass'] = '';

            // 1️⃣ Active by custom "active" key
            if (isset($item['active']) && request()->is($item['active'] . '*')) {
                $item['activeClass'] = 'active';
            }
            // 2️⃣ Active by permission (route name)
            elseif (isset($item['permission']) && $currentRoute === $item['permission']) {
                $item['activeClass'] = 'active';
            }
            // 3️⃣ Active by URL
            elseif (isset($item['url']) && $currentUrl === url($item['url'])) {
                $item['activeClass'] = 'active';
            }

            // ✅ If submenu has active child → parent should be open
            if (isset($item['submenu']) && !empty($item['submenu'])) {
                foreach ($item['submenu'] as $sub) {
                    if (!empty($sub['activeClass']) && str_contains($sub['activeClass'], 'active')) {
                        $item['activeClass'] = 'active open';
                        break;
                    }
                }
            }

            // Reset submenu index
            if (isset($item['submenu'])) {
                $item['submenu'] = array_values($item['submenu']);
            }

            // Convert to object for Blade
            return (object) $item;
        });
    }
}
