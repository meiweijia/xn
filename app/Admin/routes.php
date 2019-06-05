<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->redirect('/', 'admin/rent_logs')->name('admin.home');

    $router->resource('rent_logs','RentLogController')->names('admin.rent_logs');

});
