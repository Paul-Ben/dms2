@extends('layouts.logandregister')
@section('content')
    <div>
        @include('layouts.nav')
        <div class="container-xxl position-relative bg-white d-flex p-0">
            <!-- Spinner Start -->
            <div id="spinner"
                class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>


            <div class="container-fluid">
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-10 ">
                        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-4">
                                        <div class="text-center">
                                            <div class="justify-content-center d-flex align-items-center mb-3">
                                                {{-- <img class="me-3" src="{{ asset('assets/demo-data/Logo1.png') }}" width="80px" height="80px" alt=""> --}}
                                                <div>
                                                    <h2 class="text-success">REGISTER</h2>
                                                    <small class="text-muted">Integrated Document Manangement System</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Name Field -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingName"
                                                placeholder="Terver Ameh" name="name" value="{{ old('name') }}"
                                                required autofocus autocomplete="name">
                                            <label for="floatingName">Name</label>
                                        </div>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingEmail"
                                                placeholder="name@example.com" name="email" value="{{ old('email') }}"
                                                required autocomplete="username">
                                            <label for="floatingEmail">Email address</label>
                                            @if ($errors->has('email'))
                                                <small class="text-danger">{{ $errors->first('email') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Fields -->
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-4">
                                            <input type="password" class="form-control" id="floatingPassword"
                                                placeholder="Password" required name="password">
                                            <label for="floatingPassword">Password</label>
                                            @if ($errors->has('password'))
                                                <small class="text-danger">{{ $errors->first('password') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-4">
                                            <input type="password" class="form-control" id="floatingConfirmPassword"
                                                placeholder="Confirm Password" required name="password_confirmation">
                                            <label for="floatingConfirmPassword">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone and NIN Fields -->
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control" id="floatingPhone"
                                                placeholder="+1234567890" name="phone_number" style="padding: 16px;"
                                                value="{{ old('phone_number') }}" required pattern="^\+?[0-9\s\-()]{6,}$">
                                            <input type="text" name="default_role" value="User" hidden>
                                            <input type="text" name="designation" value="User" hidden>
                                            {{-- <label for="floatingPhone">Phone Number</label> --}}
                                            <small id="phoneError" class="text-danger" style="display: none;">
                                                Invalid phone number for the selected country.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingNIN"
                                                placeholder="34556566778" name="nin_number" value="{{ old('nin_number') }}"
                                                required pattern="[0-9]{11}">
                                            <label for="floatingNIN">NIN Number</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gender and Account Type Fields -->
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-4">
                                            <select class="form-control" name="gender" id="genderSelect" required>
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <label for="genderSelect">Gender</label>
                                            @if ($errors->has('gender'))
                                                <small class="text-danger">{{ $errors->first('gender') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-4">
                                            <select class="form-control" name="account_type" id="accountTypeSelect"
                                                onchange="toggleAccountFields()" required>
                                                <option value="">Select Account Type</option>
                                                <option value="individual">Individual</option>
                                                <option value="corporate">Corporate</option>
                                            </select>
                                            <label for="accountTypeSelect">Account Type</label>
                                            @if ($errors->has('account_type'))
                                            <small class="text-danger">{{ $errors->first('account_type') }}</small>
                                        @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Corporate Fields -->
                                <div id="corporateFields" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingCompanyName"
                                                    placeholder="Company Name" name="company_name"
                                                    value="{{ old('company_name') }}">
                                                <label for="floatingCompanyName">Company Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingRCNumber"
                                                    placeholder="RC Number" name="rc_number"
                                                    value="{{ old('rc_number') }}">
                                                <label for="floatingRCNumber">RC Number</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingCompanyAddress"
                                                    placeholder="Company Address" name="company_address"
                                                    value="{{ old('company_address') }}">
                                                <label for="floatingCompanyAddress">Company Address</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Region Selection -->
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-4">
                                            <select class="form-control" name="region" id="regionSelect"
                                                onchange="toggleRegionFields()" required>
                                                <option value="">Select Region</option>
                                                <option value="nigeria">Nigeria</option>
                                                <option value="international">International</option>
                                            </select>
                                            <label for="regionSelect">Region</label>
                                            @if ($errors->has('region'))
                                            <small class="text-danger">{{ $errors->first('region') }}</small>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-4" id="internationalFields" style="display: none;">
                                            <select class="form-control" name="country" id="country">
                                                <option value="" selected='selected'>Select Country</option>
                                            </select>
                                            <label for="countryInput">Country</label>
                                            @if ($errors->has('country'))
                                            <small class="text-danger">{{ $errors->first('country') }}</small>
                                        @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Nigeria Fields -->
                                <div id="nigeriaFields" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating mb-4">
                                                <select class="form-control" name="state" onchange="selectLGA(this)"
                                                    id="state">
                                                    <option value="" selected="selected">Select State</option>
                                                </select>
                                                <label for="stateSelect">State</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-floating mb-4">
                                                <select class="form-control" name="lga" id="lga">
                                                    <option value="">Select Local Government Area</option>
                                                </select>
                                                <label for="lgaSelect">Local Government Area</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- International Fields -->

                                <div class="m-2 d-flex justify-content-center">
                                    {!! htmlFormSnippet() !!}

                                    @if ($errors->has('g-recaptcha-response'))
                                        <div>
                                            <small class="text-danger">
                                                {{ $errors->first('g-recaptcha-response') }}
                                            </small>
                                        </div>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-center mb-4">
                                    <button type="submit" class="btn btn-primary py-3 w-50">Register</button>
                                </div>

                                <p class="text-center mb-0">Already have an Account?
                                    <a href="{{ route('login') }}">Sign In</a>
                                </p>
                                <p class="text-center"><small class="text-center text-muted">BSGIDMS Powered by
                                        BDIC</small></p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sign In End -->
    </div>
@endsection
