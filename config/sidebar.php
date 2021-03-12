<?php

    return [

        /*
        |--------------------------------------------------------------------------
        | View Storage Paths
        |--------------------------------------------------------------------------
        |
        | Most templating systems load templates from disk. Here you may specify
        | an array of paths that should be checked for your views. Of course
        | the usual Laravel view path has already been registered for you.
        |
        */

        'menu' => [
            [
                'icon'  => 'fa fa-th-large',
                'title' => 'dashboard',
                'url'   => '/dashboard',
            ],
            [
                'icon'     => 'fa fa-user',
                'title' => 'clients',
                'url'   => '/clients',
            ],
            [
                'icon'     => 'fa fa-book',
                'title' => 'pages',
                'url'   => '/pages',
            ],
            [
                'icon'     => 'fa fa-ad',
                'title' => 'banners',
                'url'   => '/campaigns',
            ],
            [
                'icon'     => 'fa fa-users',
                'title'    => 'users',
                'url'      => '',
                'caret'    => true,
                'sub_menu' => [
                    [
                        'title' => 'user_managment',
                        'url'   => '/users',
                    ],
                    [
                        'title' => 'roles',
                        'url'   => '/roles',
                    ],
                    [
                        'title' => 'permissions',
                        'url'   => '/permissions',
                    ],
                ],
            ],
        ],
    ];
