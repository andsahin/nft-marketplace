<?php
 
$CUSTOMERMENU['nfts'] = array(
    'order'         => 3,
    'parent'        => 'NFT\'s',
    'status'        => 1,
    'link'          => 'nfts',
    'icon'          => '<i class="fas fa-cog"></i>',
    'submenu'       => array(
            '0' => array(
                    'name'          => 'My Collection\'s',
                    'icon'          => null,
                    'link'          => 'my_collection',
                    'segment'       => 2,
                    'segment_text'  => 'my_collection',
                ),
            '1' => array(
                    'name'          => 'My NFT\'s',
                    'icon'          => null,
                    'link'          => 'mynft',
                    'segment'       => 2,
                    'segment_text'  => 'mynft',
                ), 
            '3' => array(
                    'name'          => 'Favorites',
                    'icon'          => null,
                    'link'          => 'favourite_items',
                    'segment'       => 2,
                    'segment_text'  => 'favourite_items',
                ),
            ),
    'segment'       => 2,
    'segment_text'  => 'setting'
);
