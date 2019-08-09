<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->redirect('/', '/admin/rent_logs')->name('admin.home');

    $router->resource('rent_logs', 'RentLogController')->names('admin.rent_logs');
    $router->resource('regions', 'RegionController')->names('admin.regions');
    $router->resource('categories', 'CategoryController')->names('admin.categories');
    $router->resource('layouts', 'LayoutController')->names('admin.layouts');
    $router->resource('houses', 'HouseController')->names('admin.houses');
    $router->resource('banners', 'BannerController')->names('admin.banners');

    $router->resource('users', 'UserController')->names('admin.users');
    $router->resource('roles', 'RoleController')->names('admin.roles');
    $router->resource('permissions', 'PermissionController')->names('admin.permissions');

    $router->get('send_tmp_smg', 'RentLogController@sendTmpMsg')->name('admin.send_tmp_msg');

});
