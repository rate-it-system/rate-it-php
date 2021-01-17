<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

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

Route::middleware('auth:api')->name('api.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('degustations/{degustation}/redyToStart', 'Api\SessionController@userReady')
        ->name('redyToStart');
    Route::name('session.')->group(function () {
        Route::get('session/isStarted', 'Api\SessionController@isStarted')
            ->name('isStarted');
        Route::get('session/currentProduct', 'Api\SessionController@currentProduct')
            ->name('currentProduct');
        Route::get('session/currentProduct/{degustationfeature}/rate/{rate}', 'Api\SessionController@rateProduct')
            ->name('rateProduct');
        Route::get('session/progressProduct', 'Api\SessionController@getProgressProduct')
            ->name('progressProduct');
        Route::get('session/nextProduct', 'Api\SessionController@nextProduct')
            ->name('nextProduct');
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

    Route::name('products.')->group(function () {
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

    Route::name('members.')->group(function () {
        Route::get('degustations/{degustation}/members', 'Api\MemberController@index')
            ->name('index');
        Route::get('degustations/{degustation}/members/{member}', 'Api\MemberController@show')
            ->name('show');
        Route::delete('degustations/{degustation}/members/{member}', 'Api\MemberController@destroy')
            ->name('destroy');
    });

    Route::name('invitations.')->group(function () {
        Route::get('invitations/{invitationKey}', 'Api\InvitationController@acceptance')
            ->name('acceptance');
    });

    Route::name('features.')->group(function () {
        Route::get('degustations/{degustation}/features', 'Api\FeatureController@index')
            ->name('index');
        Route::post('degustations/{degustation}/features', 'Api\FeatureController@store')
            ->name('store');
        Route::get('degustations/{degustation}/features/{feature}', 'Api\FeatureController@show')
            ->name('show');
        Route::put('degustations/{degustation}/features/{feature}', 'Api\FeatureController@update')
            ->name('update');
        Route::delete('degustations/{degustation}/features/{feature}', 'Api\FeatureController@destroy')
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
