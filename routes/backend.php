<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Backend Routes
    |--------------------------------------------------------------------------
    */

    Route::as('backend.')->prefix(config('app.backend'))->middleware(['setLocale'])->group(function () {

        Route::get('/', 'Backend\AuthController@showLoginForm')->name('home');

        // Authentication routes...
        Route::post('login', 'Backend\AuthController@login')->name('login');
        Route::get('login', 'Backend\AuthController@showLoginForm');

        Route::middleware(['auth:admin'])->group(function () {
            Route::get('dashboard', 'Backend\DashboardController@index')->name('dashboard');
            Route::get('clearCache', 'Backend\DashboardController@clearCache')->name('clearCache');
            Route::any('logout', 'Backend\AuthController@logout')->name('logout');

            //switch language
            Route::get('locale/{locale}', 'Backend\DashboardController@setLocale')->name('setLanguage');

            // admin users
            Route::put('/users/restore/{user}', 'Backend\Users\UsersController@restore')->name('users.restore');
            Route::resource('users', 'Backend\Users\UsersController')->parameter('', 'user')->except('show');
            // admin clients
            Route::put('/clients/restore/{client}', 'Backend\Users\ClientsController@restore')->name('clients.restore');
            Route::resource('clients', 'Backend\Users\ClientsController')->except('show');
            // admin roles
            Route::resource('roles', 'Backend\Users\RolesController')->parameter('', 'role')->except('show');
            // admin permissions
            Route::resource('permissions', 'Backend\Users\PermissionsController')->except('show');
            // admin pages
            Route::resource('pages', 'Backend\PagesController')->except('show');
            // admin templates
            Route::resource('templates', 'Backend\PageTemplateController');
            // admin logs
            Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
        });

    });
