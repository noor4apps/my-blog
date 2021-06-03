<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="userId" content="{{ auth()->check() ? auth()->id() : '' }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('frontend/images/favicon.ico') }}" rel="shortcut icon">
    <link href="{{ asset('frontend/images/icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Stylesheets -->
    <link href="{{ asset('frontend/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <!-- Modernizer js -->
    <script src="{{ asset('frontend/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    @yield('style')
</head>
<body>
    <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <div id="app">
        <!-- Main wrapper -->
            <div class="wrapper" id="wrapper">

                @include('partial.frontend.header')

            <main>
                <div class="page-blog-details section-padding--lg bg--white">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                @include('partial.flash')
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>

                @include('partial.frontend.footer')

            </div>
        <!-- //Main wrapper -->
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- JS Files -->
    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend/js/active.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    @yield('script')
</body>
</html>
