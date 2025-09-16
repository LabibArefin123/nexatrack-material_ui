<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class MenuHelper
{
    public static function filterMenu(array $menu)
    {
        $user = Auth::user();

        return collect($menu)->filter(function ($item) use ($user) {
            // Check main permission
            if (isset($item['permission']) && !$user->can($item['permission'])) {
                return false;
            }

            // Check submenu recursively
            if (isset($item['submenu'])) {
                $item['submenu'] = self::filterMenu($item['submenu'])->toArray();

                // if submenu empty and no direct url, hide it
                if (empty($item['submenu']) && !isset($item['url'])) {
                    return false;
                }
            }

            return true;
        })->map(function ($item) {
            if (isset($item['submenu'])) {
                $item['submenu'] = array_values($item['submenu']); // reset index
            }
            return $item;
        });
    }
}
