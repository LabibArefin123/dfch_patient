<?php

namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['route'])) {
            $user = auth()->user();

            // default: restricted
            $item['restricted'] = true;

            if ($user) {
                // ✅ sysadmin can see everything
                if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
                    $item['restricted'] = false;
                }
                // ✅ check normal permissions
                elseif ($user->can($item['route'])) {
                    $item['restricted'] = false;
                }
            }
        }

        return $item;
    }
}
