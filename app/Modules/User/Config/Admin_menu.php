<?php
 

$ADMINMENU['user'] = array(
    'order'         => 2,
    'parent'        => 'Customers',
    'status'        => 1,
    'link'          => 'customers',
    'icon'          => '<i class="fa fa-users"></i>',
    'submenu'       => array(
                
                '0' => array(
                    'name'          => 'Customers',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'customers/customer_list',
                    'segment'       => 3,
                    'segment_text'  => 'customer_list',
                ),
                '1' => array(
                    'name'          => 'Add New Customer',
                    'icon'          => '<i class="fa fa-arrow-right"></i>',
                    'link'          => 'customers/customer_info',
                    'segment'       => 3,
                    'segment_text'  => 'customer_info',
                ),
    ),
    'segment'       => 2,
    'segment_text'  => 'user'
);