@extends('layouts.homepage')

@section('content')
    <div class="container">

        <!-- Section start -->
        <section>
            <div class="row">
                <!-- First column, takes up 12 columns on extra small screens, 6 on medium and above -->
                <div class="col-12 col-md-6">
                    <div class="">
                        <p class="subtitle ">Benue State Government</p>
                        <p class="title font-400">Integrated Document Management System</p>
                        <p class="slogan">Efficient Document Management System, tailored for modern workflows</p>
                        <div class="d-flex mtop-4">
                            <a href="{{ route('register') }}">
                                <button type="button" class="btn btn-success ml-auto"
                                    style="width: 363px; height: 57px;">Get started</button>
                            </a>

                        </div>
                        <p class="account-text mt-2">Already have an account? <span class="account-text-login"
                                style="color: #0C4F24 !important;"><a href="{{ route('login') }}">Login</a></span></p>
                    </div>
                </div>
                <!-- Second column, takes up 12 columns on extra small screens, 6 on medium and above -->
                <div class="col-12 col-md-6 text-center">
                    <div class="p-3  ">
                        <!-- <img src="images/vector_shape1.svg"
                                    style="z-index: 5; position: absolute; margin-top: 318px; left: 1000.85px;"> -->
                        <img src="{{ asset('landing/images/benue_new_logo.svg') }}" width="443" height="482"
                            class="w-300">
                    </div>
                </div>
            </div>
        </section>
        <!-- Section end -->
    </div>
    <div class="container " id="abt">

        <!-- Section start -->
        <section>
            <div class="row " style=" height: 631px;"> <!-- background-color: #F9F9F9 -->

                <div class="col-12 col-md-6">
                    <div class="p-3">
                        <img src="{{ asset('landing/images/Governor-Hyacinth-Alia.jpg') }}" width="443" height=""
                            class="w-300" style="border-radius: 1em;">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="p-3 ">
                        <p class="title">About us</p>
                        <p class="body-text" style="">It gives me great pleasure to announce the
                            launch of our new e-filing
                            application, a revolutionary platform designed to make your interactions with the Benue
                            State government more efficient and accessible.
                        </p>

                        <p class="body-text  text-left mtop-4" style="">
                            For too long, filing documents with ministries, departments, and agencies has been a
                            cumbersome and time-consuming process. This new application streamlines the process,
                            allowing you to submit your documents online, 24/7, from the comfort of your home or office.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section end -->
    </div>
    <!-- <div class="padding-200 "></div> -->
    <div class="container mtop-300 mtop-150">

        <!-- Section start -->
        <section class="">
            <div class="container ">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="p-3  ">

                            <p class="title ">How it works</p>
                            <p class="body-text text-justify" style="text-align: justify;">Submit a document for
                                processing
                                from the comfort of your home to any of
                                the
                                ministries or agencies within the Benue State Civil Service. This service ensures that
                                your
                                document gets the required attention in real time with dispatch and professionalism.
                            </p>
                            <p class="body-text text-justify" style="text-align: justify;">The Government of Benue
                                State wants to digitize her services to make life easier and more comfortable for her
                                citizenry. This electronic document filling system makes your documents get submitted to
                                any Benue State Civil Service office without needing your physical presence to visit
                                that office.
                            </p>
                            <p class="body-text text-justify" style="text-align: justify;">Take for instance, you can
                                stay anywhere and request for your Benue State of Origin Certificate without you
                                visiting any physical office.
                            </p>
                            <p class="body-text">Play the video embedded here to learn more...</p>


                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="p-3 ">



                            <div style="" class="center-text">


                                <div class="custom-video-container my-5">
                                    <!-- <h2 class="p-3">Learn more...</h2> -->
                                    <video controls>
                                        <source src="{{ asset('landing/videos/dms_video.mp4') }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>

                                <!-- <img src="images/how_it_works.jpg" width="" style=""> -->
                            </div>


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
                        <a href="{{ route('mdas') }}">
                            <div class="py-4 card1-div"> </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3">
                        <a href="{{ route('agency') }}">
                            <div class="py-4 card2-div"> </div>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-3">
                        <div class="py-4 card3-div"> </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Section end -->
    <div class="container">
        <!-- Section start -->
        <section class="">
            <div class="row ">
                <!-- Second column, takes up 12 columns on extra small screens, 4 on medium and above -->
                <div class="col-12 text-center">
                    <div class="p-3  ">
                        <span class="title " style="width: 700px;">What Our Users <br> Are Saying</span>
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
                                <img src="{{ asset('landing/images/rating.svg') }}" alt="">
                            </div>
                            <div>
                                <p class="testimonial-text text-justify" style="text-align: justify;">“The automation and collaboration features of BENGEDMS have helped our company stay organized and productive. 
                                    Our team can now access and share documents securely from anywhere.”</p>
                            </div>
                            <div class="row">
                                <div class="col" style="text-align: right;">
                                    <img src="{{ asset('landing/images/usr1.svg') }}" alt=""
                                        style="text-align: right;">
                                </div>
                                <div class="col">
                                    <span class="testimonial-text text-justify"
                                        style="text-align: justify; font-weight: bold;">David Ochanya</span><br>
                                    <span class="testimonial-text text-justify"
                                        style="text-align: justify; font-style: italic;">CEO of Tonjons Ventures</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 border "
                            style="border: thin solid #dde7e6; background-color: #F9F9F9; border-radius: 2em;">

                            <div class="py-4 ">
                                <img src="{{ asset('landing/images/rating.svg') }}" alt="">
                            </div>
                            <div>
                                <p class="testimonial-text text-justify" style="text-align: justify;">“As a government agency, handling massive paperwork was a challenge. With BENGEDMS, 
                                    we’ve digitized our records, making retrieval and approvals seamless. 
                                    It’s truly a game-changer!.”</p>
                            </div>
                            <div class="row">
                                <div class="col" style="text-align: right;">
                                    <img src="{{ asset('landing/images/user2.svg') }}" alt=""
                                        style="text-align: right;">
                                </div>
                                <div class="col">
                                    <span class="testimonial-text text-justify"
                                        style="text-align: justify; font-weight: bold;">Grace Nguveren</span><br>
                                    <span class="testimonial-text text-justify"
                                        style="text-align: justify; font-style: italic;">
                                        Government Administrator</span>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 border "
                            style="border: thin solid #dde7e6; background-color: #F9F9F9; border-radius: 2em;">

                            <div class="py-4 ">
                                <img src="{{ asset('landing/images/rating.svg') }}" alt="">
                            </div>
                            <div>
                                <p class="testimonial-text text-justify" style="text-align: justify;">“BENGEDMS has completely transformed the way we manage documents.
                                     The ease of access, security, and efficiency have significantly improved our workflow. 
                                    No more lost files or delays!.”</p>
                            </div>
                            <div class="row">
                                <div class="col" style="text-align: right;">
                                    <img src="{{ asset('landing/images/user3.svg') }}" alt=""
                                        style="text-align: right;">
                                </div>
                                <div class="col">
                                    <span class="testimonial-text text-justify"
                                        style="text-align: justify; font-weight: bold;">John Adekunle</span><br>
                                    <span class="testimonial-text text-justify"
                                        style="text-align: justify; font-style: italic;">
                                        IT Manager Simplex Co.</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!-- Section end -->

    </div>
    <div class="">
        <div class="mtop-300 d-flex justify-content-center align-items-center ">
            <a href="{{ route('register') }}"> <img src="{{ asset('landing/images/get_started.png') }}" width="1193"
                    height="383" class="mtop-100 get_started_img_lg img-fluid"> </a>

        </div>
    </div>
    <div class="container" style="margin-top: 150px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="faqs-head-div">
                    <h2 class="mb-4 text-center faqs-title">FAQs</h2>
                    <p class="text-center">Get your concerns address in this Frequently Asked Questions section</p>
                </div>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                                Will my document reach its destination?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse " data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, it will, and on time - at the click of the button.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                How soon can I get my document processed?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                As soon as the expected person to treat has attended to it.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                How secured is this process in terms of privacy?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We treat your personal details only for the purpose of ensuring that your document reach
                                the desired destination (read our privacy policy below). Moreover, our system is secured
                                with technologies like SSL to keep your transactions safe.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                Does it cost much for this seamless services?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                No, just a token for maintaining this service/processing fee, as may be seen at the point of
                                payment.
                            </div>
                        </div>
                    </div>

                </div>


                <div class="faqs-qs-div">
                    <h2 class="mb-4 text-center faqs-qs">Still have questions?</h2>
                    <p class="text-center">We'll be glad to hear from you</p>

                </div>
                <div class="d-flex text-center justify-content-center align-items-center">
                    <a href="{{route('contact')}}"><button type="button" class="btn btn-success ml-auto "
                            style="width: 230px; height: 48px;">Contact</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection
