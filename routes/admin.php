<?php

use App\Enums\ModuleEnum;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EditorController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

// Config üzerinden almak daha iyi
$adminPrefix = config('system.admin_route', 'admin');

Route::prefix($adminPrefix)->name('admin.')->group(function () {
    // Auth routes
    Route::prefix('auth')->controller(AuthController::class)->name('auth.')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::get('forgot-password', 'forgot_password_view')->name('forgot_password_view');
        Route::post('forgot-password', 'forgot_password')->name('forgot_password');
        Route::get('reset-password/{token}', 'reset_password_view')->name('reset_password_view');
        Route::post('reset-password', 'reset_password')->name('reset_password');
        Route::post('authenticate', 'authenticate')->name('authenticate');
    });

    Route::middleware(['auth', Admin::class])->group(function () {
        // Dashboard & logout
        Route::get('/', [HomeController::class, 'index'])->name('index');
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

        // Settings
        Route::prefix('settings')->controller(SettingController::class)->group(function () {
            Route::get('/{category}', 'index')->name('settings');
            Route::put('/update', 'update')->name('settings.update');
        });

        // Resource-based modules
        Route::resources([
            ModuleEnum::Menu->route() => MenuController::class,
            ModuleEnum::Page->route() => PageController::class,
            ModuleEnum::User->route() => UserController::class,
            ModuleEnum::Language->route() => LanguageController::class,
            ModuleEnum::Category->route() => CategoryController::class,
            ModuleEnum::Service->route() => ServiceController::class,
            ModuleEnum::Project->route() => ProjectController::class,
            ModuleEnum::Product->route() => ProductController::class,
            ModuleEnum::Slider->route() => SliderController::class,
            ModuleEnum::Brand->route() => BrandController::class,
            ModuleEnum::Reference->route() => ReferenceController::class,
            ModuleEnum::Testimonial->route() => TestimonialController::class,
            ModuleEnum::Popup->route() => PopupController::class,
            ModuleEnum::Blog->route() => BlogController::class,
            ModuleEnum::Message->route() => MessageController::class,
        ]);

        // Blog specific routes
        Route::prefix(ModuleEnum::Blog->route())->controller(BlogController::class)->name(ModuleEnum::Blog->routeName())->group(function () {
            Route::put('/{blog}/status-update', 'statusUpdate')->name('status_update');
            Route::get('/{blog}/comments', 'comments')->name('comments');
            Route::put('/comments/{comment}/status', 'commentStatusChange')->name('comment_status_change');
            Route::delete('/comments/{comment}', 'comment_delete')->name('comment_delete');
        });

        Route::prefix(ModuleEnum::Page->route())->controller(PageController::class)->name(ModuleEnum::Page->routeName())->group(function () {
            Route::put('/{page}/status-update', 'statusUpdate')->name('status_update');
        });

        Route::prefix(ModuleEnum::Language->route())->controller(LanguageController::class)->name(ModuleEnum::Language->routeName())->group(function () {
            Route::put('/{language}/status-update', 'statusUpdate')->name('status_update');
            Route::match(['get', 'post'], '/{language}/files', 'files')->name('files');
            Route::put('/{language}/updateFileContent', 'updateFileContent')->name('updateFileContent');
        });

        Route::prefix(ModuleEnum::Service->route())->controller(ServiceController::class)->name(ModuleEnum::Service->routeName())->group(function () {
            Route::put('/{service}/status-update', 'statusUpdate')->name('status_update');
            Route::get('/{service}/image', 'image')->name('image');
            Route::get('/{service}/file', 'file')->name('file');
            Route::post('/{service}/storeImage', 'storeImage')->name('storeImage');
            Route::delete('/{service}/destroyAllImages', 'destroyAllImages')->name('destroyAllImages');
        });

        Route::prefix(ModuleEnum::Reference->route())->controller(ReferenceController::class)->name(ModuleEnum::Reference->routeName())->group(function () {
            Route::put('/{reference}/status-update', 'statusUpdate')->name('status_update');
        });

        Route::prefix(ModuleEnum::Slider->route())->controller(SliderController::class)->name(ModuleEnum::Slider->routeName())->group(function () {
            Route::put('/{slider}/status-update', 'statusUpdate')->name('status_update');
        });

        Route::prefix(ModuleEnum::Category->route())->controller(CategoryController::class)->name(ModuleEnum::Category->routeName())->group(function () {
            Route::put('/{category}/status-update', 'statusUpdate')->name('status_update');
        });

        Route::prefix('media')->controller(MediaController::class)->name('media.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/upload', 'store')->name(name: 'upload');
            Route::delete('/{media}', 'destroy')->name('destroy');
        });

        Route::prefix(ModuleEnum::Project->route())->controller(ProjectController::class)->name(ModuleEnum::Project->routeName())->group(function () {
            Route::put('/{project}/status-update', 'statusUpdate')->name('status_update');
            Route::post('/{project}/image-upload', 'storeImage')->name('storeImage');
            Route::delete('/{project}/all-media-clear', 'destroyAllImages')->name('destroyAllImages');
            Route::get('/{project}/image', 'image')->name('image');
        });

        Route::prefix(ModuleEnum::Message->route())->controller(MessageController::class)->name(ModuleEnum::Message->routeName())->group(function () {
            Route::get('/{message}/reply', 'reply')->name('reply');
            Route::post('/{message}/sendReply', 'sendReply')->name('sendReply');
            Route::post('/{message}/block', 'block')->name('block');
            Route::get('/user/blocked', 'blocked')->name('blocked');
            Route::delete('/user/{id}/unblock', 'unblock')->name('unblock');
        });

        // Notification Management
        Route::prefix('notifications')->controller(NotificationController::class)->name('notifications.')->group(function () {
            Route::get('/{id}/read', 'read')->name('read');
            Route::get('/mark-all-as-read', 'markAllAsRead')->name('mark_all_as_read');
        });

        // Editor & File Upload
        Route::prefix('editor')->controller(EditorController::class)->group(function () {
            Route::post('/upload', 'store')->name('editor.upload');
        });

        // System Management
        Route::prefix('system')->controller(HomeController::class)->name('system.')->group(function () {
            Route::get('/cache-clear', 'cacheClear')->name('cache_clear');
            Route::post('/clear-visitor-counter', 'clearVisitorCounter')->name('clear_visitor_counter');
        });
    });
});
