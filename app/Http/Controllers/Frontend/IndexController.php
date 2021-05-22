<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'media', 'user'])
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            })
            ->wherePostType('post')->whereStatus(1)->orderBy('id', 'desc')->paginate(5);

        return view('frontend.index', compact('posts'));
    }

    public function post_show($slug)
    {
        $post = Post::with(['category', 'media', 'user',
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

        $post = $post->wherePostType('post')->whereStatus(1)->first();

        if($post) {
            return view('frontend.post', compact('post'));
        } else {
            return redirect()->route('frontend.index');
        }
    }

}
