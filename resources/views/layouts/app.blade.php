<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Bootstrap CSS -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Bootstrap Icon CSS -->
        <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet">
        <!-- Swiper slider CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
        <!-- Slick slider CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
        <!-- Nice Select CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">
        <!-- BoxIcon CSS -->
        <link href="{{ asset('assets/css/boxicons.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        
        <!-- Title -->
        <title>@yield('title', 'Latocross - Artwork & Fashion .')</title>
        <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/gif" sizes="20x20">
        <script src="https://cdn.tailwindcss.com"></script>
        <style type="text/tailwindcss">
            @layer utilities {
                .backdrop-blur-md {
                    backdrop-filter: blur(12px);
                    -webkit-backdrop-filter: blur(12px);
                }
            }
        </style>
        @livewireStyles
    </head>
    <body>
        <!-- scroll top start -->
        <div class="circle-container">
            <svg class="circle-progress svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919; stroke-dashoffset: 256.939;"></path>
            </svg>
        </div>
        <!-- scroll top end -->

        <!-- Header Component -->
        @livewire('header')

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
 
        <!-- Footer Component -->
        @livewire('footer')
        

        <!-- Scripts -->
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.marquee.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        
        @livewireScripts
    </body>
</html>