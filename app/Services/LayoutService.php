<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Blog;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Popup;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class LayoutService
{
    public function getLegalPages(): Collection
    {
        return CacheService::cacheQuery('legal_static_pages', function () {
            return Page::whereNotNull('type')->active()->get();
        });
    }

    public function getServices(): Collection
    {
        return CacheService::cacheQuery('footer_services', function () {
            return Service::active()->take(5)->get();
        });
    }

    public function getBlogs(): Collection
    {
        return CacheService::cacheQuery('footer_blogs', function () {
            return Blog::active()->take(2)->get();
        });
    }

    public function getMenus(): Collection
    {
        return CacheService::cacheQuery('header_menus', function () {
            return Menu::order()->get();
        });
    }

    public function getPopup(): ?Popup
    {
        return CacheService::cacheQuery('popup', fn () => Popup::active()->first());
    }

    public function getQuickLinks()
    {
        return CacheService::cacheQuery('footer_quicklinks', fn () => Page::where('quick_link', StatusEnum::Yes->value)->get());
    }
}
