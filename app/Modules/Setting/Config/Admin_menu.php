<?php

$ADMINMENU['setting'] = array(
    'order'         => 15,
    'parent'        => 'Setting',
    'status'        => 1,
    'link'          => 'setting',
    'icon'          => '<i class="fas fa-cog"></i>',
    'submenu'       => array( 
                '1' => array(
                    'name'          => 'App Setting',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'setting/app_setting',
                    'segment'       => 3,
                    'segment_text'  => 'app_setting',
                ),
                
                '2' => array(
                    'name'          => 'Fees Setting',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'setting/fees_setting',
                    'segment'       => 3,
                    'segment_text'  => 'fees_setting',
                ),
                '3' => array(
                    'name'          => 'Selling Type',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'nft/sale_type_control',
                    'segment'       => 3,
                    'segment_text'  => 'sale_type_control'
                ),
                
                
                '6' => array(
                    'name'          => 'Email Gateway',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'setting/email_gateway',
                    'segment'       => 3,
                    'segment_text'  => 'email_gateway',
                ),

                '7' => array(
                    'name'          => 'External API',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'externalapi/api_list',
                    'segment'       => 3,
                    'segment_text'  => 'api_list',
                ),
                
                '8' => array(
                    'name'          => 'Email Template',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'setting/smsemail_template',
                    'segment'       => 3,
                    'segment_text'  => 'smsemail_template',
                ),

                 
                 

    ),
    'segment'       => 2,
    'segment_text'  => 'setting'
);