@extends('layouts.app')

@section('content')
<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <h2>dashboard</h2>
            </div>
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('partial.frontend.users.sidebar')
            </div>
        </div>
    </div>
</div>
<!-- End Blog Area -->
@endsection
