<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $posts = auth()->user()->posts()->with(['media', 'category', 'user'])
            ->withCount('comments')->orderBy('id', 'desc')->paginate(10);

        return view('frontend.users.dashboard', compact('posts'));
    }

    public function create_post()
    {
        $categories = Category::whereStatus(1)->pluck('name', 'id');

        return view('frontend.users.create_post', compact('categories'));
    }

    public function store_post(Request $request)
    {
        //
    }
}
