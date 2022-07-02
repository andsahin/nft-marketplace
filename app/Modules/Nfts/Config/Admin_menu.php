<?php


$ADMINMENU['nft_setup'] = array(
    'order'         => 4,
    'parent'        => 'NFT Setup',
    'status'        => 1,
    'link'          => 'NFT Setup',
    'icon'          => '<i class="fa fa-cogs"></i>',
    'submenu'       => array(
                
                '0' => array(
                    'name'          => 'NFT Setup',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'nft/nft_setup',
                    'segment'       => 3,
                    'segment_text'  => 'nft_setup','add_network'
                ),
                '1' => array(
                    'name'          => 'Contract Deploy',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'nft/contract',
                    'segment'       => 3,
                    'segment_text'  => 'contract'
                ),
                      
    ),
    'segment'       => 2,
    'segment_text'  => 'nft_setup'
);

$ADMINMENU['nfts'] = array(
    'order'         => 3,
    'parent'        => 'NFT\'s',
    'status'        => 1,
    'link'          => 'nft-list',
    'icon'          => '<i class="fa fa-braille"></i>',
    'submenu'       => array( 
                 
                '0' => array(
                    'name'          => 'NFT List',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'nft/list',
                    'segment'       => 3,
                    'segment_text'  => 'list'
                ),
                '1' => array(
                    'name'          => 'Categories',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'nft/categories',
                    'segment'       => 3,
                    'segment_text'  => 'categories'
                ),
                '2' => array(
                    'name'          => 'Add Category',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'nft/add_category',
                    'segment'       => 3,
                    'segment_text'  => 'add_category'
                ),
                '3' => array(
                    'name'          => 'Collections',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'nft/collections',
                    'segment'       => 3,
                    'segment_text'  => 'collections', 'update_collection'
                ),
                '4' => array(
                    'name'          => 'Add Collection',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'nft/add_collection',
                    'segment'       => 3,
                    'segment_text'  => 'add_collection'
                ),  
               
                
    ),
    'segment'       => 2,
    'segment_text'  => 'nft_setup'
);