@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/vendors/editor/summernote-bs4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/vendors/bootstrap-fileinput/css/fileinput.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/vendors/select2/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="col-lg-9 col-12">
        <h3>Update Post ({{ $post->title }})</h3>
        {{ Form::model($post, ['route' => ['users.post.update', $post->id], 'method' => 'put', 'files' => true]) }}
        <div class="form-group">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', old('title', $post->title), ['class' => 'form-control']) }}
            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            {{ Form::label('description', 'Description') }}
            {{ Form::textarea('description', old('description', $post->description), ['class' => 'form-control summernote']) }}
            @error('description')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            {{ Form::label('tags', 'Tags') }}
            <button type="button" class="btn btn-primary btn-xs" id="select_btn_tag">Select All</button>
            <button type="button" class="btn btn-primary btn-xs" id="deselect_btn_tag">Deselect All</button>
            {{ Form::select('tags[]', $tags->toArray(), old('tags', $post->tags), ['class' => 'form-control selects', 'multiple' => 'multiple', 'id' => 'select_all_tags']) }}
            @error('tags')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="row">
            <div class="col-4">
                {{ Form::label('category_id', 'Category') }}
                {{ Form::select('category_id', ['' => '---'] + $categories->toArray(), old('category_id', $post->category_id), ['class' => 'form-control']) }}
                @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-4">
                {{ Form::label('comment_able', 'Comment able') }}
                {{ Form::select('comment_able', ['1' => 'Yes', '2' => 'No'], old('comment_able', $post->comment_able), ['class' => 'form-control']) }}
                @error('comment_able')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-4">
                {{ Form::label('status', 'Status') }}
                {{ Form::select('status', ['1' => 'Active', '0' => 'Inactive'], old('status', $post->status), ['class' => 'form-control']) }}
                @error('status')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row py-4">
            <div class="col-12">
                <div class="file-loading">
                    {{ Form::file('images[]', ['id' => 'post-images', 'multiple' => 'multiple']) }}
                </div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        </div>
        {{ Form::close() }}
    </div>
    <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
        @include('partial.frontend.users.sidebar')
    </div>

@endsection

@section('script')
    <script src="{{ asset('frontend/vendors/editor/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('frontend/vendors/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('frontend/vendors/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('frontend/vendors/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>
    <script src="{{ asset('frontend/vendors/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('frontend/vendors/bootstrap-fileinput/themes/fa/theme.js') }}"></script>

    <script src="{{ asset('frontend/vendors/select2/js/select2.full.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $("#post-images").fileinput({
                theme: "fa",
                maxFileCount: {{ 5 - $post->media->count() }},
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if($post->media->count() > 0)
                        @foreach($post->media as $media)
                            "{{ asset('assets/posts/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($post->media->count() > 0)
                        @foreach($post->media as $media)
                            {caption: "{{ $media->file_name }}", size: {{ $media->file_size }}, width: "120px", url: "{{ route('users.post.media.destroy', [$media->id, '_token' => csrf_token()]) }}", key: "{{ $media->id }}"},
                        @endforeach
                    @endif
                ]
            });
        });

        $('.selects').select2({
            tags:true,
            minimumResultsForSearch: Infinity
        });
        $('#select_btn_tag').click(function () {
            $('#select_all_tags > option').prop("selected", "selected");
            $('#select_all_tags').trigger('change');
        });
        $('#deselect_btn_tag').click(function () {
            $('#select_all_tags > option').prop("selected", '');
            $('#select_all_tags').trigger('change');
        });
    </script>
@endsection
