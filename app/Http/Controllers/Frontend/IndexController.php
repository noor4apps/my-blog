<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;
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

    public function search(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;

        $posts = Post::with(['category', 'media', 'user'])
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            });

        if($keyword != null) {
            $posts = $posts->search($keyword, null, true);
        }

        $posts = $posts->wherePostType('post')->whereStatus(1)->orderBy('id', 'desc')->paginate(5);

        return view('frontend.index', compact('posts'));
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)-orWhere('id', $slug)->whereStatus(1)->firist()->id;

        if($category) {
            $posts = Post::with(['media', 'user', 'category'])
                ->withCount('approved_comment')
                ->whereCategoryId($category)
                ->whereStatus(1)
                ->orderBy('id', 'desc')->paginate(5);

            return view('frontend.index', compact('posts'));
        }

        return redirect()->route('frontend.index');
    }

    public function archive($date)
    {
        $exploded_date = explode('-', $date);
        $month = $exploded_date[0];
        $year = $exploded_date[1];

        $posts = Post::with(['media', 'user', 'category'])
            ->withCount('approved_comment')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereStatus(1)
            ->orderBy('id', 'desc')->paginate(5);

        return view('frontend.index', compact('posts'));

    }

    public function authour($username)
    {
        $user = User::whereUsername($username)->whereStatus(1)->firist()->id;

        if($user) {
            $posts = Post::with(['media', 'user', 'category'])
                ->withCount('approved_comment')
                ->whereUserId($user)
                ->whereStatus(1)
                ->orderBy('id', 'desc')->paginate(5);

            return view('frontend.index', compact('posts'));
        }

        return redirect()->route('frontend.index');
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

        $post = $post->whereStatus(1)->first();

        if($post) {

            $blade = $post->post_type == 'post' ? 'post' : 'page';

            return view('frontend.' . $blade, compact('post'));
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
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'nullable|numeric',
            'title' => 'required|string|min:5',
            'message' => 'required|string|min:10',
        ]);
        if($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->mobile;
        $data['title'] = $request->title;
        $data['message'] = $request->message;

        Contact::create($data);

        return redirect()->back()->with([
            'message' => 'Message send successfully.',
            'alert-type' => 'success'
        ]);

    }

}
