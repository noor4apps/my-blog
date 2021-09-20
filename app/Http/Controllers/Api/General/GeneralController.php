<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\General\PostsResource;
use App\Http\Resources\General\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function get_posts()
    {
        $posts = Post::whereHas('category', function ($query) {
            $query->whereStatus(1);
        })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            })
            ->post()->active()
            ->orderBy('id', 'desc')->paginate(5);

        if ($posts) {
            return PostsResource::collection($posts);
        } else {
            return response()->json(['error' => true, 'message' => 'No Posts Found'], 201);
        }

    }

    public function show_post($slug)
    {
        $post = Post::with(['category', 'media', 'user', 'tags',
            'approved_comments' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);

        $post = $post->whereHas('category', function ($query) {
            $query->whereStatus(1);
        })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            });

        $post = $post->whereSlug($slug);

        $post = $post->active()->post()->first();

        if($post) {
            return new PostResource($post);
        } else {
            return response()->json(['error' => true, 'message' => 'No Post Found'], 201);
        }
    }

    public function search(Request $request)
    {

        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;

        $posts = Post::with(['media', 'user', 'tags'])
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            });

        if ($keyword != null) {
            $posts = $posts->search($keyword, null, true);
        }

        $posts = $posts->post()->active()->orderBy('id', 'desc')->get();

        if ($posts->count() > 0) {
            return PostsResource::collection($posts);
        } else {
            return response()->json(['error' => true, 'message'=> 'No posts found'], 201);
        }
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->whereStatus(1)->first();

        if ($category) {
            $posts = Post::with(['media', 'user', 'tags'])
                ->whereCategoryId($category->id)
                ->post()
                ->active()
                ->orderBy('id', 'desc')
                ->get();

            if ($posts->count() > 0) {
                return PostsResource::collection($posts);
            } else {
                return response()->json(['error' => true, 'message'=> 'No posts found'], 201);
            }
        }

        return response()->json(['error' => true, 'message'=> 'Something was wrong'], 201);
    }

    public function tag($slug)
    {
        $tag = Tag::whereSlug($slug)->first()->id;

        if ($tag) {
            $posts = Post::with(['media', 'user', 'tags'])
                ->whereHas('tags', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                })
                ->post()
                ->active()
                ->orderBy('id', 'desc')
                ->get();

            if ($posts->count() > 0) {
                return PostsResource::collection($posts);
            } else {
                return response()->json(['error' => true, 'message'=> 'No posts found'], 201);
            }
        }

        return response()->json(['error' => true, 'message'=> 'Something was wrong'], 201);
    }

    public function archive($date)
    {
        $exploded_date = explode('-', $date);
        $month = $exploded_date[0];
        $year = $exploded_date[1];

        $posts = Post::with(['media', 'user', 'tags'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->post()
            ->active()
            ->orderBy('id', 'desc')
            ->get();

        if ($posts->count() > 0) {
            return PostsResource::collection($posts);
        } else {
            return response()->json(['error' => true, 'message'=> 'Something was wrong'], 201);
        }

    }

    public function author($username)
    {
        $user = User::whereUsername($username)->whereStatus(1)->first();

        if ($user) {
            $posts = Post::with(['media', 'user', 'tags'])
                ->whereUserId($user->id)
                ->post()
                ->active()
                ->orderBy('id', 'desc')
                ->get();

            if ($posts->count() > 0) {
                return PostsResource::collection($posts);
            } else {
                return response()->json(['error' => true, 'message'=> 'No posts found'], 201);
            }
        }

        return response()->json(['error' => true, 'message'=> 'Something was wrong'], 201);
    }

}
