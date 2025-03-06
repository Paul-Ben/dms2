<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benue State Government Integrated Document Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon_io/site.webmanifest') }}">
    <style>
        body {
            margin: 0px;
            font-family: Sora, Arial, sans-serif;
        }

        .active {
            color: #0C4F24 !important;
        }

        .btn {

            width: 169px;
        }

        .border {
            border-width: 1px;
            border-color: red;
        }

        .wrapper {
            padding: 100px;
        }

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
                text-align: left !important;

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

        section {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .subtitle {
            color: #2A323F;
            font-family: Sora, sans-serif;
            font-weight: 300;
            font-size: 38px;
            line-height: 47.88px;
            letter-spacing: -3%;


        }

        .title {
            font-family: Sora, sans-serif;
            font-weight: 700;
            font-size: 60px;
            line-height: 76px;
            letter-spacing: -3%;
            color: #2A323F;
            ;

        }

        .slogan {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 400;
            font-size: 20px;
            line-height: 28px;
            letter-spacing: -2%;
            color: #8E98A8;

        }

        .account-text {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 400;
            font-size: 14px;
            line-height: 21px;
            letter-spacing: -2%;
            color: #8E98A8;
        }

        .account-text-login {
            font-family: "Plus Jakarta Sans", Arial, Helvetica, sans-serif;
            font-weight: 700;
            font-size: 14px;
            line-height: 21px;
            letter-spacing: -2%;
            text-decoration: underline;
            text-decoration-style: solid;
            text-decoration-offset: Auto;
            text-decoration-thickness: Auto;
            color: #0C4F24 !important;
        }

        .body-text {
            font-family: "Plus Jakarta Sans", Arial, Helvetica, sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: -2%;
            color: #2A323F;
        }

        span>a {
            color: #0C4F24 !important;
            ;
        }

        .footer {
            margin-top: 200px;
            background-color: #0C4F24;
            min-height: 346px;
            text-align: center;
        }

        .footer-logo {
            display: inline-block;
            vertical-align: middle;
            /* Align image and text vertically */
        }

        .footer-logo img {
            display: inline-block;
            margin-right: 100px;
            /* Space between image and text */

        }

        div .text-white {
            text-decoration: none;
        }


        div .footer-container {
            margin-top: 200px;
            background-color: #0C4F24;
            min-height: 346px;
            text-align: center;
        }

        testimonial-text {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: -2%;
            color: #697586;

        }



        @media (max-width: 576px) {
            .navbar-collapse {
                background-color: #28a745;
                padding: 20px;
                text-align: left;
            }
        }


        @media (min-width: 577px) and (max-width: 992px) {
            .navbar-collapse {
                background-color: #28a745;
                padding: 20px;
                text-align: left;
            }
        }

        .card1-div {
            width: 100%;
            height: 312px;
            background-image: url('landing/images/Frame\ 1618872459.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .card2-div {
            width: 100%;
            height: 312px;
            background-image: url('landing/images/Frame\ 1618872462.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .card3-div {
            width: 100%;
            height: 312px;
            background-image: url('landing/images/Frame\ 1618872463.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <!-- Navigation Start -->
    <nav class="navbar navbar-expand-lg  lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{ asset('landing/images/logo.jpeg') }}"
                    style="border-radius: 1em" alt="e-filling-logo" height="50"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#abt">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>


                <ul class="navbar-nav ms-auto">
                    <div class="d-flex">
                        <a href="{{ route('login') }}">
                            <button type="button" class="btn btn-success ml-auto">Login</button>
                        </a>

                    </div>
                    <!-- <li class="nav-item "> <a class="nav-link "  href="#">Login</a> </li> -->
                </ul>

            </div>
        </div>
    </nav>
    <!-- Navigation End -->

    @yield('content')

    <!-- Footer start -->
    <div class="row  text-white text-center">
        <div class="footer-container">
            <div class="row mt-4">
                <!-- First row, three columns -->

                <div class="col-md-4 p-5 text-center">

                    <!-- <div class="d-flex align-items-center text-center" style="margin-left:40%">
                        <img src="images/SEAL BENUE STATE GOV 1.svg" style="padding-right: 5px;">
                        <p style="text-align: left;">Benue State Government
                            Integrated Document Management System</p>
                    </div> -->
                    <div class="d-flex text-start" >
                        <a href="#" class="text-light me-2"><img
                                src="{{ asset('landing/images/SEAL BENUE STATE GOV 1.svg') }}"></a> Benue
                        State Government
                        Electronic Document Management System
                    </div>

                </div>



                <div class="col-md-4 p-4">


                    <h5>Quick Links</h5>
                    <a href="/" class="text-light me-3">Home</a>
                    <a href="#abt" class="text-light me-3">About us</a>
                    <a href="#" class="text-light me-3">Contact us</a>
                    <a href="#" class="text-light">Login</a>

                    <!-- <div class="row">
                        <div class="col-md-3">
                            <a href="#" class="text-white">Home</a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="text-white">About us</a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="text-white">Contact us</a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="text-white">Login</a>
                        </div>
                    </div> -->

                </div>
                <div class="col-md-4 p-4">
                    <!-- <div class="row text-center" style="text-align: center; padding: 2%;">
                        <div class="col-md-3">
                            <img src="images/1.svg" >
                        </div>
                        <div class="col-md-3">
                            <img src="images/2.svg" >
                        </div>
                        <div class="col-md-3">
                            <img src="images/3.svg" >
                        </div>
                        <div class="col-md-3">
                            <img src="images/4.svg" >
                        </div>
                    </div> -->

                    <h5>Follow Us</h5>
                    <a href="#" class="text-light me-3"><img src="{{ asset('landing/images/1.svg') }}"></a>
                    <a href="#" class="text-light me-3"><img src="{{ asset('landing/images/2.svg') }}"></a>
                    <a href="#" class="text-light me-3"><img src="{{ asset('landing/images/3.svg') }}"></a>
                    <a href="#" class="text-light"><img src="{{ asset('landing/images/4.svg') }}"></a><br><br>
                    <span class="body-text">
                        <a href="#" class="text-light me-3">Privacy Policy</a>
                        <a href="#" class="text-light me-3">Terms & Conditions</a>
                    </span>
                </div>
            </div>

            <hr>

            <div class="row mt-4 p-4">

                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-4">
                    <p>© Copyright 2025, All Rights Reserved</p>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center text-center" style="margin-left:40%">
                        <p style="padding-right: 5px;">Powered by BDIC</p><img src="{{asset('landing/images/BDIC logo 1 1.svg')}}">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Footer end -->







    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
