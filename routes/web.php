<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Backend\Module\Blog\CategoryController;
use App\Http\Controllers\Backend\Module\Blog\PostController;
use App\Http\Controllers\Backend\Module\Blog\TagController;
use App\Http\Controllers\Backend\Module\Template\Component\ComponentController;
use App\Http\Controllers\Backend\Module\Content\ContentImage\ContentImageController;
use App\Http\Controllers\Backend\Module\Content\ContentText\ContentTextController;
use App\Http\Controllers\Backend\Module\Email\MessageController;
use App\Http\Controllers\Backend\Module\Main\MainController;
use App\Http\Controllers\Backend\Module\MediaLibrary\MediaLibraryController;
use App\Http\Controllers\Backend\Module\Navigation\FooterMenuController;
use App\Http\Controllers\Backend\Module\Navigation\HeaderMenuController;
use App\Http\Controllers\Backend\Module\SEO\CanonicalController;
use App\Http\Controllers\Backend\Module\SEO\MetaController;
use App\Http\Controllers\Backend\Module\SEO\OpengraphController;
use App\Http\Controllers\Backend\Module\SEO\SchemaController;
use App\Http\Controllers\Backend\Module\Settings\GeneralController;
use App\Http\Controllers\Backend\Module\Settings\SocialMediaController;
use App\Http\Controllers\Backend\Module\System\ActivityController;
use App\Http\Controllers\Backend\Module\System\MaintenanceController;
use App\Http\Controllers\Backend\Module\Users\PermissionController;
use App\Http\Controllers\Backend\Module\Users\RoleController;
use App\Http\Controllers\Backend\Module\Users\UserController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Testing\TestController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(
    [
        'prefix' => LaravelLocalization::setlocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect'],
    ],
    function () {
        // Home Page
        Route::get('/', [HomeController::class, 'index'])->name('site.index');

        // Blog Page
        Route::get('blog', [BlogController::class, 'index'])->name('site.blog');
        Route::post('blog', [BlogController::class, 'search'])
            ->name('site.blog.search')
            ->middleware(['xss-sanitize']);
        Route::get('blog/category/{slug}', [
            BlogController::class,
            'category',
        ])->name('site.blog.category');
        Route::get('blog/tag/{slug}', [BlogController::class, 'tag'])->name(
            'site.blog.tag'
        );
        Route::get('blog/post/{slug}', [BlogController::class, 'post'])->name(
            'site.blog.post'
        );

        // Contact Page
        Route::get('contact', [ContactController::class, 'index'])->name(
            'site.contact'
        );
        Route::post('contact/message', [
            ContactController::class,
            'message',
        ])->name('site.contact.message');

        // Authentication
        Route::prefix('authentication')->group(function () {
            Route::get('login', [
                AuthController::class,
                'login_page',
            ])->name('login.page');
            Route::get('register', [
                AuthController::class,
                'register_page',
            ])->name('register.page');
            Route::get('forgot_password', [
                AuthController::class,
                'forgot_password_page',
            ])->name('forgot.password.page');
            Route::get('reset_password/{token}', [
                AuthController::class,
                'reset_password_page',
            ])->name('reset.password.page');
            Route::post('register/{type}', [
                AuthController::class,
                'register_client',
            ])->name('register');
            Route::get('resend_verification', [
                AuthController::class,
                'resend_verification_page',
            ])->name('resend.verification.page');
            Route::post('resend_verification', [
                AuthController::class,
                'resend_verification',
            ])->name('resend.verification');
            Route::get('verify/{token}', [
                AuthController::class,
                'verify',
            ])->name('verify');
            Route::post('forgot_password', [
                AuthController::class,
                'forgot_password',
            ])->name('forgot.password');
            Route::post('reset_password', [
                AuthController::class,
                'reset_password',
            ])->name('reset.password');
            Route::post('login', [AuthController::class, 'login'])->name(
                'login'
            );
            Route::get('logout', function () {
                Session::flush();
                Auth::logout();

                return redirect(url('/'));
            })->name('logout');
        });

        // Dashboard
        Route::prefix('dashboard')->group(function () {
            Route::get('main', [MainController::class, 'index'])->name(
                'dashboard.main'
            );

            // Navigation
            Route::resource('headermenu', HeaderMenuController::class);
            Route::get('headermenu_datatable', [
                HeaderMenuController::class,
                'index_dt',
            ])->name('headermenu.datatable');
            Route::resource('footermenu', FooterMenuController::class);
            Route::get('footermenu_datatable', [
                FooterMenuController::class,
                'index_dt',
            ])->name('footermenu.datatable');

            // Component (CRUD Dasar)
            Route::post('component/bulk-delete', [ComponentController::class, 'bulkDestroy'])
                ->name('component.bulk-destroy');
            Route::resource('component', ComponentController::class); // Ini mencakup index, create, store, edit, update, destroy
            Route::get('component_datatable', [
                ComponentController::class,
                'index_dt',
            ])->name('component.datatable');

            // Content Image (BARU)
            Route::post('content-image/bulk-delete', [ContentImageController::class, 'bulkDestroy'])
            ->name('content-image.bulk-destroy');

            Route::resource('content-image', ContentImageController::class);
            Route::get('contentimage_datatable', [
                ContentImageController::class,
                'index_dt',
            ])->name('content-image.datatable'); // Sesuaikan nama route

            // Content Text (BARU)
            Route::post('content-text/bulk-delete', [ContentTextController::class, 'bulkDestroy'])
            ->name('content-text.bulk-destroy')
            ->middleware(['permission:contenttext-destroy']); // Ganti permission

            Route::resource('content-text', ContentTextController::class);
            Route::get('contenttext_datatable', [
                ContentTextController::class,
                'index_dt',
            ])->name('content-text.datatable'); // Ganti nama route

            // Media Library
            Route::resource('media-library', MediaLibraryController::class);
            Route::get('medialibrary_datatable', [
                MediaLibraryController::class,
                'index_dt',
            ])->name('media-library.datatable');

            // Blog
            Route::resource('post', PostController::class);
            Route::get('post_datatable', [
                PostController::class,
                'index_dt',
            ])->name('post.datatable');
            Route::resource('category', CategoryController::class);
            Route::get('category_datatable', [
                CategoryController::class,
                'index_dt',
            ])->name('category.datatable');
            Route::resource('tag', TagController::class);
            Route::get('tag_datatable', [
                TagController::class,
                'index_dt',
            ])->name('tag.datatable');

            // Settings
            Route::get('general', [GeneralController::class, 'index'])->name(
                'general.index'
            );
            Route::post('general/description/update', [
                GeneralController::class,
                'update_site_description',
            ])->name('general.update.description');
            Route::post('general/logo_favicon/update', [
                GeneralController::class,
                'update_site_logo_favicon',
            ])->name('general.update.logo.favicon');
            Route::resource('social_media', SocialMediaController::class);
            Route::get('social_media_dt', [
                SocialMediaController::class,
                'index_dt',
            ])->name('social_media.datatable');

            // Email
            Route::resource('message', MessageController::class);
            Route::post('message/readon', [
                MessageController::class,
                'ReadOn',
            ])->name('message.read.on');
            Route::post('message/readoff', [
                MessageController::class,
                'ReadOff',
            ])->name('message.read.off');
            Route::get('message/notification/count', [
                MessageController::class,
                'MessageNotificationCount',
            ])->name('message.notification.count');
            Route::get('message_datatable', [
                MessageController::class,
                'index_dt',
            ])->name('message.datatable');

            // SEO
            Route::resource('meta', MetaController::class);
            Route::get('meta_datatable', [
                MetaController::class,
                'index_dt',
            ])->name('meta.datatable');
            Route::resource('canonical', CanonicalController::class);
            Route::get('canonical_datatable', [
                CanonicalController::class,
                'index_dt',
            ])->name('canonical.datatable');
            Route::resource('opengraph', OpengraphController::class);
            Route::get('opengraph_datatable', [
                OpengraphController::class,
                'index_dt',
            ])->name('opengraph.datatable');
            Route::resource('schema', SchemaController::class);
            Route::get('schema_datatable', [SchemaController::class, 'index_dt'])->name('schema.datatable');

            // User & Permissions
            Route::resource('user', UserController::class);
            Route::get('user_datatable', [
                UserController::class,
                'index_dt',
            ])->name('user.datatable');
            Route::resource('permission', PermissionController::class);
            Route::get('permission_datatable', [
                PermissionController::class,
                'index_dt',
            ])->name('permission.datatable');
            Route::resource('role', RoleController::class);
            Route::get('role_datatable', [
                RoleController::class,
                'index_dt',
            ])->name('role.datatable');

            //  System
            Route::get('activity', [ActivityController::class, 'index'])->name(
                'activity.index'
            );
            Route::get('activity/{id}/destroy', [
                ActivityController::class,
                'destroy',
            ])->name('activity.destroy');
            Route::get('activity/empty', [
                ActivityController::class,
                'empty',
            ])->name('activity.empty');
            Route::get('activity_datatable', [
                ActivityController::class,
                'index_dt',
            ])->name('activity.datatable');
            Route::get('maintenance', [
                MaintenanceController::class,
                'index',
            ])->name('maintenance.index');
            Route::get('maintenance/generate/sitemap', [
                MaintenanceController::class,
                'generate_sitemap',
            ])->name('maintenance.generate.sitemap');
            Route::get('maintenance/event/clear', [
                MaintenanceController::class,
                'event_clear',
            ])->name('maintenance.event.clear');
            Route::get('maintenance/view/clear', [
                MaintenanceController::class,
                'view_clear',
            ])->name('maintenance.view.clear');
            Route::get('maintenance/cache/clear', [
                MaintenanceController::class,
                'cache_clear',
            ])->name('maintenance.cache.clear');
            Route::get('maintenance/config/clear', [
                MaintenanceController::class,
                'config_clear',
            ])->name('maintenance.config.clear');
            Route::get('maintenance/route/clear', [
                MaintenanceController::class,
                'route_clear',
            ])->name('maintenance.route.clear');
            Route::get('maintenance/compile/clear', [
                MaintenanceController::class,
                'compile_clear',
            ])->name('maintenance.compile.clear');
            Route::get('maintenance/optimize/clear', [
                MaintenanceController::class,
                'optimize_clear',
            ])->name('maintenance.optimize.clear');
        });
    }
);

Route::fallback(function () {
    return view('errors.404');
});

Route::get('factory-reset', function () {
    Artisan::call('factory-reset');

    return redirect()->route('site.index');
})
    ->name('maintenance.factory.reset')
    ->middleware('auth', 'verified');

// Use it for Recovery System
Route::group(
    [
        'prefix' => 'command',
    ],
    function () {
        Route::get('factory-reset', function () {
            Artisan::call('factory-reset');
        });

        Route::get('storage-delete', function () {
            Storage::deleteDirectory('public');
            Storage::makeDirectory('public');
        });

        Route::get('migrate-reset', function () {
            Artisan::call('migrate:reset');
        });

        Route::get('migrate-fresh', function () {
            Artisan::call('migrate:fresh --seed');
        });

        Route::get('storage-link', function () {
            Artisan::call('storage:link --force');
        });

        Route::get('config-cache', function () {
            Artisan::call('config:cache');
        });
    }
);

// Request Testing
Route::group(
    [
        'prefix' => LaravelLocalization::setlocale(),
    ],
    function () {
        Route::get('test', [TestController::class, 'index']);
        Route::get('sidebar', [TestController::class, 'sidebar']);
    }
);
