<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BNSGDMS - Verify Email</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset('dashboard/img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('dbf/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{asset('dbf/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('dbf/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('dbf/css/style.css') }}" rel="stylesheet">
</head>

<body>
    
    <div class="container-fluid pt-4 px-4">
        <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
            <div class="col-md-6 text-center p-4">
                <i class="bi bi-envelope display-1 text-primary"></i>
                <h4 class=" fw-bold">Verification Email Sent!</h4>
                <p class="mb-4">
                    Thanks for signing up for E-Filling System. Before getting started, could you verify your email address
                    by clicking on the link we just emailed to you? If you didn't receive the email, we 
                    will gladly send you another.
                </p>
                <a class="btn btn-primary  py-3 px-5" href="">Resend Verification Link</a>
                <a class="btn btn-danger  py-3 px-5" href="">Logout</a>
            </div>
        </div>
    </div>
         
    <!-- JavaScript Libraries -->
    <script src="{{ asset('dbf/https://code.jquery.com/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('dbf/https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('dbf/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('dbf/js/main.js') }}"></script>
</body>

</html>