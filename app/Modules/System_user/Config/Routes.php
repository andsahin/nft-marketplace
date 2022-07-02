<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\System_user\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('account/admin_information/(:num)', 'Admin::form/$1');
    $subroutes->add('account/admin_list', 'Admin::index');
    $subroutes->add('account/admin_information', 'Admin::form');
    $subroutes->add('admin/delete/(:num)', 'Admin::delete/$1');
    $subroutes->add('account/profile_info', 'Admin::profile');
    $subroutes->add('account/edit_profile', 'Admin::edit_profile');

});

