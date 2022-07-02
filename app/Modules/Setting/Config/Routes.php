<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('',['filter' => 'admin_filter', 'namespace' => 'App\Modules\Setting\Controllers\Admin'], function ($subroutes) {
    $subroutes->add('internal_api/getemailsmsgateway', 'Internal_api::getemailsmsgateway');
});

$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Setting\Controllers\Admin'], function ($subroutes) {
    /*** Route for admin setting***/
    $subroutes->add('setting/app_setting', 'Setting::index');
    $subroutes->add('setting/fees_setting', 'Setting::fees_setting'); 
    $subroutes->add('setting/fees_setting_save', 'Setting::fees_setting_save');
    $subroutes->add('setting/delete_fees_setting/(:num)', 'Setting::delete_fees_setting/$1'); 
    $subroutes->add('setting/update_sender', 'Setting::update_sender');
    $subroutes->add('setting/email_gateway', 'Setting::email_gateway');
    $subroutes->add('setting/test_email', 'Setting::test_email');
    $subroutes->add('setting/update_email_gateway', 'Setting::update_email_gateway'); 
    $subroutes->add('setting/smsemail_template', 'Setting::sms_email_template');
    $subroutes->add('setting/smsemail_templateform/(:num)', 'Setting::sms_email_template_form/$1'); 
    $subroutes->add('setting/test_sms', 'Setting::test_sms');
    $subroutes->add('externalapi/api_list', 'Setting::api_list');
    $subroutes->add('externalapi/external_api_setup/(:num)', 'Setting::api_form/$1');
     

    $subroutes->add('setting/nft_setup', 'Nfts_setup::index');
    $subroutes->add('setting/wallet_import', 'Nfts_setup::wallet_setup');
    $subroutes->add('setting/wallet_reload/(:num)', 'Nfts_setup::wallet_balance/$1');
    $subroutes->add('setting/add_network', 'Nfts_setup::network_setup');
});