<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BSGIDMS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('dbf/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('dbf/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('dbf/css/custom.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <style>
        .image-container {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            border: 3px solid #ddd;
        }
    
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            transition: opacity 0.3s ease-in-out;
        }
    
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
    
        .image-container:hover .overlay {
            opacity: 1;
        }
    
        .file-input {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                {{-- <a href="/" class="navbar-brand mx-4 mb-3">
                    <img src="{{ asset('assets/demo-data/Logo1.png') }}" alt="logo"
                        style="width: 80px; height: 80px;">
                </a> --}}
                <a href="/" class="navbar-brand mx-4 mb-3 d-flex align-items-center">
                    <img src="{{ asset('assets/demo-data/Logo1.png') }}" alt="logo" style="width: 80px; height: 80px;">
                    <div class="ms-3">
                        <h5 class="mb-0" style="font-weight: bold;">BSGIDMS </h5>
                        <small class="text-muted"> Doc Mgt</small>
                    </div>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{ Auth::user()->userDetail->avatar }}" alt=""
                            style="width: 40px; height: 40px;">
                        {{-- {{ asset('dbf/img/user.jpg') }} --}}
                        <div
                            class="bg-success rounded-circle border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->userDetail->designation }}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{ route('dashboard') }}"
                        class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i
                            class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="{{ route('document.index') }}"
                        class="nav-item nav-link {{ request()->routeIs('document.index', 'document.create') ? 'active' : '' }}"><i
                            class="fa fa-th me-2"></i>Documents</a>
                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ request()->routeIs('document.received', 'document.sent') ? 'active' : '' }}"
                            data-bs-toggle="dropdown"><i class="fa fa-file me-2"></i>File Movement</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{ route('document.received') }}" class="dropdown-item"><i
                                    class="fa fa-inbox"></i>Incoming Mails </a>
                            <a href="{{ route('document.sent') }}" class="dropdown-item"><i
                                    class="fa fa-paper-plane"></i>Outgoing Mails</a>
                        </div>
                    </div>

                    @role('Admin')
                    {{-- <a href="{{ route('users.index') }}"
                            class="nav-item nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"><i
                                class="fa fa-user-circle me-2"></i>Pending Incoming</a> --}}
                        <a href="{{ route('users.index') }}"
                            class="nav-item nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"><i
                                class="fa fa-user-circle me-2"></i>Manage User</a>
                        <a href="{{ route('department.index') }}" class="nav-item nav-link"><i
                                class="fa fa-file me-2"></i>Departments
                        </a>
                    @endrole
                    @role('superadmin')
                        <a href="{{ route('users.index') }}"
                            class="nav-item nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"><i
                                class="fa fa-user-circle me-2"></i>Manage User</a>

                        <div class="nav-item dropdown">
                            <a href="#"
                                class="nav-link dropdown-toggle {{ request()->routeIs('organisation.index', 'organisation.create') ? 'active' : '' }}"
                                data-bs-toggle="dropdown"><i class="fa fa-building me-2"></i>MDA Manager</a>
                            <div class="dropdown-menu bg-transparent border-0">
                                <a href="{{ route('organisation.index') }}" class="nav-item nav-link"><i
                                        class="fa fa-building me-2"></i>Organisations</a>
                                <a href="{{ route('department.index') }}" class="dropdown-item"><i
                                        class="fa fa-file me-2"></i>Departments
                                </a>
                            </div>
                        </div>
                    @endrole
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                {{-- <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a> --}}
                <a href="/" class="navbar-brand d-flex d-lg-none me-4">
                    <img src="{{ asset('assets/demo-data/Logo1.png') }}" alt="logo" style="width: 80px; height: 80px;">
                    <div class="ms-3">
                        <h5 class="mb-0" style="font-weight: bold;">BSGIDMS</h5>
                        <small class="text-muted">Doc Mgt</small>
                    </div>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt=""
                                        style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div> --}}
                    {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div> --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="{{ Auth::user()->userDetail->avatar }}"
                                alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </div> 
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            @yield('content')


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Government of Benue State</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Powered By <a href="#">BDIC</a>
                            </br>
                            {{-- Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

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
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
    <!-- Template Javascript -->
    <script src="{{ asset('dbf/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
</body>

</html>
