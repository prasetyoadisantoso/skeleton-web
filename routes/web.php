<?php

use App\Http\Controllers\TestAuthController;
use App\Http\Controllers\TestCRUDController;
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
            Route::get('register/page', [TestAuthController::class, 'index'])->name('test.register.home');
            Route::post('register/{type}', [TestAuthController::class, 'register'])->name('test.client.register');
        });

    });

});
