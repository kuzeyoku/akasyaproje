<?php

namespace App\Services\Admin;

use App\Enums\ModuleEnum;
use App\Models\Menu;
use App\Models\Page;

class MenuService extends BaseService
{
    public function __construct(Menu $menu)
    {
        parent::__construct($menu, ModuleEnum::Menu);
    }

    public function getUrlList(): array
    {
        $urlList = [
            route('home') => __('admin/general.home'),
            route(ModuleEnum::Blog->Route().'.index') => ModuleEnum::Blog->title(),
            route(ModuleEnum::Project->Route().'.index') => ModuleEnum::Project->title(),
            route(ModuleEnum::Service->Route().'.index') => ModuleEnum::Service->title(),
            route('contact.index') => __('front/contact.title'),
        ];
        $pages = Page::active()->get()->pluck('title', 'url')->toArray();
        if (! empty($pages)) {
            $urlList[__('admin/page.title')] = $pages;
        }

        return $urlList;
    }
}
