<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\Category;
use App\Http\Resources\Users\UsersCategoriesResource;
use App\Http\Resources\Users\UsersPostsResource;
use App\Http\Resources\Users\UsersTagsResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['errors' => false, 'message' => 'Successfully logged out']);
    }

    public function user_information()
    {
        $user = \auth()->user();
        return response()->json(['errors' => false, 'message' => $user], 200);
    }

    public function my_posts()
    {
        $user = Auth::user();
        $posts = $user->posts;
        return UsersPostsResource::collection($posts);
    }

    public function create_post()
    {
        $tags = Tag::all();
        $categories = Category::whereStatus(1)->get();

        return ['tags' => UsersTagsResource::collection($tags), 'categories' => UsersCategoriesResource::collection($categories)];
    }

    public function store_post(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:30',
            'status' => 'required',
            'comment_able' => 'required',
            'category_id' => 'required',
            'tags.*' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => true, 'message' => $validation->errors()], 200);
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

        if($request->tags) {
            $tags = [];
            foreach ($request->tags as $tag)
            {
                $tag = Tag::firstOrCreate([
                    'id' => $tag
                ], [
                    'name' => $tag
                ]);
                $tags[] = $tag->id;
            }
            $post->tags()->sync($tags);

        }

        if($request->status == 1) {
            Cache::forget('recent_posts');
        }

        Cache::forget('global_tags');

        return response()->json(['errors' => false, 'message' => 'Post created successfully'], 200);

    }

}
