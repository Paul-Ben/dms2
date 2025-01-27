<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BNSGDMS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('dashboard/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('dbf/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dbf/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('dbf/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('dbf/css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <style>
        .iti {
            width: 100%;
            /* Ensure it takes full width */
            height: 100%;

        }

        .iti__flag-container {
            margin-right: 10px;
            /* Adjust spacing */
        }

        .iti__selected-flag {
            padding: 0 20px;
            /* Adjust padding */
        }

        .iti__arrow {
            border-top-color: #000;
            /* Match arrow color */
        }

        .iti__country-list {
            border-radius: 4px;
            /* Match border radius */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Add shadow */
        }
    </style>

    <!---- ReCaptcha ------>
    {!! htmlScriptTagJsApi() !!}

</head>

<body>
    <div>
        @yield('content')
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('dbf/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('dbf/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
     <!-- Include the intl-tel-input library -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
     <script src="{{ asset('dbf/js/custom.js') }}"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':

                    toastr.options.timeOut = 10000;
                    toastr.options.closeButton = true;
                    toastr.options.progressBar = true;
                    toastr.info("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();
                    break;
                case 'success':

                    toastr.options.timeOut = 10000;
                    toastr.options.closeButton = true;
                    toastr.options.progressBar = true;
                    toastr.success("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'warning':

                    toastr.options.timeOut = 10000;
                    toastr.options.closeButton = true;
                    toastr.options.progressBar = true;
                    toastr.warning("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'error':

                    toastr.options.timeOut = 10000;
                    toastr.options.closeButton = true;
                    toastr.options.progressBar = true;
                    toastr.error("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
            }
        @endif
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
</body>

</html>
