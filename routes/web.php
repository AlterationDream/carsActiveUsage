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

Route::get('/', function () {
    return view('run-api');
});

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::post('api/users/list', 'list');
    Route::post('api/users/create', 'create');
    Route::post('api/users/update', 'update');
    Route::post('api/users/delete', 'delete');
});

Route::controller(\App\Http\Controllers\CarController::class)->group(function () {
    Route::post('api/cars/list', 'list');
    Route::post('api/cars/create', 'create');
    Route::post('api/cars/update', 'update');
    Route::post('api/cars/delete', 'delete');
});

Route::controller(\App\Http\Controllers\ActiveUseController::class)->group(function () {
    Route::post('api/active-uses/list', 'list');
    Route::post('api/active-uses/create', 'create');
    Route::post('api/active-uses/update', 'update');
    Route::post('api/active-uses/delete', 'delete');
});
