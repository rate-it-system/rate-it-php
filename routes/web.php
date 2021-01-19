<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::name('degustations.')->group(function() {
    Route::get('/degustations', 'DegustationController@index')
        ->name('index');
    Route::post('/degustations', 'DegustationController@store')
        ->name('store');
    Route::get('/degustations/{degustation}', 'DegustationController@show')
        ->name('show');
    Route::put('/degustations/{degustation}', 'DegustationController@update')
        ->name('update');
    Route::delete('/degustations/{degustation}', 'DegustationController@destroy')
    ->name('destroy');
});

Route::name('products.')->group(function() {
    Route::get('/degustations/{degustation}/products', 'ProductController@index')
        ->name('index');
    Route::post('/degustations/{degustation}/products', 'ProductController@store')
        ->name('store');
    Route::get('/degustations/{degustation}/products/{product}', 'ProductController@show')
        ->name('show');
    Route::put('/degustations/{degustation}/products/{product}', 'ProductController@update')
        ->name('update');
    Route::delete('/degustations/{degustation}/products/{product}', 'ProductController@destroy')
        ->name('destroy');
});

Route::name('members.')->group(function() {
    Route::get('/degustations/{degustation}/members', 'MemberController@index')
        ->name('index');
    Route::get('/degustations/{degustation}/members/{member}', 'MemberController@show')
        ->name('show');
    Route::delete('/degustations/{degustation}/members/{member}', 'MemberController@destroy')
        ->name('destroy');
});

Route::group(['middleware' => 'guest'], function() {
    Route::get('/login/facebook', 'Auth\LoginController@facebook')
        ->name('facebook');
    Route::get('/login/facebook/callback', 'Auth\LoginController@facebookCallback')
        ->name('facebookCallback');

    Route::get('/login/google', 'Auth\LoginController@google')
        ->name('google');
    Route::get('/login/google/callback', 'Auth\LoginController@googleCallback')
        ->name('googleCallback');
});
