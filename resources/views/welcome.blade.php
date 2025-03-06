@extends('layouts.homepage')
{{-- @section('content')
    <style>
        .pop-out {
            width: 300px;
            height: 400px;
            /* background-color: #4CAF50; Green background */
            color: white;
            /* White text color */
            display: flex;
            justify-content: center;
            align-items: center;
            /* font-size: 24px; */
            border-radius: 5px;
            transition: transform 0.3s ease;
            /* Smooth transition */
            margin: 10px;
        }

        .pop-out:hover {
            transform: scale(1.1);
            /* Scale up the element */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            /* Add shadow for depth */
        }
    </style>
    <section class="sign-up parallax parallax_one animatedParent" data-sequence="500" data-stellar-background-ratio="0.5">
        <div class="parallax_inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-6 text-center">
                        <div class="info mb-30">
                            <h2 class="color-white">Benue State Government</h2>
                            <h1 class="color-white">Integrated Document Management System</h1>
                            <h2 class="mb-30 color-white">Digitize It</h2>
                            <span class="subscribe pb-5">Secure and reliable<br> document filing.<i
                                    class="fa fa-arrow-circle-o-right"></i></span> 
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="welcome animatedParent" data-sequence="500">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-8 col-sm-6 animated fadeInLeft text-justify" data-id="1">
                    <h1>WELCOME!</h1>
                    <p>
                        It gives me great pleasure to announce the launch of our new Integrated Document Management System, a revolutionary
                        platform designed to make your interactions with the Benue State government more efficient and
                        accessible.
                    </p>
                    <br />
                    <p>
                        

                        For too long, filing documents with ministries, departments, and agencies has been a cumbersome and
                        time-consuming process. This new application streamlines the process, allowing you to submit your
                        documents online, 24/7, from the comfort of your home or office.
                    </p>
                </div>
                <div class="col-lg-5 col-md-4 col-sm-6 animated fadeInLeft" data-id="2">
                    <figure>
                        <img src="{{ asset('assets/demo-data/gov_alia.jpeg') }}" alt="/" style="height: 296px" />
                    </figure>
                </div>
            </div>
        </div>
    </section>


    <section class="features">
        <div class="container">
            <h2>FILING LISTING </h2>
            <p class="text-justify">Submit a document for processig from the comfort of your home to any of the ministries or agencies within the
                Benue State Civil Service.
                This service ensures that your document gets the required attention in real time with dispatch and
                professionalism. Click on any of the items below
                to select a ministry or agency to contact.
            </p>
            <div class="row mt-50">
                <a href="{{ route('mdas') }}">
                    <div class="col-sm-4 text-center pop-out">
                        <figure>
                            <img src="{{ asset('assets/demo-data/wp.jpg') }}" alt="">
                            <figcaption>
                                <h5 class="color-white">Ministries</h5>
                            </figcaption>
                        </figure>
                    </div>
                </a>

                <a href="{{ route('agency') }}">
                    <div class="col-sm-4 text-center pop-out">
                        <figure>
                            <img src="{{ asset('assets/demo-data/bss1.png') }}" alt="">
                            <figcaption>
                                <h5 class="color-white">Agencies</h5>
                            </figcaption>
                        </figure>
                    </div>
                </a>

                <a href="/login">
                    <div class="col-sm-4 text-center pop-out">
                        <figure>
                            <img src="{{ asset('assets/demo-data/Logo1.png') }}" alt="">
                            <figcaption>
                                <h5 class="color-white">Government House</h5>
                            </figcaption>
                        </figure>
                    </div>
                </a>

            </div>
            
        </div>
    </section>

    <section class="promo">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                    <h2 class="color-white mb-40">What are you waiting for?</h2>
                    <p>File Anytime, Anywhere. Experience the Convenience of Integrated Document Management System, with Benue State Government. Access Our Online Portal Now.</p>
                    <a href="{{route('login')}}" class="btn mt-40">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials animatedParent  " data-sequence="500">
        <div class="container">
            <h2 class="">TESTIMONIALS</h2>
            <p>Beyond Convenience: How Integrated Document Management System is Improving Efficiency and Transparency in Benue State Government</p>
            <div class="row">
                <div class="col-sm-6 animated fadeInLeft" data-id="1">
                    <div class="testimonial">
                        <figure><img src="{{ asset('assets/demo-data/m1.jpg') }}" alt="/" style="border-radius: 50%"></figure>
                        <q>I was initially hesitant to try the Integrated Document Management System, but I'm so glad I did!  This system is a game-changer for businesses like mine.</q>
                        <span>Ternenge Yina, <i class="text-success">Business Owner</i></span>
                    </div>
                </div>
                <div class="col-sm-6 animated fadeInLeft" data-id="2">
                    <div class="testimonial">
                        <figure><img src="{{ asset('assets/demo-data/m3.jpg') }}" alt="/" style="border-radius: 50%"></figure>
                        <q>I could complete the application from anywhere with an internet connection. It saved me time and money on travel expenses</q>
                        <span>Pauline Ogah, <i class="text-success">Student</i></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection --}}

