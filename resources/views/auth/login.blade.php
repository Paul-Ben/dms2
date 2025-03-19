@extends('layouts.logandregister')
@section('content')
<div class="container  ">
    <div class="row mtop-small-150  ">

        <div class="col-md-8 mx-auto ">
            <div class="login-form  p-sides-large">
                <div class="text-center"><img src="{{ asset('landing/images/benue_new_logo.svg') }}" width="100"
                        height="100" alt="benue_logo"></div>
                <h2 class="mb-4 text-center"><span style="color: #0C4F24;">Login</span></h2>
                <p class="sub-title py-3">Benue State Government Electronic Document Management System</p>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    @if (session('errors'))
                        <span class="alert alert-danger" role="alert">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <!-- Username Input -->
                    <div class="mb-3 ">
                        <label for="username" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="username" placeholder="Enter your Email"
                        value="{{ old('email') }}" autofocus autocomplete="username" required>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Enter your password" autocomplete="current-password" required>
                    </div>
                    <div class="m-2 text-center">
                        {!!htmlFormSnippet()!!}

                        @if ($errors->has('g-recaptcha-response'))
                        <div>
                            <small class="text-danger">
                                {{$errors->first('g-recaptcha-response')}}
                            </small>
                        </div>
                        
                        @endif
                    </div>
                    {{-- <div class="g-recaptcha" data-sitekey="6LetKvAqAAAAABrCI--Y13sWrKqO_Lwx1tOgrJZ4"></div> --}}

                    <!-- Remember Me Checkbox -->
                    <!-- <div class="mb-3 form-check">
                      <input type="checkbox" class="form-check-input" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div> -->

                    <!-- Forgot Password Link -->
                    <div class="mt-3 mb-3 text-center">
                        <a href="{{ route('password.request') }}" class="small">Forgot password?</a>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success w-100">Sign in</button><br>

                    <p class="account-text py-3">Don't have an account? <span class="account-text-login"
                            style="color: #0C4F24 !important;"><a
                                href="{{ route('register') }}">Register</a></span></p>
                    {{-- <p class="text-center sub-title">BENGEDMS, Powered by BDIC</p> --}}
                    <div class="d-flex justify-content-center mt-2">
                        <p class="text-center sub-title">BENGEDMS, Powered by </p><a href="https://bdic.ng/" target="__blank"><img
                   src="{{ asset('landing/images/BDIC logo 1 1.svg') }}"></a>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>
    {{-- <div>
        @include('layouts.newnav')
        <form action="{{ route('login') }}" method="POST">
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
                                    <img class="mb-3" src="{{ asset('assets/demo-data/Logo1.png') }}" width="130px" height="130px" alt="">
                                    <h2 class="text-success">LOGIN</h2>
                                    <small class="text-muted">Benue State Government Electronic Document Management System</small>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    @if (session('errors'))
                                        <span class="alert alert-danger" role="alert">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput"
                                        placeholder="name@example.com" name="email" value="{{ old('email') }}" required
                                        autofocus autocomplete="username">
                                    <label for="floatingInput">Email address</label>
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                                        required autocomplete="current-password" name="password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                 <div class="m-2 text-center">
                                            {!!htmlFormSnippet()!!}

                                            @if ($errors->has('g-recaptcha-response'))
                                            <div>
                                                <small class="text-danger">
                                                    {{$errors->first('g-recaptcha-response')}}
                                                </small>
                                            </div>
                                            
                                            @endif
                                        </div>
                                        <div class="m-2 text-center">
                                            <a href="{{ route('password.request') }}">Forgot Password</a>
                                        </div>
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                                <p class="text-center mb-0">Don't have an Account? <a href="{{route('register')}}">Register</a></p>
                                <p class="text-center"><small class="text-center text-muted">BENGEDMS, Powered by BDIC</small></p>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <!-- Sign In End -->
    </div>
    </div> --}}
@endsection