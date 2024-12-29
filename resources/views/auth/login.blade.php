@extends('layouts.logandregister')
@section('content')

    <div>
        @include('layouts.nav')
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
                                    <h3>Sign In</h3>
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
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                    </div>
                                    <a href="">Forgot Password</a>
                                </div>
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                                <p class="text-center mb-0">Don't have an Account? <a href="{{route('register')}}">Sign Up</a></p>

                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <!-- Sign In End -->
    </div>
    </div>
@endsection