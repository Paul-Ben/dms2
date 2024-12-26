@extends('layouts.logandregister')
@section('content')
    <div>
        @include('layouts.nav')
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="container-xxl position-relative bg-white d-flex p-0">
                <!-- Spinner Start -->
                <div id="spinner"
                    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->


                <!-- Sign In Start -->
                <div class="container-fluid">
                    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                                <div class="text-center">
                                    <img class="mb-3" src="{{asset('dbf/img/logos.png')}}" alt="">
                                    <h3>Sign In</h3>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    @if (session('errors'))
                                        <span class="alert alert-danger" role="alert">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        placeholder="Terver Ameh" name="name" value="{{ old('name') }}" required
                                        autofocus autocomplete="name">
                                    <label for="floatingInput">Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput"
                                        placeholder="name@example.com" name="email" value="{{ old('email') }}" required
                                        autofocus autocomplete="username">
                                    <label for="floatingInput">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        placeholder="3455656677888" name="nin_number" value="{{ old('nin_number') }}" required
                                         autocomplete="nin_number">
                                    <label for="floatingInput">NIN Number</label>
                                    <input type="text" name="default_role" value="User" hidden>
                                    <input type="text" name="designation" value="User" hidden>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput"
                                        placeholder="08065433456" name="phone_number" value="{{ old('phone') }}" required
                                         autocomplete="phone">
                                    <label for="floatingInput">Phone Number</label>
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                                        required autocomplete="new-password" name="password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                                        required autocomplete="new-password" name="password_confirmation">
                                    <label for="floatingPassword">Confirm Password</label>
                                </div>
                                <div class="form-floating mb-4">
                                        <select class="form-control" name="gender" id="genderSelect">
                                            <option value="">Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    <label for="floatingInput">Gender</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                    </div>
                                    <a href="">Forgot Password</a>
                                </div>
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                                <p class="text-center mb-0">Already have an Account? <a href="{{route('login')}}">Sign In</a></p>

                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <!-- Sign In End -->
    </div>
    </div>
@endsection