@section('content')
<div class="container">

    <!-- Section start -->
    <section>
        <div class="row">
            <!-- First column, takes up 12 columns on extra small screens, 6 on medium and above -->
            <div class="col-12 col-md-6">
                <div class="p-3">
                    <p class="subtitle">Benue State Government</p>
                    <p class="title">Electronic Document Management System</p>
                    <p class="slogan">Efficient Document Management System, tailored for modern workflows</p>
                    <div class="d-flex">
                        <a href="{{route('register')}}" class="btn btn-success ml-auto">Get Started</a>
                    </div>
                    <p class="account-text">Already have an account? <span class="account-text-login"
                            style="color: #0C4F24 !important;"><a href="{{route('login')}}">Login</a></span></p>
                </div>
            </div>
            <!-- Second column, takes up 12 columns on extra small screens, 6 on medium and above -->
            <div class="col-12 col-md-6 text-center">
                <div class="p-3  ">
                    <!-- <img src="images/vector_shape1.svg"
                        style="z-index: 5; position: absolute; margin-top: 318px; left: 1000.85px;"> -->
                    <img src="{{asset('landing/images/hero_image.png')}}" width="450">
                </div>
            </div>
        </div>
    </section>
    <!-- Section end -->
</div>


<!-- Section start -->
<section>
    <div class="row" style="background-color: #F9F9F9; " id="abt">
        <!-- First column, takes up 12 columns on extra small screens, 6 on medium and above -->
        <div class="col-12 col-md-6">
            <div class="p-5">
                <img src="{{asset('landing/images/about_image.png')}}" width="550" style="">
            </div>
        </div>
        <!-- Second column, takes up 12 columns on extra small screens, 6 on medium and above -->
        <div class="col-12 col-md-6">
            <div class="p-3">
                <div style="font-weight: 492px; width: 492px;  padding: 100px;">
                    <p class="title">About us</p>
                    <p class="body-text" style="text-align: justify;">It gives me great pleasure to announce the launch of our new e-filing
                        application, a revolutionary platform designed to make your interactions with the Benue
                        State government more efficient and accessible.
                    </p>

                    <p class="body-text  text-justify" style="text-align: justify;">
                        For too long, filing documents with ministries, departments, and agencies has been a
                        cumbersome and time-consuming process. This new application streamlines the process,
                        allowing you to submit your documents online, 24/7, from the comfort of your home or office.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section end -->


<div class="container">

    <!-- Section start -->
    <section>
        <div class="row">
            <!-- First column, takes up 12 columns on extra small screens, 6 on medium and above -->
            <div class="col-12 col-md-7">
                <div class="p-3">
                    <p class="title">How it works</p>
                    <p class="body-text text-justify" style="text-align: justify;">Submit a document for processing from the comfort of your home to any of
                        the
                        ministries or agencies within the Benue State Civil Service. This service ensures that your
                        document gets the required attention in real time with dispatch and professionalism. Click
                        on any of the items below to select a ministry or agency to contact.
                    </p>

                </div>
            </div>
            <!-- Second column, takes up 12 columns on extra small screens, 6 on medium and above -->
            <div class="col-12 col-md-5">
                <div class="p-3  ">
                    <!-- style="background-color: #F2F2F2; height: 150px; border-radius: 8px;" -->

                    <div style="height: 150px; border-radius: 8px; text-align: center;" class="center-text">
                        <img src="{{asset('landing/images/how_it_works.jpg')}}" width="" style="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section end -->

