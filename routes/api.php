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

Route::name('api.user.')->prefix('user')->group(function () {
    Route::post('register', 'UserController@register')->name('register');
    Route::post('login', 'UserController@login')->name('login');
    Route::post('verifyCode', 'UserController@verifyCode')->name('verifyCode');
    Route::get('staff', 'UserController@getUsers')->name('staff');
});

Route::name('api.user.')->prefix('user')->middleware('auth:api')->group(function () {
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/orders', 'UserController@orders')->name('orders');
    Route::get('/rent', 'UserController@rent')->name('rent');
    Route::post('/uploadLayout', 'UserController@uploadLayout')->name('uploadLayout');

    Route::get('categories', 'UserController@categories')->name('categories');
});

Route::resource('categories', 'CategoryController')->only(['index', 'show'])->names('api.categories');
Route::resource('regions', 'RegionController')->only(['index', 'show'])->names('api.regions');
Route::resource('layouts', 'LayoutController')->only(['index', 'show'])->names('api.layouts');
Route::resource('houses', 'HouseController')->only(['index', 'show'])->names('api.houses');
Route::get('houses/{house}/tenants', 'HouseController@tenants')->name('api.houses.tenants');

Route::name('api.index.')->prefix('index')->group(function () {
    Route::get('/', 'IndexController@index')->name('index');
    Route::get('/houses', 'IndexController@houses')->name('houses');
});

Route::name('api.common.')->prefix('common')->group(function () {
    Route::post('/upload', 'CommonController@upload')->name('upload');
});

Route::resource('house_ins', 'HouseInController')->only(['index', 'store', 'show',])->names('api.house_ins');
Route::resource('house_outs', 'HouseOutController')->only(['index', 'store', 'show','update',])->names('api.house_outs');
Route::resource('visits', 'VisitController')->only(['index', 'store', 'show',])->names('api.visits');
Route::resource('job_logs', 'JobLogController')->only(['index', 'store', 'show',])->names('api.job_logs');
Route::resource('advises', 'AdviseController')->only(['index', 'store', 'show',])->names('api.advises');
Route::resource('renews', 'RenewController')->only(['index', 'store', 'show',])->names('api.renews');
Route::resource('reget_cards', 'RegetCardController')->only(['index', 'store', 'show',])->names('api.reget_cards');
Route::resource('posts', 'PostController')->only(['index', 'store', 'show',])->names('api.posts');
Route::resource('repairs', 'RepairController')->only(['index', 'store', 'show',])->names('api.repairs');
Route::resource('public_areas', 'PublicAreaController')->only(['index', 'store', 'show',])->names('api.public_areas');
Route::resource('borrows', 'BorrowController')->only(['index', 'store', 'show',])->names('api.borrows');
Route::resource('supports', 'SupportController')->only(['index', 'store', 'show',])->names('api.supports');
Route::resource('house_out_cleans', 'HouseOutCleanController')->only(['index', 'store', 'show',])->names('api.house_out_cleans');
Route::resource('public_area_cleans', 'PublicAreaCleanController')->only(['index', 'store', 'show',])->names('api.public_area_cleans');
Route::resource('articles', 'ArticleController')->only(['index', 'store', 'show',])->names('api.articles');
Route::resource('tasks', 'TaskController')->only(['index', 'store', 'show',])->names('api.tasks');
Route::resource('appointments', 'AppointmentController')->only(['index', 'store', 'show',])->names('api.appointments');
Route::resource('banners', 'BannerController')->only(['index',])->names('api.banners');


//审批
Route::post('house_ins/{id}/approve', 'HouseInController@approve')->name('api.house_ins.approve');
Route::post('house_outs/{id}/approve', 'HouseOutController@approve')->name('api.house_ins.approve');
Route::post('visits/{id}/approve', 'VisitController@approve')->name('api.visits.approve');
Route::post('advises/{id}/approve', 'AdviseController@approve')->name('api.advises.approve');
Route::post('renews/{id}/approve', 'RenewController@approve')->name('api.renews.approve');
Route::post('reget_cards/{id}/approve', 'RegetCardController@approve')->name('api.reget_cards.approve');
Route::post('posts/{id}/approve', 'PostController@approve')->name('api.posts.approve');
Route::post('repairs/{id}/approve', 'RepairController@approve')->name('api.repairs.approve');
Route::post('public_areas/{id}/approve', 'PublicAreaController@approve')->name('api.public_areas.approve');
Route::post('borrows/{id}/approve', 'BorrowController@approve')->name('api.borrows.approve');
Route::post('supports/{id}/approve', 'SupportController@approve')->name('api.supports.approve');
Route::post('house_out_cleans/{id}/approve', 'HouseOutCleanController@approve')->name('api.house_out_cleans.approve');
Route::post('public_area_cleans/{id}/approve', 'PublicAreaCleanController@approve')->name('api.public_area_cleans.approve');
Route::post('articles/{id}/approve', 'ArticleController@approve')->name('api.articles.approve');
Route::post('tasks/{id}/approve', 'TaskController@approve')->name('api.tasks.approve');
