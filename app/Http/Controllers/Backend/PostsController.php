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

    public function index()
    {
        $posts = Post::with(['user', 'category', 'comments'])->post()->orderBy('id', 'desc')->paginate(10);

        return view('backend.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('backend.posts.create', compact('categories'));
    }

    public function store(Request $request)

    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $post = Post::with(['media'])->whereId($id)->post()->first();

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');

        return view('backend.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function removeImage($media_id)
    {
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