</div>
    <!-- Section start -->
    <section class="">

        <div class="container mt-5">
            <div class="row g-3">
                <div class="col-12 col-md-4"> 
                    <div class="p-3">
                        <a href="{{route('login')}}">
                            <div class="py-4 card1-div"> </div> 
                        </a>
                                      
                    </div>                     
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3">
                        <a href="{{route('login')}}">
                            <div class="py-4 card2-div"> </div>
                        </a>              
                    </div> 
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3">
                        <a href="{{route('login')}}">
                            <div class="py-4 card3-div"> </div>
                        </a>              
                    </div> 
                </div>
            </div>
        </div>

    </section>
    <!-- Section end -->

<div class="container " style="margin-top: 100px;">

    <!-- Section start -->
    <section class="">

        <div class="row">

            <!-- First column, takes up 12 columns on extra small screens, 4 on medium and above -->
            <div class="col-12 col-md-4">
                <div class="p-3">
                    &nbsp;

                </div>
            </div>
            <!-- Second column, takes up 12 columns on extra small screens, 4 on medium and above -->
            <div class="col-12 col-md-8">
                <div class="p-3 justify-start ">

                    <span class="title " style="width: 700px;">What Our Users Are Saying</span>

                </div>
            </div>

            <!-- Third column, takes up 12 columns on extra small screens, 4 on medium and above -->
            <div class="col-12 col-md-4">
                <div class="p-3  ">

                    &nbsp;

                </div>
            </div>
        </div>
        <!-- ===== -->

        <div class="container mt-5">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="p-3 border "
                        style="border: thin solid #dde7e6; background-color: #F9F9F9; border-radius: 2em;">

                        <div class="py-4 ">
                            <img src="{{asset('landing/images/rating.svg')}}" alt="">
                        </div>
                        <div>
                            <p class="testimonial-text text-justify" style="text-align: justify;">“I was initially
                                hesitant to try the e-filing system, but I'm so glad I did! This system is a
                                game-changer for businesses like mine.”</p>
                        </div>
                        <div class="row">
                            <div class="col" style="text-align: right;">
                                <img src="{{asset('landing/images/usr1.svg')}}" alt="" style="text-align: right;">
                            </div>
                            <div class="col">
                                <span class="testimonial-text text-justify"
                                    style="text-align: justify; font-weight: bold;">Ternenge Yina</span><br>
                                <span class="testimonial-text text-justify"
                                    style="text-align: justify; font-style: italic;">Business Owner</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3 border "
                        style="border: thin solid #dde7e6; background-color: #F9F9F9; border-radius: 2em;">

                        <div class="py-4 ">
                            <img src="{{asset('landing/images/rating.svg')}}" alt="">
                        </div>
                        <div>
                            <p class="testimonial-text text-justify" style="text-align: justify;">“I was initially
                                hesitant to try the e-filing system, but I'm so glad I did! This system is a
                                game-changer for businesses like mine.”</p>
                        </div>
                        <div class="row">
                            <div class="col" style="text-align: right;">
                                <img src="{{asset('landing/images/user2.svg')}}" alt="" style="text-align: right;">
                            </div>
                            <div class="col">
                                <span class="testimonial-text text-justify"
                                    style="text-align: justify; font-weight: bold;">Paulinne Ogah</span><br>
                                <span class="testimonial-text text-justify"
                                    style="text-align: justify; font-style: italic;">Student</span>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3 border "
                        style="border: thin solid #dde7e6; background-color: #F9F9F9; border-radius: 2em;">

                        <div class="py-4 ">
                            <img src="{{asset('landing/images/rating.svg')}}" alt="">
                        </div>
                        <div>
                            <p class="testimonial-text text-justify" style="text-align: justify;">“I was initially
                                hesitant to try the e-filing system, but I'm so glad I did! This system is a
                                game-changer for businesses like mine.”</p>
                        </div>
                        <div class="row">
                            <div class="col" style="text-align: right;">
                                <img src="{{asset('landing/images/user3.svg')}}" alt="" style="text-align: right;">
                            </div>
                            <div class="col">
                                <span class="testimonial-text text-justify"
                                    style="text-align: justify; font-weight: bold;">Ms. Linda E.</span><br>
                                <span class="testimonial-text text-justify"
                                    style="text-align: justify; font-style: italic;">Practice Manager</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- Section end -->

</div>
@endsection