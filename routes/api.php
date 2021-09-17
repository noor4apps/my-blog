<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Api\ApiController;
use App\Http\Controllers\Api\General\GeneralController;

Route::get('/chart/comments_chart',     [ApiController::class, 'comments_chart']);
Route::get('/chart/users_chart',        [ApiController::class, 'users_chart']);

/**
 * API
 */

Route::get('get-posts',                 [GeneralController::class, 'get_posts']);
Route::get('post/{slug}',               [GeneralController::class, 'show_post']);

Route::post('register',                 [\App\Http\Controllers\Frontend\Auth\RegisterController::class, 'register']);
Route::post('login',                    [\App\Http\Controllers\Frontend\Auth\LoginController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
});
