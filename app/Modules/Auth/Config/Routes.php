<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('customer', ['namespace' => 'App\Modules\Auth\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer login***/
    $subroutes->add('/', 'User_auth::index');
    $subroutes->add('login', 'User_auth::index');
});
$routes->group('', ['namespace' => 'App\Modules\Auth\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer login***/
    $subroutes->add('login', 'User_auth::index');
});
$routes->group('user', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Auth\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer login***/
    $subroutes->add('home', 'User_dashboard::index');
    $subroutes->add('dashboard', 'User_dashboard::index');
    $subroutes->add('logout', 'User_auth::logout');
    $subroutes->add('getmynfts/(:any)', 'User_dashboard::mynfts/$1');
});

$routes->group('admin', ['namespace' => 'App\Modules\Auth\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin login***/
    $subroutes->add('/', 'Auth::index');
    $subroutes->add('login', 'Auth::index');
});

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Auth\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin login***/
    $subroutes->add('home', 'Dashboard::index');
    $subroutes->add('dashboard', 'Dashboard::index');
    $subroutes->add('testajax', 'Dashboard::ajaxCheck');
    $subroutes->add('comission/all_comission', 'Dashboard::comission');
    $subroutes->add('payout/all_payout', 'Dashboard::my_payout');
    $subroutes->add('investment/all_investment', 'Dashboard::investment');
});
$routes->group('', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Auth\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin login***/
        $subroutes->add('internal_api/getpiechartdata', 'Internal_api::getpiechartdata');
        $subroutes->add('internal_api/barchartdata', 'Internal_api::barchartdata');
        $subroutes->add('internal_api/userchartdata', 'Internal_api::userchartdata');
        $subroutes->add('internal_api/barchartdata/(:num)', 'Internal_api::barchartdata/$1');
        $subroutes->add('internal_api/getpiechartdata/(:num)', 'Internal_api::getpiechartdata/$1');
});