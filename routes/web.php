<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DegustationController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::name('degustations.')->group(function() {
    Route::get('/degustations', [DegustationController::class, 'index'])->name('index');
    Route::post('/degustations', [DegustationController::class, 'store'])->name('store');
    Route::get('/degustations/{degustation}', [DegustationController::class, 'show'])->name('show');
    Route::put('/degustations/{degustation}', [DegustationController::class, 'update'])->name('update');
    Route::delete('/degustations/{degustation}', [DegustationController::class, 'destroy'])->name('destroy');
});

Route::name('products.')->group(function() {
    Route::get('/degustations/{degustation}/products', [ProductController::class, 'index'])
        ->name('index');
});
