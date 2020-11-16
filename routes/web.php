<?php

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

use App\Http\Controllers\UserController;
Route::get('/login',[UserController::class, 'loginPage'])->name('login');
Route::post('/login',[UserController::class, 'login']);
Route::post('/logout',[UserController::class, 'logout']);

use App\Http\Controllers\MainController;
Route::get('/',[MainController::class, 'home']);



use App\Http\Controllers\DegustationController;
Route::get('/degustation/list',[DegustationController::class, 'list'])->name('list');
Route::get('/degustation/create',[DegustationController::class, 'create'])->name('create');
Route::get('/degustation/addMember',[DegustationController::class, 'addMember']);
Route::get('/degustation/addProduct',[DegustationController::class, 'addProduct']);
Route::post('/degustation/create',[DegustationController::class, 'doCreate']);
Route::post('/degustation/addMember',[DegustationController::class, 'doAddMember']);
Route::post('/degustation/addProduct',[DegustationController::class, 'doAddProduct']);
