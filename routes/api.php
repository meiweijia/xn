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
    Route::post('/uploadHouse', 'UserController@uploadHouse')->name('uploadHouse');
});

Route::name('api.index.')->prefix('index')->group(function () {
    Route::get('/', 'IndexController@index')->name('index');

    Route::get('/houses', 'IndexController@houses')->name('houses');
});

