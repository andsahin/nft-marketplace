<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('user', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\User\Controllers\Customer'], function ($subroutes) {
    /*** Route for customer finance***/
    
    $subroutes->add('settings', 'Profile::index');
    $subroutes->add('profile/edit_profile', 'Profile::index');
    $subroutes->add('profile/update', 'Profile::Update');
    $subroutes->add('profile/change_password', 'Profile::change_password');
    $subroutes->add('profile/change_save', 'Profile::change_save');
    $subroutes->add('profile/profile_verify/(:any)', 'Profile::profile_verify/$1');
    $subroutes->add('profile/profile_update', 'Profile::profile_update');

    $subroutes->add('withdraw', 'Profile::withdraw');

});


$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\User\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin finance***/
    $subroutes->add('customers/customer_info/', 'User::form');
    $subroutes->add('customers/customer_info/(:num)', 'User::form/$1');
    $subroutes->add('customers/customer_list', 'User::index');
    $subroutes->add('customer/details/(:num)', 'User::details/$1');
    $subroutes->add('users/wallet_reload/(:num)', 'User::wallet_balance/$1');

});

$routes->group('', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\User\Controllers\Admin'], function ($subroutes) {
		$subroutes->add('user/ajax_list', 'User::ajax_list');
        $subroutes->add('user/deposit_list/(:any)', 'User::deposit_list/$1');
        $subroutes->add('user/investment_list/(:any)', 'User::investment_list/$1');
        $subroutes->add('user/withdraw_list/(:any)', 'User::withdraw_list/$1');
        $subroutes->add('user/transfer_list/(:any)', 'User::transfer_list/$1');
        $subroutes->add('user/transferreceive_list/(:any)', 'User::transferreceive_list/$1');
});