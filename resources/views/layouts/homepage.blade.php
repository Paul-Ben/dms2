<!DOCTYPE html>
<!--[if lte IE 9]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>BSGIDMS</title>
    <!--=================================
Meta tags
=================================-->
    <meta name="description" content="">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" />
    <!--=================================
Style Sheets
=================================-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animations.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customcss.css') }}">


    <script async src="{{ asset('assets/js/lib/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/app/custom.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <style>
        .navbar {
            background: white;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            height: 80px;
        }

        .navbar-brand {
            padding: 10px 20px;
            margin-bottom: 12px;
            right: 20px;
        }

        .navbar-toggle {
            border: none;
            background: transparent !important;
            margin-top: 25px;
            left: 40px;
        }

        .navbar-toggle .icon-bar {
            background: #30B34E !important;
            width: 25px;
            height: 4px;

        }

        .navbar-nav>li>a {
            margin-top: 12px;
            color: black !important;
        }

        .navbar-nav>li>a:hover {
            color: #30B34E !important;
        }

        @media (max-width: 767px) {
            .navbar-header {
                display: flex;
                justify-content: space-between;
                width: 100%;
                align-items: center;
            }

            .navbar-brand.hidden-lg {
                display: block !important;
                margin-right: 15px;
            }

            .navbar-brand.visible-lg {
                display: none !important;
            }

            .navbar-toggle {
                margin-left: auto;
                order: 2;
                align-self: center;
            }

            .navbar-collapse {
                background: #30B34E;
                position: absolute;
                width: 100%;
                top: 80px;
                z-index: 1000;
                padding: 10px 0;
            }

            .navbar-nav {
                width: 100%;
                text-align: center;
            }

            .navbar-nav>li {
                width: 100%;

            }

            .navbar-nav>li>a:hover {
                color: white !important;
            }
        }

        @media (min-width: 768px) {
            .navbar-brand.hidden-lg {
                display: none !important;
            }

            .navbar-brand.visible-lg {
                display: block !important;
            }
        }
    </style>
</head>

<body class="homes">

    <!--========================================
Body Content
===========================================-->
    {{-- <header>
        <div class="container">
            <a href="#" class="logo pull-left">
                <figure><img src="{{ asset('assets/demo-data/Logo1.png') }}" width="56" height="56" alt="/"></figure>
            </a>
            <p style="color: rgb(26, 164, 38);"></p>
            <nav>
                
            <ul class="pull-right pt-5 justify-between">
                <li><a href="/">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
               @if (auth()->user())
               <li><a href="{{route('dashboard')}}">Dashboard</a></li>
               @else
                    <li><a href="{{route('login')}}">Login</a></li>
               @endif
               
            </ul>
        </nav>
           
        </div>
    </header> --}}
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand visible-lg" href="{{ route('home') }}">
                    <img src="{{ asset('assets/demo-data/Logo1.png') }}" width="56" height="56"
                        alt="Large Screen Logo">
                </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu"
                    aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-lg" href="#">
                    <img src="{{ asset('assets/demo-data/Logo1.png') }}" width="56" height="56"
                        alt="Small Screen Logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                    @if (auth()->user())
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!--========================================
Body Content
===========================================-->
    <div>
        @yield('content')
    </div>



    <footer>
        <div class="container">
            <span class="rights pull-left">All rights reserved Copyright © 2025 BSGIDMS</span>
            <ul class="pull-right">
                <!-- <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li> -->
                <!-- <li><a href="#"><i class="fa fa-rss"></i></a></li>
                <li><a href="#"><i class="fa fa-envelope"></i></a></li> -->
            </ul>
        </div>
    </footer>
    <!--=================================
Script Source
=================================-->

    <script src="{{ asset('assets/js/lib/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery.stellar.min.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/lib/css3-animate-it.js') }}"></script>
    <script src="{{ asset('assets/js/app/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.navbar-toggle').click(function() {
                $('#navbar-menu').collapse('toggle');
            });
        });
    </script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':

                    toastr.options.timeOut = 5000;
                    toastr.options.progressBar = true;
                    toastr.options.closeButton = true;
                    toastr.info("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();
                    break;
                case 'success':

                    toastr.options.timeOut = 5000;
                    toastr.options.progressBar = true;
                    toastr.options.closeButton = true;
                    toastr.success("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'warning':

                    toastr.options.timeOut = 10000;
                    toastr.options.progressBar = true;
                    toastr.options.closeButton = true;
                    toastr.warning("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'error':

                    toastr.options.timeOut = 10000;
                    toastr.options.progressBar = true;
                    toastr.options.closeButton = true;
                    toastr.error("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
            }
        @endif
    </script>
</body>

</html>
