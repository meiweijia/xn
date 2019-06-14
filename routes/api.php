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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.user.')->prefix('user')->group(function () {
    Route::post('register', 'UserController@register')->name('register');
    Route::post('login', 'UserController@login')->name('login');
    Route::post('verifyCode', 'UserController@verifyCode')->name('verifyCode');
});

Route::name('api.user.')->prefix('user')->middleware('auth:api')->group(function () {
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/orders', 'UserController@orders')->name('orders');
    Route::get('/rent', 'UserController@rent')->name('rent');
    Route::post('/uploadLayout', 'UserController@uploadLayout')->name('uploadLayout');
});

Route::resource('categories', 'CategoryController')->only(['index', 'show'])->names('api.categories');
Route::resource('regions', 'RegionController')->only(['index', 'show'])->names('api.regions');
Route::resource('layouts', 'LayoutController')->only(['index', 'show'])->names('api.layouts');
Route::resource('houses', 'HouseController')->only(['index', 'show'])->names('api.houses');

Route::name('api.index.')->prefix('index')->group(function () {
    Route::get('/', 'IndexController@index')->name('index');
    Route::get('/houses', 'IndexController@houses')->name('houses');
});

