<?php

    if (!isset($routes)) {
        $routes = \Config\Services::routes(true);
    }

    $routes->group('backend', ['filter' => 'admin_filter', 'namespace' => 'App\Modules\CMS\Controllers\Admin'], function ($subroutes) {
        /*** Route for admin cms***/
        $subroutes->add('content_manager/cms', 'Content_manager::index');

        $subroutes->add('home/home_list', 'Home::index');
        $subroutes->add('home/info', 'Home::form');
        $subroutes->add('home/home_update', 'Home::home_update');

        $subroutes->add('about/about_list', 'About::index');
        $subroutes->add('about/info', 'About::form');
        $subroutes->add('about/about_update', 'About::about_update');

        $subroutes->add('contact/contact_list', 'Contact::index');
        $subroutes->add('contact/info', 'Contact::form');
        $subroutes->add('contact/contact_update', 'Contact::contact_update');

        $subroutes->add('terms/terms_list', 'Terms::index');
        $subroutes->add('terms/info', 'Terms::form');
        $subroutes->add('terms/terms_update', 'Terms::terms_update');

        $subroutes->add('privacy/privacy_list', 'Privacy::index');
        $subroutes->add('privacy/info', 'Privacy::form');
        $subroutes->add('privacy/privacy_update', 'Privacy::privacy_update');

        $subroutes->add('social/social_list', 'Social_link::index');
        $subroutes->add('social/info', 'Social_link::form');
        $subroutes->add('social/social_update', 'Social_link::social_update');

        $subroutes->add('faq/faq_list', 'Faq::index');
        $subroutes->add('faq/info', 'Faq::form');
        $subroutes->add('faq/add', 'Faq::addform');
        $subroutes->add('faq/faq_update', 'Faq::faq_update');
        $subroutes->add('faq/faq_save', 'Faq::faq_save');
        $subroutes->add('faq/delete', 'Faq::delete');

    });