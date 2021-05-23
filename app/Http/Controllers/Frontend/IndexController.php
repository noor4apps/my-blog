<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function page_show($slug)
    {
        $page = Post::with(['media', 'user']);;

        $page = $page->whereSlug($slug);

        $page = $page->wherePostType('page')->whereStatus(1)->first();

        if($page) {
            return view('frontend.page', compact('page'));
        } else {
            return redirect()->route('frontend.index');
        }
    }

    public function store_comment(Request $request, $slug)
    {
        $validation = Validator::make($request->all(), [
           'name' => 'required|string',
           'email' => 'required|email',
           'url' => 'nullable|url',
           'comment' => 'required|string|min:10'
        ]);
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $post = Post::whereSlug($slug)->wherePostType('post')->whereStatus(1)->first();
        if($post) {

            $userId = auth()->check() ? auth()->id() : null;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['url'] = $request->url;
            $data['ip_address'] = $request->ip();
            $data['comment'] = $request->comment;
            $data['post_id'] = $post->id ;
            $data['user_id'] = $userId;
//            Comment::create($data);
            $post->comments()->create($data);

            return redirect()->back()->with([
                'message' => 'Comment added successfully.',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong.',
            'alert-type' => 'danger'
        ]);
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function do_contact(Request $request)
    {
        //
    }

}
