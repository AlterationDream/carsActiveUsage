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
    return view('welcome');
});

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::get('users', 'index');
    Route::post('users/create', 'store');
    Route::post('users/edit', 'update');
    Route::post('users/remove', 'remove');
});

Route::controller(\App\Http\Controllers\CarController::class)->group(function () {
    Route::get('cars', 'index');
    Route::post('cars/create', 'store');
    Route::post('cars/edit', 'update');
    Route::post('cars/remove', 'remove');
});

Route::controller(\App\Http\Controllers\ActiveUseController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('create', 'store');
    Route::post('edit', 'update');
    Route::post('remove', 'remove');
});
