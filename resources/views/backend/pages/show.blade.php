@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Page ({{ $page->title }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Pages</span>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td colspan="4">{{ $page->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td colspan="4">{!! $page->description !!}</td>
                    </tr>
                    <tr>
                        <th>Comments</th>
                        <td>{{ $page->comment_able == 1 ? $page->comments->count() : 'Disallow' }}</td>
                        <th>Status</th>
                        <td>{{ $page->status() }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $page->category->name }}</td>
                        <th>username</th>
                        <td>{{ $page->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Created date</th>
                        <td>{{ $page->created_at->format('Y m d h:i a') }}</td>
                        <th></th>
                        <td></td>
                    </tr>
                        <tr>
                        <td colspan="4">
                            <div class="row">
                            @if($page->media->count() > 0)
                                @foreach($page->media as $media)
                                    <div class="col-2">
                                        <img src="{{ asset('assets/pages/' . $media->file_name) }}" class="img-fluid">
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

@endsection
