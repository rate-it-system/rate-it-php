<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\api\DegustationApiController;
use App\Http\Controllers\api\ProductApiController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.degustations.')->group(function () {
    Route::get('degustations', [DegustationApiController::class, 'index'])->name('index');
    Route::post('degustations', [DegustationApiController::class, 'store'])->name('store');
    Route::get('degustations/{degustation}', [DegustationApiController::class, 'show'])->name('show');
    Route::put('degustations/{degustation}', [DegustationApiController::class, 'update'])->name('update');
    Route::delete('degustations/{degustation}', [DegustationApiController::class, 'destroy'])->name('destroy');
});

Route::name('api.products.')->group(function() {
    Route::get('degustations/{degustation}/products', [ProductApiController::class, 'index'])
        ->name('index');
    Route::post('degustations/{degustation}/products', [ProductApiController::class, 'store'])
        ->name('store');
    Route::get('degustations/{degustation}/products/{product}', [ProductApiController::class, 'show'])
        ->name('show');
    Route::put('degustations/{degustation}/products/{product}', [ProductApiController::class, 'update'])
        ->name('update');
    Route::delete('degustations/{degustation}/products/{product}', [ProductApiController::class, 'destroy'])
        ->name('destroy');
});
