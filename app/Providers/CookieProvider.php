<?php

namespace App\Providers;

use App\Services\CacheService;
use Illuminate\Support\ServiceProvider;

class CookieProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (setting('information', 'cookie_notification_status') == \App\Enums\StatusEnum::Active->value) {
            $page = CacheService::cacheQuery('cookie_notification_page', function () {
                return \App\Models\Page::type(\App\Enums\PageTypeEnum::Cookie->value)->first();
            });
            view()->composer('common.cookie_alert', function ($view) use ($page) {
                $cookie_policy_page_url = $page?->url ?? '#';
                $view->with(compact('cookie_policy_page_url'));
            });
        }
    }
}
