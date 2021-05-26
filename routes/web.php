<?php

use Illuminate\Support\Facades\Route;



Route::get('/',                             ['as' => 'frontend.index',           'uses' => 'Frontend\IndexController@index']);


// Frontend Authentication Routes... source (\\my-blog\vendor\laravel\ui\src\AuthRouteMethods.php)

// Login Routes...
Route::get('/login',                        ['as' => 'frontend.show_login_form',          'uses' => 'Frontend\Auth\LoginController@showLoginForm']);
Route::post('login',                        ['as' => 'frontend.login',                    'uses' => 'Frontend\Auth\LoginController@login']);
// Logout Routes...
Route::post('logout',                       ['as' => 'frontend.logout',                   'uses' => 'Frontend\Auth\LoginController@logout']);
// Registration Routes...
Route::get('register',                      ['as' => 'frontend.show_register_form',       'uses' => 'Frontend\Auth\RegisterController@showRegistrationForm']);
Route::post('register',                     ['as' => 'frontend.register',                 'uses' => 'Frontend\Auth\RegisterController@register']);
// Password Reset Routes...
Route::get('password/reset',                ['as' => 'frontend.password.request',         'uses' => 'Frontend\Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email',               ['as' => 'frontend.password.email',           'uses' => 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}',        ['as' => 'frontend.password.reset',           'uses' => 'Frontend\Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset',               ['as' => 'frontend.password.update',          'uses' => 'Frontend\Auth\ResetPasswordController@reset']);
// Password Confirmation Routes...
Route::get('password/confirm',              ['as' => 'frontend.password.confirm',         'uses' => 'Frontend\Auth\ConfirmPasswordController@showConfirmForm']);
Route::post('password/confirm',             ['as' => 'frontend.password',                 'uses' => 'Frontend\Auth\ConfirmPasswordController@confirm']);
// Email Verification Routes...
Route::get('email/verify',                  ['as' => 'verification.notice',               'uses' => 'Frontend\Auth\VerificationController@show']);
Route::get('/email/verify/{id}/{hash}',     ['as' => 'verification.verify',               'uses' => 'Frontend\Auth\VerificationController@verify']);
Route::post('email/resend',                 ['as' => 'verification.resend',               'uses' => 'Frontend\Auth\VerificationController@resend']);

Route::group(['prefix' => 'admin'], function () {
    // Backend Authentication Routes...
    Route::get('/login',                    ['as' => 'admin.show_login_form',     'uses' => 'Backend\Auth\LoginController@showLoginForm']);
    Route::post('login',                    ['as' => 'admin.login',               'uses' => 'Backend\Auth\LoginController@login']);
    Route::post('logout',                   ['as' => 'admin.logout',              'uses' => 'Backend\Auth\LoginController@logout']);
    Route::get('password/reset',            ['as' => 'admin.password.request',    'uses' => 'Backend\Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email',           ['as' => 'admin.password.email',      'uses' => 'Backend\Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}',    ['as' => 'admin.password.reset',      'uses' => 'Backend\Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset',           ['as' => 'admin.password.update',     'uses' => 'Backend\Auth\ResetPasswordController@reset']);
});

Route::get('/contact-us',                   ['as' => 'frontend.contact',         'uses' => 'Frontend\IndexController@contact']);
Route::post('/contact-us',                  ['as' => 'frontend.do_contact',      'uses' => 'Frontend\IndexController@do_contact']);

Route::get('/category/{category_slug}',     ['as' =>'frontend.category.posts',   'uses' => 'Frontend\IndexController@category']);
Route::get('/archive/{date}',               ['as' =>'frontend.archive.posts',    'uses' => 'Frontend\IndexController@archive']);
Route::get('/authour/{username}',           ['as' =>'frontend.authour.posts',    'uses' => 'Frontend\IndexController@authour']);

Route::get('/search',                       ['as' => 'frontend.search',          'uses' => 'Frontend\IndexController@search']);

Route::get('/{post}',                       ['as' => 'posts.show',               'uses' => 'Frontend\IndexController@post_show']);
Route::post('/{post}',                      ['as' => 'posts.add_comment',        'uses' => 'Frontend\IndexController@store_comment']);

