<div class="wn__sidebar">
    <!-- Start Single Widget -->
    <aside class="widget search_widget">
        <h3 class="widget-title">Search</h3>
        {{ Form::open(['route' => 'frontend.search', 'method' => 'get']) }}
            <div class="form-input">
                {{ Form::text('keyword', old('keyword', request()->keyword), ['placeholder' => 'Search...']) }}
                {{ Form::button('<i class="fa fa-search"></i>', ['type', 'submit']) }}
            </div>
        {{ Form::close() }}
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget recent_widget">
        <h3 class="widget-title">Recent Posts</h3>
        <div class="recent-posts">
            <ul>
                @foreach($recent_posts as $recent_post)
                    <li>
                        <div class="post-wrapper d-flex">
                            <div class="thumb">
                                <a href="{{ route('posts.show', $recent_post->slug) }}">
                                    @if($recent_post->media->count() > 0)
                                        <img src="{{ asset('assets/posts/' . $recent_post->media->first()->file_name) }}" alt="{{ $recent_post->title }}">
                                    @else
                                        <img src="{{ asset('assets/posts/default_small.jpg') }}" alt="blog images">
                                    @endif
                                </a>
                            </div>
                            <div class="content">
                                <h4><a href="{{ route('posts.show', $recent_post->slug) }}">{{ Str::limit($recent_post->title, 22, '... ') }}</a></h4>
                                <p>{{ $recent_post->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget comment_widget">
        <h3 class="widget-title">Comments</h3>
        <ul>
            <li>
                <div class="post-wrapper">
                    <div class="thumb">
                        <img src="{{ asset('frontend/images/blog/comment/1.jpeg') }}" alt="Comment images">
                    </div>
                    <div class="content">
                        <p>demo says:</p>
                        <a href="#">Quisque semper nunc vitae...</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="post-wrapper">
                    <div class="thumb">
                        <img src="{{ asset('frontend/images/blog/comment/1.jpeg') }}" alt="Comment images">
                    </div>
                    <div class="content">
                        <p>Admin says:</p>
                        <a href="#">Curabitur aliquet pulvinar...</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="post-wrapper">
                    <div class="thumb">
                        <img src="{{ asset('frontend/images/blog/comment/1.jpeg') }}" alt="Comment images">
                    </div>
                    <div class="content">
                        <p>Irin says:</p>
                        <a href="#">Quisque semper nunc vitae...</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="post-wrapper">
                    <div class="thumb">
                        <img src="{{ asset('frontend/images/blog/comment/1.jpeg') }}" alt="Comment images">
                    </div>
                    <div class="content">
                        <p>Boighor says:</p>
                        <a href="#">Quisque semper nunc vitae...</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="post-wrapper">
                    <div class="thumb">
                        <img src="{{ asset('frontend/images/blog/comment/1.jpeg') }}" alt="Comment images">
                    </div>
                    <div class="content">
                        <p>demo says:</p>
                        <a href="#">Quisque semper nunc vitae...</a>
                    </div>
                </div>
            </li>
        </ul>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget category_widget">
        <h3 class="widget-title">Categories</h3>
        <ul>
            <li><a href="#">Fashion</a></li>
            <li><a href="#">Creative</a></li>
            <li><a href="#">Electronics</a></li>
            <li><a href="#">Kids</a></li>
            <li><a href="#">Flower</a></li>
            <li><a href="#">Books</a></li>
            <li><a href="#">Jewelle</a></li>
        </ul>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget archives_widget">
        <h3 class="widget-title">Archives</h3>
        <ul>
            <li><a href="#">March 2015</a></li>
            <li><a href="#">December 2014</a></li>
            <li><a href="#">November 2014</a></li>
            <li><a href="#">September 2014</a></li>
            <li><a href="#">August 2014</a></li>
        </ul>
    </aside>
    <!-- End Single Widget -->
</div>
