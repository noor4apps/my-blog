<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /* public function is(...$patterns)
         * Determine if the current request URI matches a pattern.
         * @param  mixed  ...$patterns
         * @return bool
         */
        if(!request()->is('admin/*')) {
            /* public static function defaultView($view)
             * Set the default pagination view.
             * @param  string  $view
             * @return void
             */
            Paginator::defaultView('vendor.pagination.boighor');

            /* function view($view = null, $data = [], $mergeData = [])
             * Get the evaluated view contents for the given view.
             * @param  string|null  $view
             * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
             * @param  array  $mergeData
             * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
             */
            /* public function composer($views, $callback);
             * Register a view composer event.
             * @param  array|string  $views
             * @param  \Closure|string  $callback
             * @return array
             */
            view()->composer('*', function($view) {

                if(!Cache::has('recent_posts')) {
                    $recent_posts = Post::with(['category', 'media', 'user'])
                        ->whereHas('category', function ($query) {
                            $query->whereStatus(1);
                        })
                        ->whereHas('user', function ($query) {
                            $query->whereStatus(1);
                        })
                        ->wherePostType('post')->whereStatus(1)->orderBy('id', 'desc')->limit(5)->get();

                    Cache::remember('recent_posts', 3600, function () use ($recent_posts) {
                        return $recent_posts;
                    });
                }
                $recent_posts = Cache::get('recent_posts');

                $view->with([
                    'recent_posts' => $recent_posts,
                ]);
            });

        }
    }
}
