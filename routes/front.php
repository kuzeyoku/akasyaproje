<?php

use App\Enums\ModuleEnum;
use App\Enums\StatusEnum;
use App\Http\Middleware\CountVisitors;
use App\Http\Middleware\Maintenance;
use Illuminate\Support\Facades\Route;

Route::middleware([CountVisitors::class, Maintenance::class])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    if (setting('system', 'multilanguage') == StatusEnum::Active->value) {
        Route::post('/setLocale', [App\Http\Controllers\LanguageController::class, 'set'])->name('language.set');
    }

    Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');

    Route::post('/contact/send', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

    Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');

    Route::prefix(ModuleEnum::Page->route())->get('/{page}/{slug}', [App\Http\Controllers\PageController::class, 'show'])->name(ModuleEnum::Page->routeName().'show');

    if (ModuleEnum::Blog->status()) {
        Route::prefix(ModuleEnum::Blog->route())->controller(App\Http\Controllers\BlogController::class)->name(ModuleEnum::Blog->routeName())->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{blog}/{slug}', 'show')->name('show');
            Route::get('/category/{category}/{slug}', 'category')->name('category');
            Route::post('/{blog}/comment/store', 'comment_store')->name('comment.store');
        });
    }

    if (ModuleEnum::Service->status()) {
        Route::prefix(ModuleEnum::Service->route())->controller(App\Http\Controllers\ServiceController::class)->name(ModuleEnum::Service->routeName())->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{service}/{slug}', 'show')->name('show');
            Route::get('/category/{category}/{slug}', 'category')->name('category');
        });
    }

    if (ModuleEnum::Project->status()) {
        Route::prefix(ModuleEnum::Project->route())->controller(App\Http\Controllers\ProjectController::class)->name(ModuleEnum::Project->routeName())->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{project}/{slug}', 'show')->name('show');
            Route::get('/category/{category}/{slug}', 'category')->name('category');
        });
    }
    Route::get(uri: 'maintenance', action: [App\Http\Controllers\MaintenanceController::class, 'index'])->name('maintenance');

});
