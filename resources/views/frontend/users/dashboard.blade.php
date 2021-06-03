@extends('layouts.app')

@section('content')
<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Comments</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td><a href="{{ route('users.comments',['post' => $post->id]) }}">{{ $post->comments_count }}</a></td>
                                <td>{{ $post->status }}</td>
                                <td>
                                    <a href="{{ route('users.post.edit', $post->id) }}" class="btn btn-sm text-white btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-sm text-white btn-danger" onclick="if(confirm('Are you sure to delete this post?')) { document.getElementById('post-delete-{{ $post->id }}').submit(); } else { return false; }"><i class="fa fa-trash"></i></a>
                                    <form action="{{ route('users.post.destroy', $post->id) }}" method="post" id="post-delete-{{ $post->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No Posts found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">{{ $posts->links() }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('partial.frontend.users.sidebar')
            </div>
        </div>
    </div>
</div>
<!-- End Blog Area -->
@endsection
