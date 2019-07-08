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
    Route::post('register', 'UserController@register')->name('register');//注册
    Route::post('login', 'UserController@login')->name('login');//登录
    Route::post('verifyCode', 'UserController@verifyCode')->name('verifyCode');//获取验证码
    Route::get('staff', 'UserController@getUsers')->name('staff');//员工列表
    Route::get('{id}/tasks', 'UserController@tasks')->name('tasks');//员工任务列表
});

Route::name('api.user.')->prefix('user')->middleware('auth:api')->group(function () {
    Route::get('/', 'UserController@index')->name('index');//我的
    Route::get('/orders', 'UserController@orders')->name('orders');//我的订单
    Route::get('/rent', 'UserController@rentShow')->name('rent.show');//我的房租
    Route::post('/rent', 'UserController@rentStore')->name('rent.store');//交房租
    Route::post('/uploadLayout', 'UserController@uploadLayout')->name('uploadLayout');//上传房源
    Route::get('categories', 'UserController@categories')->name('categories');//员工管理的楼栋
});

Route::resource('regions', 'RegionController')->only(['index', 'show'])->names('api.regions');//区域
Route::resource('categories', 'CategoryController')->only(['index', 'show'])->names('api.categories');//楼栋
Route::resource('layouts', 'LayoutController')->only(['index', 'show'])->names('api.layouts');//户型
Route::resource('houses', 'HouseController')->only(['index', 'show'])->names('api.houses');//房间
Route::get('houses/{house}/tenants', 'HouseController@tenants')->name('api.houses.tenants');//房间的租客
Route::resource('banners', 'BannerController')->only(['index',])->names('api.banners');//banner

Route::name('api.index.')->prefix('index')->group(function () {
    Route::get('/', 'IndexController@index')->name('index');//首页
    Route::get('/houses', 'IndexController@houses')->name('houses');//首页房间
});

Route::name('api.common.')->prefix('common')->group(function () {
    Route::post('/upload', 'CommonController@upload')->name('upload');//上传
});

Route::post('/pay', 'PayController@store')->name('api.pay.store');//支付订单
Route::any('/pay/wechat_pay_notify', 'PayController@wechatPayNotify')->name('api.pay.wechat_pay_notify');//订房支付回调
Route::any('/pay/rent_pay_notify', 'PayController@rentPayNotify')->name('api.pay.rent_pay_notify');//交房租回调

//申请
Route::resource('house_ins', 'HouseInController')->only(['index', 'store', 'show',])->names('api.house_ins');
Route::resource('house_outs', 'HouseOutController')->only(['index', 'store', 'show', 'update',])->names('api.house_outs');
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

//后台 SELECT 接口
Route::name('api.admin_api.')->prefix('admin_api')->group(function () {
    Route::get('regions', 'RegionController@indexAdmin')->name('regions');//区域
    Route::get('categories', 'CategoryController@indexAdmin')->name('categories');//区域
    Route::get('layouts', 'LayoutController@indexAdmin')->name('layouts');//区域
    Route::get('houses', 'HouseController@indexAdmin')->name('houses');//区域
});
