<?php

Route::group(['namespace' => 'Judge'], function() {
    Route::get('/', 'HomeController@dashboard')->name('judge.dashboard');

    // Login
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('judge.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('judge.logout');

    // Register
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('judge.register');
    Route::post('register', 'Auth\RegisterController@register');

    // Passwords
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('judge.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('judge.password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('judge.password.reset');

});
