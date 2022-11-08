<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Dashboard\MainController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => LaravelLocalization::setlocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect'],
], function () {

    // Home Page
    Route::get('/', function () {
        return view('welcome');
    });

    // Authentication
    Route::prefix('authentication')->group(function(){
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
    Route::prefix('dashboard')->group(function(){
        Route::get('main', [MainController::class, 'index'])->name('dashboard.main');
        Route::resource('user', UserController::class);
        Route::get('user_datatable', [UserController::class, 'index_dt'])->name('user.datatable');
    });

});

Route::group([
    'prefix' => 'testing'
],function(){
    # Place testing code here
    # <code>
    Route::resource('permission', PermissionController::class);
    Route::get('permission_datatable', [PermissionController::class, 'index_dt'])->name('permission.datatable');

    # Email template testing
    Route::get('/send-verification', function () {
        return new App\Mail\SendVerification("1111");
    });
});


