@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add New Post</span>
                </a>
            </div>
        </div>
        <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Comments</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ Str::limit($post->title, 25, ' ...') }}</td>
                        <td>{{ $post->comment_able == 1 ? $post->comments->count() : 'Disallow' }}</td>
                        <td>{{ $post->status() }}</td>
                        <td>{{ $post->category->name }}</td>
                        <td>{{ $post->user->username }}</td>
                        <td>{{ $post->created_at->format('Y m d h:i a') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure to delete this post?')) { document.getElementById('post-delete-{{ $post->id }}').submit(); } else { return false; }"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post" id="post-delete-{{ $post->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No posts found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="7">
                            <div class="float-right">
                                {{ $posts->appends(request()->input())->links() }}
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
    </div>
@endsection
