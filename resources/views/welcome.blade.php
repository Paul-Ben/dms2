@extends('layouts.homepage')
@section('content')
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
                            <h1 class="color-white">E-Filing System</h1>
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
                        It gives me great pleasure to announce the launch of our new e-filing application, a revolutionary
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
            <p>Submit a document for processig from the comfort of your home to any of the ministries or agencies within the
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
                    <p>File Anytime, Anywhere. Experience the Convenience of E-Filing with Benue State Government. Access Our Online Portal Now.</p>
                    <a href="{{route('login')}}" class="btn mt-40">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials animatedParent  " data-sequence="500">
        <div class="container">
            <h2 class="">TESTIMONIALS</h2>
            <p>Beyond Convenience: How E-Filing is Improving Efficiency and Transparency in Benue State Government</p>
            <div class="row">
                <div class="col-sm-6 animated fadeInLeft" data-id="1">
                    <div class="testimonial">
                        <figure><img src="{{ asset('assets/demo-data/m1.jpg') }}" alt="/" style="border-radius: 50%"></figure>
                        <q>I was initially hesitant to try the e-filing system, but I'm so glad I did!  This system is a game-changer for businesses like mine.</q>
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
@endsection
