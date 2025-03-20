@extends('layouts.homepage')
@section('content')
    <h2 class=" " style="text-align: center; margin-top: 100px;">Benue State Government Electronic Document
        Management System</h2>

    <div class="container mt-5 ">
        <div class="row">
            <div class="col-md-6 ">
                <div class="contact-form">
                    <h2 class="mb-4">Glad to hear from you</h2>
                    <form class="p-5">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" placeholder="Enter subject">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Your message here"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 p-5 justify-content-center text-center d-flex">
                <img src="{{asset('landing/images/ode1.png')}}" alt="Contact Image" width="" class="img-fluid">
            </div>

        </div>

        <div class="col-12">
            <div class="row me-auto ms-auto py-4">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1013114.307186485!2d8.050059606341796!3d7.300096792464691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x105af4786063f635%3A0x241f799ebc348ae!2sBenue!5e0!3m2!1sen!2sng!4v1741708800295!5m2!1sen!2sng"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection
