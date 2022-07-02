<?php


$ADMINMENU['admin'] = array(
    'order'         => 1,
    'parent'        => 'Admin',
    'status'        => 1,
    'link'          => 'Admin',
    'icon'          => '<i class="fa fa-user"></i>',
    'submenu'       => array(
                
                '0' => array(
                    'name'          => 'Admin Users',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'account/admin_list',
                    'segment'       => 3,
                    'segment_text'  => 'admin_list',
                ),
                '1' => array(
                    'name'          => 'Add Admin User',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'account/admin_information',
                    'segment'       => 3,
                    'segment_text'  => 'admin_information',
                )
    ),
    'segment'       => 2,
    'segment_text'  => 'admin'
);