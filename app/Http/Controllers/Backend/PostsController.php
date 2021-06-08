<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;

class PostsController extends Controller
{
    public function __construct()
    {
        if (\auth()->check()){
            $this->middleware('auth');
        } else {
            return view('backend.auth.login');
        }
    }

    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_posts,show_posts')) {
            return redirect('admin/index');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $categoryId = (isset(\request()->category_id) && \request()->category_id != '') ? \request()->category_id : null;
        $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $posts = Post::with(['user', 'category', 'comments'])->wherePostType('post');

        if ($keyword != null) {
            $posts = $posts->search($keyword);
        }
        if ($categoryId != null) {
            $posts = $posts->whereCategoryId($categoryId);
        }
        if ($status != null) {
            $posts = $posts->whereStatus($status);
        }
        $posts = $posts->orderBy($sort_by, $order_by);
        $posts = $posts->paginate($limit_by);

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('backend.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_posts')) {
            return redirect('admin/index');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('backend.posts.create', compact('categories'));
    }

    public function store(Request $request)

    {
        if (!\auth()->user()->ability('admin', 'create_posts')) {
            return redirect('admin/index');
        }

        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:30',
            'status' => 'required',
            'comment_able' => 'required',
            'category_id' => 'required',
            'images.*' => 'nullable|mimes:jpg,jpeg,png,gif|max:20480'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $data['title' ] = $request->title;
        $data['description'] = Purify::clean($request->description);
        $data['status'] = $request->status;
        $data['comment_able'] = $request->comment_able;
        $data['category_id'] = $request->category_id;

        $post = auth()->user()->posts()->create($data);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = public_path('assets/posts/' . $filename);
                Image::make($file->getRealPath())->resize(880, 460, function ($constraint){
                    $constraint->aspectRatio();
                })->save($path, 100);

                $post->media()->create([
                    'file_name' => $filename,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                ]);
                $i++;
            }
        }

        if($request->status == 1) {
            Cache::forget('recent_posts');
        }

        return redirect()->route('admin.posts.index')->with([
            'message' => 'Post Created successfully',
            'alert-type' => 'success',
        ]);

    }

    public function show($id)
    {
        if (!\auth()->user()->ability('admin', 'display_posts')) {
            return redirect('admin/index');
        }

        $post = Post::with(['media', 'category', 'user', 'comments'])->whereId($id)->post()->first();

        return view('backend.posts.show', compact('post'));
    }

    public function edit($id)
    {
        if (!\auth()->user()->ability('admin', 'update_posts')) {
            return redirect('admin/index');
        }

        $post = Post::with(['media'])->whereId($id)->post()->first();

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('backend.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!\auth()->user()->ability('admin', 'update_posts')) {
            return redirect('admin/index');
        }

        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:30',
            'status' => 'required',
            'comment_able' => 'required',
            'category_id' => 'required',
            'images.*' => 'nullable|mimes:jpg,jpeg,png,gif|max:20480'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $post = Post::whereId($id)->post()->first();

        if ($post) {
            $data['title' ] = $request->title;
            $data['description'] = Purify::clean($request->description);
            $data['status'] = $request->status;
            $data['comment_able'] = $request->comment_able;
            $data['category_id'] = $request->category_id;

            $post->update($data);

            if ($request->images && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {
                    $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = public_path('assets/posts/' . $filename);
                    Image::make($file->getRealPath())->resize(880, 460, function ($constraint){
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $post->media()->create([
                        'file_name' => $filename,
                        'file_size' => $file_size,
                        'file_type' => $file_type,
                    ]);
                    $i++;
                }
            }

            if($request->status == 1) {
                Cache::forget('recent_posts');
            }

            return redirect()->route('admin.posts.index')->with([
                'message' => 'Post updated successfully.',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong.',
            'alert-type' => 'danger',
        ]);

    }

    public function destroy($id)
    {
        if (!\auth()->user()->ability('admin', 'delete_posts')) {
            return redirect('admin/index');
        }

        $post = Post::with(['media'])->whereId($id)->post()->first();

        if ($post) {
            // delete files
            if($post->media->count() > 0) {
                foreach ($post->media as $media) {
                    if(File::exists('assets/posts/' . $media->file_name)) {
                        unlink('assets/posts/' . $media->file_name);
                    }
                }
            }
            // When the post is deleted, post_media(photos) and comments will be deleted due to a table DB their cascade On Delete
            $post->delete();

            Cache::forget('recent_posts');

            return redirect()->route('admin.posts.index')->with([
                'message' => 'Post deleted successfully.',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong.',
            'alert-type' => 'danger',
        ]);

    }

    public function removeImage($media_id)
    {
        if (!\auth()->user()->ability('admin', 'delete_posts')) {
            return redirect('admin/index');
        }

        $media = PostMedia::whereId($media_id)->first();
        if($media) {
            if(File::exists('assets/posts/' . $media->file_name)) {
                unlink('assets/posts/' . $media->file_name);
            }
            $media->delete();
            return true;
        }
        return false;
    }
}
