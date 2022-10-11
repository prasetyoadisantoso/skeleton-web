<?php

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
        Route::get('test', [TestCRUDController::class, 'index'])->name('test');
        Route::get('create', [TestCRUDController::class, 'create'])->name('test.create');
        Route::post('store', [TestCRUDController::class, 'store'])->name('test.store');
        Route::get('detail/{id}', [TestCRUDController::class, 'show'])->name('test.show');
        Route::get('edit/{id}', [TestCRUDController::class, 'edit'])->name('test.edit');
        Route::put('update/{id}', [TestCRUDController::class, 'update'])->name('test.update');
        Route::delete('delete/{id}', [TestCRUDController::class, 'delete'])->name('test.delete');
    });

    Route::prefix('authentication')->group(function () {
    });
});
