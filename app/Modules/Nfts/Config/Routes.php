<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}



$routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\Nfts\Controllers\Admin'], function ($subroutes) {
    /*** Route for nft setting***/
    $subroutes->add('nft/nft_setup', 'Nfts_setup::index');
    $subroutes->add('nft/wallet_import', 'Nfts_setup::wallet_setup');
    $subroutes->add('nft/wallet_reload/(:num)', 'Nfts_setup::wallet_balance/$1');
    $subroutes->add('nft/add_network', 'Nfts_setup::network_setup');
    $subroutes->add('nft/update_network/(:num)', 'Nfts_setup::networkUpdate/$1');
    $subroutes->add('nft/file_gateway_setup', 'Nfts_setup::fileGateway');
    $subroutes->add('nft/file_gateway_update/(:num)', 'Nfts_setup::fileGatewayUpdate/$1');
    $subroutes->add('nft/typestatuschange/(:any)', 'Nfts_setup::type_status_change/$1');
    $subroutes->add('nft/nft_setup_ajax', 'Nfts_setup::contract_setup_ajax');
    $subroutes->add('nft/set_contract', 'Nfts_setup::setContract');

    $subroutes->add('nft/sale_type_control', 'Nfts_setup::saleTypeControl');
    $subroutes->add('nft/transfer_option', 'Nfts_setup::transferOption');
    $subroutes->add('nft/transfer_option_change/(:any)', 'Nfts_setup::transfer_option_status_change/$1');

    $subroutes->add('nft/contract', 'Nfts_setup::contract_setup');

    /** Route for category  **/
    $subroutes->add('nft/categories', 'Categories::index');
    $subroutes->add('nft/add_category', 'Categories::add');
    $subroutes->add('nft/update_category/(:num)', 'Categories::update/$1');
    $subroutes->add('nft/delete/(:num)', 'Categories::category_delete/$1');  

    /** Users collections route  */
    $subroutes->add('nft/collections', 'Categories::user_collection');
    $subroutes->add('nft/add_collection', 'Categories::addCollection');
    $subroutes->add('nft/update_collection/(:num)', 'Categories::updateCollection/$1');
    $subroutes->add('nft/delete_collection/(:num)', 'Categories::deleteCollection/$1'); 

    /*** Route for admin nft List ***/
    $subroutes->add('nft/list', 'Nfts::index'); 
    $subroutes->add('nft/ajax_list', 'Nfts::ajax_list'); 
    $subroutes->add('nft/ajax_c/(:any)', 'Nfts::ajax_collection/$1');
    $subroutes->add('nft/details/(:num)', 'Nfts::nftDetails/$1');
    $subroutes->add('nft/changestatus/(:any)', 'Nfts::change_status/$1'); 
    $subroutes->add('nft/is_featured/(:any)', 'Nfts::isFeatured/$1');
    
    
});



$routes->group('user', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Nfts\Controllers\Users'], function ($subroutes){
    /*** Route for customer login***/
    $subroutes->add('mynft', 'User_nfts::index'); 
    $subroutes->add('asset/(:any)', 'User_nfts::assetMethods/$1'); 
    $subroutes->add('bidlist/(:any)', 'User_nfts::bidlist/$1');  
    $subroutes->add('ajax_coll/(:any)', 'User_nfts::ajax_collection/$1');
    $subroutes->add('my-collection', 'User_nfts::list_collection'); 
    $subroutes->add('add-collection', 'User_nfts::add_collection'); 
    $subroutes->add('edit-collection/(:num)', 'User_nfts::update_collection/$1'); 
    $subroutes->add('check_wallet/(:any)', 'User_nfts::checkWallet/$1'); 
    $subroutes->add('assets/transfer/(:any)', 'User_nfts::transferNft/$1'); 
    $subroutes->add('confirm_sale/(:any)', 'User_nfts::confirm_sale/$1'); 
    $subroutes->add('mynft_update/(:any)', 'User_nfts::updateNft/$1'); 
    $subroutes->add('sale_confirmation/(:any)', 'User_nfts::saleConfirm/$1'); 
    $subroutes->add('favourite_items', 'User_nfts::favouriteItems'); 
});

$routes->group('nfts', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Nfts\Controllers\Users'], function ($subroutes) {
    $subroutes->add('create', 'User_nfts::create_new_nft'); 
    $subroutes->add('checkcollection/(:any)', 'User_nfts::checkColelctionName/$1'); 
    $subroutes->add('checkcollectionslug/(:any)', 'User_nfts::checkColelctionSlug/$1');
    $subroutes->add('biding', 'User_nfts::biding');
});

$routes->group('accounts', ['filter' => 'customer_filter', 'namespace' => 'App\Modules\Nfts\Controllers\Users'], function ($subroutes) {
    $subroutes->add('get_balance', 'Accounts::getBalance'); 
});
     

