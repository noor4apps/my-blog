@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Post ({{ $post->title }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Post</span>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td colspan="4">{{ $post->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td colspan="4">{!! $post->description !!}</td>
                    </tr>
                    <tr>
                        <th>Comments</th>
                        <td>{{ $post->comment_able == 1 ? $post->comments->count() : 'Disallow' }}</td>
                        <th>Status</th>
                        <td>{{ $post->status() }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $post->category->name }}</td>
                        <th>username</th>
                        <td>{{ $post->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Created date</th>
                        <td>{{ $post->created_at->format('Y m d h:i a') }}</td>
                        <th></th>
                        <td></td>
                    </tr>
                        <tr>
                        <td colspan="4">
                            <div class="row">
                            @if($post->media->count() > 0)
                                @foreach($post->media as $media)
                                    <div class="col-2">
                                        <img src="{{ asset('assets/posts/' . $media->file_name) }}" class="img-fluid">
                                    </div>
                                @endforeach
                            @endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Comments</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>username</th>
                    <th width="40%">Comment</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($post->comments as $comment)
                    <tr>
                        <td><img src="{{ get_gravatar($comment->email, 50) }}" class="img-circle"></td>
                        <td>{{ $comment->name}}</td>
                        <td>{{ $comment->comment}}</td>
                        <td>{{ $comment->status() }}</td>
                        <td>{{ $comment->created_at->format('Y m d h:i a') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.post_comments.edit', $comment->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure to delete this comment?')) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.post_comments.destroy', $comment->id) }}" method="post" id="comment-delete-{{ $comment->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No comments found!</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
