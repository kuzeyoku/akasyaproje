<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;

class LayoutService
{
    public static function sidebarMenu()
    {
        return collect(config('module'))
            ->filter(fn ($c) => $c['status'])
            ->map(function ($c, $key) {
                $submenu = count($c['menu']) > 1;
                $module = ModuleEnum::tryFrom($key);

                return [
                    'enum' => $module,
                    'submenu' => $submenu,
                    'menu' => $c['menu'],
                    'url' => $submenu ? 'javascript:void(0);' : route('admin.'.$module->route().'.index'),
                ];
            });
    }

    public static function isActive($route)
    {

        return request()->routeIs('admin.'.$route.'*');
    }
}
