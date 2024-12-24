<!DOCTYPE html>
<!--[if lte IE 9]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>BSGEFS</title>
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


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animations.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customcss.css') }}">
    

    <script async src="{{ asset('assets/js/lib/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/app/custom.js')}}"></script>
</head>

<body class="homes">

    <!--========================================
Body Content
===========================================-->
    <header>
        <div class="container">
            <a href="#" class="logo pull-left">
                <figure><img src="{{ asset('assets/demo-data/Logo1.png') }}" width="56" height="56" alt="/"></figure>
            </a>
            <p style="color: rgb(26, 164, 38);"></p>
            <nav>
                
            <ul class="pull-right pt-5">
                <li><a href="/">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="{{route('login')}}">Login</a></li>
            </ul>
        </nav>
           
        </div>
    </header>
    <!--========================================
Body Content
===========================================-->
    <div>
        @yield('content')
    </div>

   
   
    <footer>
        <div class="container">
            <span class="rights pull-left">All rights reserved Copyright © 2025 BSGEFS</span>
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
    <script src="{{ asset('assets/js/lib/css3-animate-it.js') }}"></script>
    <script src="{{ asset('assets/js/app/main.js') }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> --}}
</body>

</html>
