<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Frontend Routes
    |--------------------------------------------------------------------------
    */

    Route::group(
        [
            'prefix'     => LaravelLocalization::setLocale(),
            'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        ],
        function () {

            // Home page
            Route::get('/', 'Frontend\PageController@index')->name('home');

            Route::group(['middleware' => ['auth']], function () {
                // Logout Routes
                Route::post('logout', 'Frontend\Auth\LoginController@logout')->name('logout');
                // Profile Routes
                Route::get('/profile', 'Frontend\ProfileController@profile')->name('profile');
            });

            // Registration Routes
            Route::get('register', 'Frontend\Auth\RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'Frontend\Auth\RegisterController@register');

            // Login Routes
            Route::get('login', 'Frontend\Auth\LoginController@showLoginForm')->name('login');
            Route::post('login', 'Frontend\Auth\LoginController@login');

            // Password Reset Routes
            Route::get('password/reset', 'Frontend\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('password/email', 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            Route::get('password/reset/{token}', 'Frontend\Auth\ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('password/reset', 'Frontend\Auth\ResetPasswordController@reset')->name('password.update');

            // Password Confirmation Routes
            Route::get('password/confirm', 'Frontend\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
            Route::post('password/confirm', 'Frontend\Auth\ConfirmPasswordController@confirm');

            // Email Verification Routes
            Route::get('email/verify', 'Frontend\Auth\VerificationController@show')->name('verification.notice');
            Route::get('email/verify/{id}/{hash}', 'Frontend\Auth\VerificationController@verify')->name('verification.verify');
            Route::post('email/resend', 'Frontend\Auth\VerificationController@resend')->name('verification.resend');

            // Any page
            Route::get('/{alias}', 'Frontend\PageController@page')->name('page');


        });
