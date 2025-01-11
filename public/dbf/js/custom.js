// <!-- Initialize the input field with intl-tel-input -->

    // Initialize intl-tel-input
    var input = document.querySelector("#floatingPhone");
    var iti = window.intlTelInput(input, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        preferredCountries: ['ng', 'gb', 'us'], // Add preferred countries
        separateDialCode: true, // Show country dial code separately
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "e.g. " + selectedCountryPlaceholder; // Custom placeholder
        },
    });

    // Add validation on form submission
    document.querySelector('form').addEventListener('submit', function(event) {
        var phoneNumber = input.value;
        var isValid = iti.isValidNumber(); // Validate the phone number

        if (!isValid) {
            event.preventDefault(); // Prevent form submission
            document.getElementById('phoneError').style.display = 'block'; // Show error message
        } else {
            document.getElementById('phoneError').style.display = 'none'; // Hide error message
        }
    });
