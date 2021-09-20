<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Api\ApiController;
use App\Http\Controllers\Api\General\GeneralController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Users\UsersController;

Route::get('/chart/comments_chart',     [ApiController::class, 'comments_chart']);
Route::get('/chart/users_chart',        [ApiController::class, 'users_chart']);

/**
 * API
 */

Route::get('get-posts',                 [GeneralController::class, 'get_posts']);
Route::get('post/{slug}',               [GeneralController::class, 'show_post']);

Route::get('search',                    [GeneralController::class, 'search']);
Route::get('category/{category_slug}',  [GeneralController::class, 'category']);
Route::get('tag/{tag_slug}',            [GeneralController::class, 'tag']);
Route::get('archive/{date}',            [GeneralController::class, 'archive']);
Route::get('author/{username}',         [GeneralController::class, 'author']);

Route::post('register',                 [AuthController::class, 'register']);
Route::post('login',                    [AuthController::class, 'login']);
Route::post('refresh-token',            [AuthController::class, 'refresh_token']);

Route::group(['middleware' => ['auth:api']], function() {

    Route::post('logout',               [UsersController::class, 'logout']);

    Route::get('user-information',      [UsersController::class, 'user_information']);
    Route::patch('update-user-information',[UsersController::class, 'update_user_information']);
    Route::patch('update-user-password',   [UsersController::class, 'update_user_password']);

    Route::get('my-posts',              [UsersController::class, 'my_posts']);

    Route::get('my-posts/create',       [UsersController::class, 'create_post']);
    Route::post('my-posts/create',      [UsersController::class, 'store_post']);

    Route::get('my-posts/{post}/edit',        [UsersController::class, 'edit_post']);
    Route::patch('my-posts/{post}/edit',      [UsersController::class, 'update_post']);

    Route::delete('my-posts/{post}',          [UsersController::class, 'destroy_post']);
    Route::delete('destroy-post-media/{id}',  [UsersController::class, 'destroy_post_media']);

    Route::get('all-comments',                 [UsersController::class, 'all_comments']);
    Route::get('comments/{id}/edit',           [UsersController::class, 'edit_comment']);
    Route::patch('comments/{id}/edit',         [UsersController::class, 'update_comment']);
    Route::delete('comments/{id}',             [UsersController::class, 'destroy_comment']);

});
