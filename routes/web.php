<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\Auth\LoginController as FrontendLoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\ConfirmPasswordController;
use App\Http\Controllers\Frontend\Auth\VerificationController;
use App\Http\Controllers\Frontend\UsersController as FrontendUsersController;
use App\Http\Controllers\Frontend\NotificationsController as FrontendNotificationsController;
use App\Http\Controllers\Backend\Auth\LoginController as BackendLoginController;
use App\Http\Controllers\Backend\NotificationsController as BackendNotificationsController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\PostsController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PostCategorisController;
use App\Http\Controllers\Backend\PostTagsController;
use App\Http\Controllers\Backend\PostCommentsController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\SupervisorsController;
use App\Http\Controllers\Backend\UsersController as BackendUsersController;


Route::get('/',                             [IndexController::class,'index'])->name('frontend.index');
Route::get('/tree', function () {
    return \App\Models\Permission::tree();
});


// Frontend Authentication Routes... source (\\my-blog\vendor\laravel\ui\src\AuthRouteMethods.php)

// Login Routes...
Route::get('/login',                        [FrontendLoginController::class ,'showLoginForm'])->name('frontend.show_login_form');
Route::post('login',                        [FrontendLoginController::class ,'login'])->name('frontend.login');
// Logout Routes...
Route::post('logout',                       [FrontendLoginController::class ,'logout'])->name('frontend.logout');
// Registration Routes...
Route::get('register',                      [RegisterController::class, 'showRegistrationForm'])->name('frontend.show_register_form');
Route::post('register',                     [RegisterController::class, 'register'])->name('frontend.register');
// Password Reset Routes...
Route::get('password/reset',                [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email',               [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}',        [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset',               [ResetPasswordController::class, 'reset'])->name('password.update');
// Password Confirmation Routes...
Route::get('password/confirm',              [ConfirmPasswordController::class ,'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm',             [ConfirmPasswordController::class, 'confirm'])->name('password');
// Email Verification Routes...
Route::get('email/verify',                  [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}',     [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend',                 [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => 'verified'], function () {
    Route::get('/dashboard',                        [FrontendUsersController::class, 'index'])->name('frontend.dashboard');

    Route::any('user/notifications/get',            [FrontendNotificationsController::class, 'getNotifications']);
    Route::any('user/notifications/read',           [FrontendNotificationsController::class, 'markAsRead']);

    Route::get('/edit-info',                        [FrontendUsersController::class, 'edit_info'])->name('users.edit_info');
    Route::post('/edit-info',                       [FrontendUsersController::class, 'update_info'])->name('users.update_info');

    Route::post('/edit-password',                   [FrontendUsersController::class, 'update_password'])->name('users.update_password');

    Route::get('/create-post',                      [FrontendUsersController::class, 'create_post'])->name('users.post.create');
    Route::post('/create-post',                     [FrontendUsersController::class, 'store_post'])->name('users.post.store');

    Route::get('/edit-post/{post_id}',              [FrontendUsersController::class, 'edit_post'])->name('users.post.edit');
    Route::put('/edit-post/{post_id}',              [FrontendUsersController::class, 'update_post'])->name('users.post.update');

    Route::delete('/delete-post/{post_id}',         [FrontendUsersController::class, 'destroy_post'])->name('users.post.destroy');

    Route::post('/delete-post-media/{media_id}',    [FrontendUsersController::class, 'destroy_post_media'])->name('users.post.media.destroy');

    Route::get('/comments',                         [FrontendUsersController::class, 'show_comments'])->name('users.comments');
    Route::get('/edit-comment/{comment_id}',        [FrontendUsersController::class, 'edit_comment'])->name('users.comment.edit');
    Route::put('/edit-comment/{comment_id}',        [FrontendUsersController::class, 'update_comment'])->name('users.comment.update');
    Route::delete('/delete-comment/{comment_id}',   [FrontendUsersController::class, 'destroy_comment'])->name('users.comment.destroy');
});

Route::group(['prefix' => 'admin'], function () {
    // Backend Authentication Routes...
    Route::get('/login',                            [BackendLoginController::class, 'showLoginForm'])->name('admin.show_login_form');
    Route::post('login',                            [BackendLoginController::class, 'login'])->name('admin.login');
    Route::post('logout',                           [BackendLoginController::class, 'logout'])->name('admin.logout');
    Route::get('password/reset',                    [BackendForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email',                   [BackendForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}',            [BackendResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset',                   [BackendResetPasswordController::class, 'reset'])->name('password.update');

    Route::group(['middleware' => ['roles', 'role:admin|editor'], 'as' => 'admin.'], function () {

        Route::any('/notifications/get',        [BackendNotificationsController::class, 'getNotifications']);
        Route::any('/notifications/read',       [BackendNotificationsController::class, 'markAsRead']);

        Route::get('/',                         [AdminController::class, 'index'])->name('index_route');
        Route::get('/index',                    [AdminController::class, 'index'])->name('index');

        Route::post('/posts/{media_id}',        [PostsController::class, 'removeImage'])->name('posts.media.destroy');
        Route::resource('posts',                PostsController::class);

        Route::post('/pages/{media_id}',        [PagesController::class, 'removeImage'])->name('pages.media.destroy');
        Route::resource('pages',                PagesController::class);

        Route::resource('post_comments',    PostCommentsController::class);
        Route::resource('post_categories',  PostCategorisController::class);
        Route::resource('post_tags',        PostTagsController::class);

        Route::resource('contact_us',           ContactUsController::class);

        Route::post('/users/removeImage',       [BackendUsersController::class ,'removeImage'])->name('users.remove_image');
        Route::resource('users',                BackendUsersController::class);

        Route::post('/supervisors/removeImage',  [supervisorsController::class, 'removeImage'])->name('supervisors.remove_image');
        Route::resource('supervisors',          SupervisorsController::class);

        Route::resource('settings',             SettingsController::class);
    });
});

Route::get('/contact-us',                        [IndexController::class, 'contact'])->name('frontend.contact');
Route::post('/contact-us',                       [IndexController::class, 'do_contact'])->name('frontend.do_contact');

Route::get('/category/{category_slug}',          [IndexController::class, 'category'])->name('frontend.category.posts');
Route::get('/tag/{tag_slug}',                    [IndexController::class, 'tag'])->name('frontend.tag.posts');
Route::get('/archive/{date}',                    [IndexController::class, 'archive'])->name('frontend.archive.posts');
Route::get('/authour/{username}',                [IndexController::class, 'authour'])->name('frontend.authour.posts');

Route::get('/search',                            [IndexController::class, 'search'])->name('frontend.search');

Route::get('/{post}',                            [IndexController::class, 'post_show'])->name('posts.show');
Route::post('/{post}',                           [IndexController::class, 'store_comment'])->name('posts.add_comment');

