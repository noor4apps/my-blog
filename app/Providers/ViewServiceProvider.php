<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Permission;
use App\Models\Tag;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

                if(!Cache::has('recent_comments')) {
                    $recent_comments = Comment::whereStatus(1)->orderBy('id', 'desc')->limit(5)->get();

                    Cache::remember('recent_comments', 3600, function () use ($recent_comments) {
                        return $recent_comments;
                    });
                }
                $recent_comments = Cache::get('recent_comments');

                if(!Cache::has('global_categories')) {
                    $global_categories = Category::whereStatus(1)->orderBy('id', 'desc')->get();

                    Cache::remember('global_categories', 3600, function () use ($global_categories) {
                        return $global_categories;
                    });
                }
                $global_categories = Cache::get('global_categories');

                if(!Cache::has('global_tags')) {
                    $global_tags = Tag::withCount(['posts'])->get();

                    Cache::remember('global_tags', 3600, function () use ($global_tags) {
                        return $global_tags;
                    });
                }
                $global_tags = Cache::get('global_tags');

                if(!Cache::has('global_archives')) {
                    $global_archives = Post::whereStatus(1)->orderBy('created_at', 'desc')
                        ->select(DB::raw("Year(created_at) as year"), DB::raw("Month(created_at) as month"))
                        ->Pluck('year', 'month')->toArray();

                    Cache::remember('global_archives', 3600, function () use ($global_archives) {
                        return $global_archives;
                    });
                }
                $global_archives = Cache::get('global_archives');

                $view->with([
                    'recent_posts' => $recent_posts,
                    'recent_comments' => $recent_comments,
                    'global_categories' => $global_categories,
                    'global_tags' => $global_tags,
                    'global_archives' => $global_archives,
                ]);
            });

        }

        // Admin Aide Menu
        if (request()->is('admin/*')) {

            view()->composer('*', function ($view) {

                if (!Cache::has('admin_side_menu')) {
                    Cache::forever('admin_side_menu', Permission::tree());
                }
                $admin_side_menu = Cache::get('admin_side_menu');

                $view->with([
                    'admin_side_menu' => $admin_side_menu,
                ]);

            });

        }
    }
}
