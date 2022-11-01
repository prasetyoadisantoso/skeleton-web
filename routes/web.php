<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Dashboard\MainController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\TestAuthController;
use App\Http\Controllers\TestCRUDController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\SendVerification;

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

    // Testing
    Route::prefix('test')->group(function () {

        Route::get('test', [TestCRUDController::class, 'index'])->name('test.home');

        // CRUD Test
        Route::prefix('crud')->group(function () {
            Route::get('create', [TestCRUDController::class, 'create'])->name('test.create');
            Route::post('store', [TestCRUDController::class, 'store'])->name('test.store');
            Route::get('detail/{id}', [TestCRUDController::class, 'show'])->name('test.show');
            Route::get('edit/{id}', [TestCRUDController::class, 'edit'])->name('test.edit');
            Route::put('update/{id}', [TestCRUDController::class, 'update'])->name('test.update');
            Route::delete('delete/{id}', [TestCRUDController::class, 'delete'])->name('test.delete');
        });

        // Auth Test
        Route::prefix('auth')->group(function () {

            // Page
            Route::get('login/admin/page', [TestAuthController::class, 'admin_login_page'])->name('test.login.admin.home');
            Route::get('login/client/page', [TestAuthController::class, 'client_login_page'])->name('test.login.client.home');
            Route::get('register/page', [TestAuthController::class, 'register_page'])->name('test.register.home');
            Route::get('verify/page', [TestAuthController::class, 'register_page'])->name('test.verify.home');
            Route::get('reset/page', [TestAuthController::class, 'reset_password_page'])->name('test.reset.home');
            Route::get('reset/form', [TestAuthController::class, 'reset_password_form'])->name('test.reset.form');

            // Logic
            Route::post('register/{type}', [TestAuthController::class, 'register'])->name('test.client.register');
            Route::post('verify', [TestAuthController::class, 'verify'])->name('test.client.verify');
            Route::post('resend/verification', [TestAuthController::class, 'resend_verification'])->name('test.client.resend');
            Route::post('resend/reset-password', [TestAuthController::class, 'resend_reset_password'])->name('test.client.resend.reset');
            Route::post('check/reset-password', [TestAuthController::class, 'check_reset_password'])->name('test.client.check.reset');
            Route::post('reset-password', [TestAuthController::class, 'reset_password'])->name('test.client.reset');
            Route::post('login/client', [TestAuthController::class, 'client_login'])->name('test.client.login');
            Route::post('login/administrator', [TestAuthController::class, 'admin_login'])->name('test.admin.login');

        });

        /**
         *  Send Email Verification via Browser
         *  test it via `php artisan serve`, open url/test/verification in your browser
         **/
        Route::get('verification', function(){
            Mail::to("example@gmail.com")->send(new SendVerification("Encrypted Token"));
        });

    });

    Route::get('/demo', function () {
        return new App\Mail\SendVerification("1111");
    });

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

    Route::prefix('dashboard')->group(function(){
        Route::get('main', [MainController::class, 'index'])->name('dashboard.main');
        Route::resource('user', UserController::class);
        Route::get('user_datatable', [UserController::class, 'index_dt'])->name('user.datatable');
    });

});
