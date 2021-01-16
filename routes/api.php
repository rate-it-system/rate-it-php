<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;

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

Route::middleware('auth:api')->name('api.')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::name('degustations.')->group(function () {
        Route::get('degustations', 'Api\DegustationController@index')
            ->name('index');
        Route::post('degustations', 'Api\DegustationController@store')
            ->name('store');
        Route::get('degustations/{degustation}', 'Api\DegustationController@show')
            ->name('show');
        Route::put('degustations/{degustation}', 'Api\DegustationController@update')
            ->name('update');
        Route::delete('degustations/{degustation}', 'Api\DegustationController@destroy')
            ->name('destroy');
    });

    Route::name('products.')->group(function() {
        Route::get('degustations/{degustation}/products', 'Api\ProductController@index')
            ->name('index');
        Route::post('degustations/{degustation}/products', 'Api\ProductController@store')
            ->name('store');
        Route::get('degustations/{degustation}/products/{product}', 'Api\ProductController@show')
            ->name('show');
        Route::put('degustations/{degustation}/products/{product}', 'Api\ProductController@update')
            ->name('update');
        Route::delete('degustations/{degustation}/products/{product}', 'Api\ProductController@destroy')
            ->name('destroy');
    });
});

Route::post('/login', [LoginController::class, 'loginNormal'])
    ->name('api.login');
Route::get('/login/{socialType}', [LoginController::class, 'redirectToProvider'])
    ->name('api.login.socialmedia');
Route::get('/login/{socialType}/callback', [LoginController::class, 'handleProviderCallback'])
    ->name('api.login.socialmedia.callback');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('api.register');
