@extends('layouts.logandregister')
@section('content')
    {{-- <div>
        @include('layouts.newnav')
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
                                                <img class="me-3" src="{{ asset('assets/demo-data/Logo1.png') }}"
                                                    width="80px" height="80px" alt="">
                                                <div>
                                                    <h2 class="text-success">REGISTER</h2>
                                                    <small class="text-muted">Benue State Government Electronic Document
                                                        Manangement System</small>
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
                                <p class="text-center"><small class="text-center text-muted">BENGEDMS Powered by
                                        BDIC</small></p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sign In End -->
    </div> --}}
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
        <div class="row ">

            <div class="col-md-8 mx-auto ">
                <div class="contact-form mtop-small-150">

                    <div class="text-center"><img src="{{ asset('landing/images/benue_new_logo.svg') }}" width="100"
                            height="100" alt="benue_logo"></div>
                    <h2 class="mb-4 text-center"><span style="color: #0C4F24;">Register</span></h2>
                    <p class="sub-title py-3 text-center">Benue State Government Electronic Document Management System</p>


                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Header Section -->
                        {{-- <div class="row">
                            <div class="mb-4">
                                <div class="text-center">
                                    <div class="justify-content-center d-flex align-items-center mb-3">
                                        <img class="me-3" src="{{ asset('assets/demo-data/Logo1.png') }}" width="80px"
                                            height="80px" alt="">
                                        <div>
                                            <h2 class="text-success">REGISTER</h2>
                                            <small class="text-muted">Benue State Government Electronic Document Manangement
                                                System</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Name and Email Fields -->
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingName" placeholder="Terver Ameh"
                                        name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                                    <label for="floatingName">Name</label>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingEmail"
                                        placeholder="name@example.com" name="email" value="{{ old('email') }}" required
                                        autocomplete="username">
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
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                                        required name="password">
                                        {{-- <span class="input-group-text" id="togglePassword1"
                                            style="cursor: pointer;">
                                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                           
                                        </span> --}}
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
                                    <input type="tel" class="form-control" id="floatingPhone" placeholder="+1234567890"
                                        name="phone_number" style="padding: 16px;" value="{{ old('phone_number') }}"
                                        required pattern="^\+?[0-9\s\-()]{6,}$">
                                        <label for="floatingPhone">Phone Number</label>
                                    <input type="text" name="default_role" value="User " hidden>
                                    <input type="text" name="designation" value="User " hidden>
                                    <small id="phoneError" class="text-danger" style="display: none;">Invalid phone number
                                        for the selected country.</small>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingNIN"
                                    placeholder="Type your 11-digit NIN" name="nin_number" value="{{ old('nin_number') }}"
                                        required pattern="[0-9]{11}" maxlength="11">
                                    <label for="floatingNIN">NIN: Type your 11-digit NIN</label>
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
                                            placeholder="RC Number" name="rc_number" value="{{ old('rc_number') }}">
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
                                    <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                                </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-center mb-4">
                            <button type="submit" class="btn btn-success py-3 w-50">Register</button>
                        </div>

                        <p class="text-center mb-0">Already have an Account? <a href="{{ route('login') }}">Sign In</a>
                        </p>
                        {{-- <p class="text-center"><small class="text-center text-muted">BENGEDMS Powered by BDIC</small></p> --}}
                    </form>
                    <div class="d-flex justify-content-center mt-2">
                         <p class="text-center sub-title">BENGEDMS, Powered by </p><a href="https://bdic.ng/" target="__blank"><img
                    src="{{ asset('landing/images/BDIC logo 1 1.svg') }}"></a>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <!-- Include the intl-tel-input library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@16.0.3/build/js/utils.js",
        });

        // store the instance variable so we can access it in the console e.g. window.iti.getNumber()
        window.iti = iti;

        (function($) {

            $('form').on('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let form = $(this).get(0);
                $('form').addClass('was-validated');

                //Need to display invalid feedback explicitly on submit for input fields due to plugin changing structure
                $('form .tel-input').each(function() {
                    let telInput = $(this).get(0);
                    if ($(this).prop('required') && !telInput.checkValidity()) {
                        $(this).parents('.form-group').find('.invalid-feedback').show();
                    }
                });

            });

            input.addEventListener("countrychange", function() {
                let isValidNumber = iti.isValidNumber();
                checkPhoneValidation($(this), isValidNumber);
            });

            $('form').on('keyup', '.tel-input', function(event) {
                let isValidNumber = iti.isValidNumber();
                checkPhoneValidation($(this), isValidNumber);
            });

        })(jQuery);

        function checkPhoneValidation(element, isValidNumber) {

            let invFeedbackDiv = element.parents('.form-group').find('.invalid-feedback');
            input = element.get(0);

            if (isValidNumber) {
                //need to set this first as otherwise input validity is falsely linking to custom error
                input.setCustomValidity('');
            }

            if (isValidNumber && input.validity.valid) {
                input.setCustomValidity('');
                invFeedbackDiv.hide();
            } else {
                invFeedbackDiv.html('Invalid phone number');
                input.setCustomValidity('invalid');

                if ($('form').hasClass('was-validated')) {
                    invFeedbackDiv.show();
                }
            }

        }
    </script>
    <script>
        function toggleAccountFields() {
            const accountType = document.getElementById('accountTypeSelect').value;
            const corporateFields = document.getElementById('corporateFields');

            if (accountType === 'corporate') {
                corporateFields.style.display = 'block';
            } else {
                corporateFields.style.display = 'none';
            }
        }

        function toggleRegionFields() {
            const region = document.getElementById('regionSelect').value;
            const nigeriaFields = document.getElementById('nigeriaFields');
            const internationalFields = document.getElementById('internationalFields');

            if (region === 'nigeria') {
                nigeriaFields.style.display = 'block';
                internationalFields.style.display = 'none';
            } else if (region === 'international') {
                nigeriaFields.style.display = 'none';
                internationalFields.style.display = 'block';
            } else {
                nigeriaFields.style.display = 'none';
                internationalFields.style.display = 'none';
            }
        }
    </script>
    <script>
        //Fetch all States
        fetch('https://nga-states-lga.onrender.com/fetch')
            .then((res) => res.json())
            .then((data) => {
                var x = document.getElementById("state");
                for (let index = 0; index < Object.keys(data).length; index++) {
                    var option = document.createElement("option");
                    option.text = data[index];
                    option.value = data[index];
                    x.add(option);
                }
            });
        //Fetch Local Goverments based on selected state
        function selectLGA(target) {
            var state = target.value;
            fetch('https://nga-states-lga.onrender.com/?state=' + state)
                .then((res) => res.json())
                .then((data) => {
                    var x = document.getElementById("lga");

                    var select = document.getElementById("lga");
                    var length = select.options.length;
                    for (i = length - 1; i >= 0; i--) {
                        select.options[i] = null;
                    }
                    for (let index = 0; index < Object.keys(data).length; index++) {
                        var option = document.createElement("option");
                        option.text = data[index];
                        option.value = data[index];
                        x.add(option);
                    }
                });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure the dropdown element exists
            const countryDropdown = document.getElementById('country');
            if (!countryDropdown) {
                console.error('Dropdown element with ID "country" not found.');
                return;
            }

            // Fetch countries from the API
            fetch('https://restcountries.com/v3.1/all')
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch countries: ' + response.statusText);
                    }
                    return response.json();
                })
                .then((data) => {
                    // Clear existing options (if any)
                    countryDropdown.innerHTML = '';

                    // Add a default option
                    const defaultOption = document.createElement('option');
                    defaultOption.text = 'Select Country';
                    defaultOption.value = '';
                    countryDropdown.add(defaultOption);

                    // Sort countries alphabetically by name
                    data.sort((a, b) => a.name.common.localeCompare(b.name.common));

                    // Populate the dropdown with country names
                    data.forEach((country) => {
                        const option = document.createElement('option');
                        option.text = country.name.common;
                        option.value = country.name.common;
                        countryDropdown.add(option);
                    });
                })
                .catch((error) => {
                    console.error('Error fetching countries:', error);
                    // Display a user-friendly error message
                    const errorMessage = document.createElement('div');
                    errorMessage.textContent = 'Failed to load countries. Please try again later.';
                    errorMessage.style.color = 'red';
                    countryDropdown.parentElement.appendChild(errorMessage);
                });
        });
    </script>
@endsection
