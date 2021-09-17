<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\General\PostsResource;
use App\Http\Resources\General\PostResource;
use App\Models\Post;

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
}
