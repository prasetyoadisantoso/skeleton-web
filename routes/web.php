<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\ActivityController;
use App\Http\Controllers\Backend\CanonicalController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\GeneralController;
use App\Http\Controllers\Backend\MainController;
use App\Http\Controllers\Backend\MaintenanceController;
use App\Http\Controllers\Backend\MessageController;
use App\Http\Controllers\Backend\MetaController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SocialMediaController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\OpengraphController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

/**
 * Development - Production Mode
 */
Route::group([
    'prefix' => LaravelLocalization::setlocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect'],
], function () {

    // Home Page
    Route::get('/', [HomeController::class, 'index'])->name('site.index');

    // Blog Page
    Route::get('blog', [BlogController::class, 'index'])->name('site.blog');
    Route::post('blog', [BlogController::class, 'search'])->name('site.blog.search')->middleware(['xss-sanitize']);
    Route::get('blog/category/{slug}', [BlogController::class, 'category'])->name('site.blog.category');
    Route::get('blog/tag/{slug}', [BlogController::class, 'tag'])->name('site.blog.tag');
    Route::get('blog/post/{slug}', [BlogController::class, 'post'])->name('site.blog.post');

    // Contact Page
    Route::get('contact', [ContactController::class,'index'])->name('site.contact');
    Route::post('contact/message', [ContactController::class, 'message'])->name('site.contact.message');

    // Authentication
    Route::prefix('authentication')->group(function () {
        Route::get('login/page', [AuthController::class, 'login_page'])->name('login.page');
        Route::get('register/page', [AuthController::class, 'register_page'])->name('register.page');
        Route::get('forgot_password/page', [AuthController::class, 'forgot_password_page'])->name('forgot.password.page');
        Route::get('reset_password/page/{token}', [AuthController::class, 'reset_password_page'])->name('reset.password.page');
        Route::post('register/{type}', [AuthController::class, 'register_client'])->name('register');
        Route::get('resend_verification/page', [AuthController::class, 'resend_verification_page'])->name('resend.verification.page');
        Route::post('resend_verification', [AuthController::class, 'resend_verification'])->name('resend.verification');
        Route::get('verify/{token}', [AuthController::class, 'verify'])->name('verify');
        Route::post('forgot_password', [AuthController::class, 'forgot_password'])->name('forgot.password');
        Route::post('reset_password', [AuthController::class, 'reset_password'])->name('reset.password');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::get('logout', function () {
            Session::flush();
            Auth::logout();
            return redirect(url('/'));
        })->name('logout');
    });

    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('main', [MainController::class, 'index'])->name('dashboard.main');

        // Blog
        Route::resource('post', PostController::class);
        Route::get('post_datatable', [PostController::class, 'index_dt'])->name('post.datatable');
        Route::post('post_upload_image', [PostController::class, 'upload'])->name('post.upload.image');
        Route::resource('category', CategoryController::class);
        Route::get('category_datatable', [CategoryController::class, 'index_dt'])->name('category.datatable');
        Route::resource('tag', TagController::class);
        Route::get('tag_datatable', [TagController::class, 'index_dt'])->name('tag.datatable');

        // Settings
        Route::get('general', [GeneralController::class, 'index'])->name('general.index');
        Route::post('general/description/update', [GeneralController::class, 'update_site_description'])->name('general.update.description');
        Route::post('general/logo_favicon/update', [GeneralController::class, 'update_site_logo_favicon'])->name('general.update.logo.favicon');
        Route::resource('social_media', SocialMediaController::class);
        Route::get('social_media_dt', [SocialMediaController::class, 'index_dt'])->name('social_media.datatable');

        // Email
        Route::resource('message', MessageController::class);
        Route::post('message/readon', [MessageController::class, 'ReadOn'])->name('message.read.on');
        Route::post('message/readoff', [MessageController::class, 'ReadOff'])->name('message.read.off');
        Route::get('message/notification/count', [MessageController::class, 'MessageNotificationCount'])->name('message.notification.count');
        Route::get('message_datatable', [MessageController::class, 'index_dt'])->name('message.datatable');

        // SEO
        Route::resource('meta', MetaController::class);
        Route::get('meta_datatable', [MetaController::class, 'index_dt'])->name('meta.datatable');
        Route::resource('canonical', CanonicalController::class);
        Route::get('canonical_datatable', [CanonicalController::class, 'index_dt'])->name('canonical.datatable');
        Route::resource('opengraph', OpengraphController::class);
        Route::get('opengraph_datatable', [OpengraphController::class, 'index_dt'])->name('opengraph.datatable');

        // User & Permissions
        Route::resource('user', UserController::class);
        Route::get('user_datatable', [UserController::class, 'index_dt'])->name('user.datatable');
        Route::resource('permission', PermissionController::class);
        Route::get('permission_datatable', [PermissionController::class, 'index_dt'])->name('permission.datatable');
        Route::resource('role', RoleController::class);
        Route::get('role_datatable', [RoleController::class, 'index_dt'])->name('role.datatable');

        //  System
        Route::get('activity', [ActivityController::class, 'index'])->name('activity.index');
        Route::get('activity/{id}/destroy', [ActivityController::class, 'destroy'])->name('activity.destroy');
        Route::get('activity/empty', [ActivityController::class, 'empty'])->name('activity.empty');
        Route::get('activity_datatable', [ActivityController::class, 'index_dt'])->name('activity.datatable');
        Route::get('maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
        Route::get('maintenance/event/clear', [MaintenanceController::class, 'event_clear'])->name('maintenance.event.clear');
        Route::get('maintenance/view/clear', [MaintenanceController::class, 'view_clear'])->name('maintenance.view.clear');
        Route::get('maintenance/cache/clear', [MaintenanceController::class, 'cache_clear'])->name('maintenance.cache.clear');
        Route::get('maintenance/config/clear', [MaintenanceController::class, 'config_clear'])->name('maintenance.config.clear');
        Route::get('maintenance/route/clear', [MaintenanceController::class, 'route_clear'])->name('maintenance.route.clear');
        Route::get('maintenance/compile/clear', [MaintenanceController::class, 'compile_clear'])->name('maintenance.compile.clear');
        Route::get('maintenance/optimize/clear', [MaintenanceController::class, 'optimize_clear'])->name('maintenance.optimize.clear');
        // Route::get('maintenance/factory_reset', [MaintenanceController::class, 'factory_reset'])->name('maintenance.factory.reset');
    });

});

/**
 * Testing Mode
 */
Route::group([
    'prefix' => 'testing',
], function () {
    # Place testing code here

    Route::get('create-form', [TestController::class, 'create'])->name('test.create');
    Route::post('create-form/store', [TestController::class, 'store'])->name('test.store');

    // Email template testing
    Route::get('/send-verification', function () {
        return new App\Mail\SendVerification("1111");
    });

});

Route::get('factory-reset', function(){
    Artisan::call('factory-reset');
    return response()->json([
        'success' => 'success'
    ]);
})->name('maintenance.factory.reset')->middleware('auth', 'verified');

// Use it for Recovery System
Route::group([
    'prefix' => 'command',
], function () {

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

});
