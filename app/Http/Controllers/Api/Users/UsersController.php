<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use App\Http\Resources\Users\UsersCategoriesResource;
use App\Http\Resources\Users\UsersPostCommentsResource;
use App\Http\Resources\Users\UsersPostResource;
use App\Http\Resources\Users\UsersPostsResource;
use App\Http\Resources\Users\UsersTagsResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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

    //

    public function getNotifications()
    {
        return [
            'read'      => auth()->user()->readNotifications,
            'unread'    => auth()->user()->unreadNotifications,
        ];
    }

    public function markAsRead(Request $request)
    {
        return auth()->user()->notifications->where('id', $request->id)->markAsRead();
    }

    //

    public function user_information()
    {
        $user = \auth()->user();
        return response()->json(['errors' => false, 'message' => new UserResource($user)], 200);
    }

    public function update_user_information(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|email',
            'mobile'        => 'required|numeric',
            'bio'           => 'nullable|min:10',
            'receive_email' => 'required',
            'user_image'    => 'nullable|image|max:20000,mimes:jpeg,jpg,png'
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => true, 'message' => $validator->errors()], 200);
        }

        $data['name']           = $request->name;
        $data['email']          = $request->email;
        $data['mobile']         = $request->mobile;
        $data['bio']            = $request->bio;
        $data['receive_email']  = $request->receive_email;

        if ($image = $request->file('user_image')) {
            if (auth()->user()->user_image != ''){
                if (File::exists('/assets/users/' . auth()->user()->user_image)){
                    unlink('/assets/users/' . auth()->user()->user_image);
                }
            }
            $filename = Str::slug(auth()->user()->username).'.'.$image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['user_image'] = $filename;
        }

        $update = auth()->user()->update($data);

        if ($update) {
            return response()->json(['errors' => false, 'message' => 'Information updated successfully'], 200);

        } else {
            return response()->json(['errors' => true, 'message' => 'Something was wrong'], 200);
        }
    }

    public function update_user_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'  => 'required',
            'password'          => 'required|confirmed'
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => true, 'message' => $validator->errors()], 200);
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $update = $user->update([
                'password' => bcrypt($request->password),
            ]);

            if ($update) {
                return response()->json(['errors' => false, 'message' => 'Password updated successfully'], 200);
            } else {
                return response()->json(['errors' => true, 'message' => 'Something was wrong'], 200);
            }

        } else {
            return response()->json(['errors' => true, 'message' => 'Something was wrong'], 200);
        }
    }

    //

    public function my_posts()
    {
        $user = Auth::user();
        $posts = $user->posts;
        return UsersPostsResource::collection($posts);
    }

    //

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

    public function edit_post($post)
    {
        $post = Post::whereSlug($post)->orWhere('id', $post)->whereUserId(auth()->id())->first();
        $tags = Tag::all();
        $categories = Category::whereStatus(1)->get();

        return ['post' => new UsersPostResource($post), 'tags' => UsersTagsResource::collection($tags), 'categories' => UsersCategoriesResource::collection($categories)];
    }

    public function update_post(Request $request, $post)
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
            return response()->json(['errors' => true, 'messages' => $validation->errors()], 200);
        }

        $post = Post::whereSlug($post)->orWhere('id', $post)->whereUserId(auth()->id())->first();

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

            return response()->json(['errors' => false, 'message' => 'Post updated successfully'], 200);

        }

        return response()->json(['errors' => true, 'message' => 'Something was wrong'], 200);

    }

    public function destroy_post($post)
    {
        $post = Post::whereSlug($post)->orWhere('id', $post)->whereUserId(auth()->id())->first();

        if ($post) {
            if ($post->media->count() > 0) {
                foreach ($post->media as $media) {
                    if (File::exists('assets/posts/' . $media->file_name)) {
                        unlink('assets/posts/' . $media->file_name);
                    }
                }
            }
            $post->delete();

            Cache::forget('recent_posts');

            return response()->json(['errors' => false, 'message' => 'Post deleted successfully'], 200);
        }
        return response()->json(['errors' => true, 'message' => 'Something was wrong'], 200);
    }

    public function destroy_post_media($media_id)
    {
        $media = PostMedia::whereId($media_id)->first();
        if ($media) {
            if (File::exists('assets/posts/' . $media->file_name)) {
                unlink('assets/posts/' . $media->file_name);
            }
            $media->delete();
            return response()->json(['errors' => false, 'message' => 'Media deleted successfully'], 200);
        }
        return response()->json(['errors' => true, 'message' => 'Something was wrong'], 200);
    }

    //

    public function all_comments(Request $request)
    {
        $comments = Comment::query();

        if (isset($request->post) && $request->post != '') {
            $comments = $comments->wherePostId($request->post);
        } else {
            $posts_id = auth()->user()->posts->pluck('id')->toArray();
            $comments = $comments->whereIn('post_id', $posts_id);
        }
        $comments = $comments->orderBy('id', 'desc');
        $comments = $comments->get();

        return UsersPostCommentsResource::collection($comments);
    }

    public function edit_comment($id)
    {
        $comment = Comment::whereId($id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();

        if ($comment) {
            return response()->json(['errors' => false, 'message' => new UsersPostCommentsResource($comment)], 200);
        } else {
            return response()->json(['errors' => true, 'message' => 'Something was wrong'], 200);
        }
    }

    public function update_comment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|email',
            'url'           => 'nullable|url',
            'status'        => 'required',
            'comment'       => 'required',
        ]);
        if($validator->fails()) {
            return response()->json(['errors' => true, 'message' => $validator->errors()], 200);
        }

        $comment = Comment::whereId($id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();

        if ($comment) {
            $data['name']          = $request->name;
            $data['email']         = $request->email;
            $data['url']           = $request->url != '' ? $request->url : null;
            $data['status']        = $request->status;
            $data['comment']       = Purify::clean($request->comment);

            $comment->update($data);

            if ($request->status == 1) {
                Cache::forget('recent_comments');
            }

            return response()->json(['errors' => false, 'message' => 'Comment updated successfully'], 200);

        } else {
            return response()->json(['errors' => true, 'message' => 'Something was wrong'], 200);
        }
    }

    public function destroy_comment($id)
    {
        $comment = Comment::whereId($id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();

        if ($comment) {

            $comment->delete();

            Cache::forget('recent_comments');

            return response()->json(['error' => false, 'message' => 'Comment deleted successfully.'], 200);

        } else {
            return response()->json(['error' => true, 'message' => 'Something was wrong.']);
        }
    }

}
