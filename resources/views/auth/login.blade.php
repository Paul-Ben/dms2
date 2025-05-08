@extends('layouts.logandregister')
@section('content')
<div class="container text-center d-none d-sm-block">
    <div class="row no-wrap">
        <div class="col-4">
            <div class="p-3 "><img src="{{ asset('landing/images/hero_image1.png')}}" alt="" style="border-radius: 1em;" width="220"></div>
        </div>
        <div class="col-4">
            <div class="p-3 "><img src="{{ asset('landing/images/landing_image_2.jpg')}}" alt="" style="border-radius: 1em;" width="220"></div>
        </div>
        <div class="col-4">
            <div class="p-3 "><img src="{{ asset('landing/images/landing_image1.jpg')}}" alt="" style="border-radius: 1em;" width="220"></div>
        </div>
    </div>
</div>
    <div class="container form-layout ">
        <div class="row">

            <div class="col-md-8 mx-auto ">
                <div class="login-form  p-sides-large">
                    <div class="text-center"><img src="{{ asset('landing/images/benue_new_logo.svg') }}" width="100"
                            height="100" alt="benue_logo"></div>
                    <h2 class="mb-4 text-center"><span style="color: #0C4F24;">Login</span></h2>
                    <p class="sub-title py-3">Benue State Government Electronic Document Management System</p>
                    @php
                        $lockoutSeconds = null;
                        foreach ($errors->all() as $error) {
                            if (preg_match('/(\d+)\s*seconds?/', $error, $matches)) {
                                $lockoutSeconds = (int) $matches[1];
                                break;
                            }
                        }
                    @endphp

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        @if ($errors->any())
                            <div id="lockout-message" class="alert alert-danger mb-0 w-100">
                                <span id="error-text">{{ $errors->first('email') }}</span>
                                @if ($lockoutSeconds)
                                    <div>
                                        Try again in <span id="countdown">{{ $lockoutSeconds }}</span> seconds.
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if ($lockoutSeconds)
                        <script>
                            let secondsLeft = {{ $lockoutSeconds }};
                            const countdownEl = document.getElementById('countdown');

                            const interval = setInterval(() => {
                                secondsLeft--;
                                countdownEl.textContent = secondsLeft;

                                if (secondsLeft <= 0) {
                                    clearInterval(interval);
                                    document.getElementById('lockout-message').innerHTML =
                                        '<div class="text-success">You can now try logging in again.</div>';
                                }
                            }, 1000);
                        </script>
                    @endif

                    {{-- <div class="d-flex align-items-center justify-content-between mb-3">
                    @if (session('errors'))
                        <span class="alert alert-danger" role="alert">{{ $errors->first('email') }}</span>
                    @endif
                </div> --}}
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <!-- Username Input -->
                        <div class="mb-3 ">
                            <label for="username" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" id="username"
                                placeholder="Enter your Email" value="{{ old('email') }}" autofocus autocomplete="username"
                                required>
                        </div>

                        <!-- Password Input -->

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Enter your password" autocomplete="current-password" required>
                                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                </span>
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Enter your password" autocomplete="current-password" required>
                    </div> --}}
                        <div class="m-2 text-center">
                            {!! htmlFormSnippet() !!}

                            @if ($errors->has('g-recaptcha-response'))
                                <div>
                                    <small class="text-danger">
                                        {{ $errors->first('g-recaptcha-response') }}
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
                                style="color: #0C4F24 !important;"><a href="{{ route('register') }}">Register</a></span></p>
                        {{-- <p class="text-center sub-title">BENGEDMS, Powered by BDIC</p> --}}
                        <div class="d-flex justify-content-center mt-2">
                            <p class="text-center sub-title">BENGEDMS, Powered by </p><a href="https://bdic.ng/"
                                target="__blank"><img src="{{ asset('landing/images/BDIC logo 1 1.svg') }}"></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });
    </script>
@endsection
