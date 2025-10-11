<?php

namespace App\Providers;

use App\Services\LayoutService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeProvider extends ServiceProvider
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
        $layoutService = app(LayoutService::class);
        View::composer(['layouts.main'], function ($view) use ($layoutService) {

            $view->with([
                'popup' => $layoutService->getPopup(),
            ]);
        });
        View::composer(['layouts.header'], function ($view) use ($layoutService) {
            $view->with([
                'menus' => $layoutService->getMenus(),
            ]);
        });

        View::composer(['layouts.footer'], function ($view) use ($layoutService) {
            $view->with([
                'services' => $layoutService->getServices(),
                'pages' => $layoutService->getLegalPages(),
                'blogs' => $layoutService->getBlogs(),
                'quickLinks' => $layoutService->getQuickLinks(),
            ]);
        });
    }
}
