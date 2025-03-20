<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BENGEDMS - Reset Password</title>
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

<body class="pb-16">
    
    <div class="container-fluid pt-4 px-4 ">
        <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0 ">
            <div class="col-md-6 text-center p-8 border border-primary p-3 rounded shadow">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-lock-fill display-1 text-primary" viewBox="0 0 16 16">
                    <!-- Lock Body -->
                    <rect x="4" y="7" width="8" height="7" rx="1" ry="1" fill="currentColor" />
                    <!-- Lock Shackle -->
                    <path d="M4.5 7V4a3.5 3.5 0 0 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1z" fill="currentColor" />
                  </svg>                  
                {{-- <i class="bi bi-envelope-arrow-up-fill display-1 text-primary"></i> --}}
                <h4 class=" fw-bold mt-2">Password Reset</h4>
                @if (session('status'))
                <div class="mb-4 font-medium text-sm text-success">
                    {{ 'A reset password link has been sent to the provided email address' }}
                </div>
                  @endif
                  @if ($errors->any())
                        <div class="mb-4 font-medium text-sm text-danger">
                            @foreach ($errors->all() as $error)
                              <span>  {{ $error }} <span>
                            @endforeach
                        </div>
                    @endif
                  <div >
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="col-sm-12 col-xl-12 mb-3">
                                  <input type="text" name="email" class="form-control" value="{{ old('email', $request->email) }}" placeholder="Enter Email..."  required>
                            </div>
                            <div class="col-sm-12 col-xl-12 mb-3">
                                <input type="password" name="password" class="form-control"  placeholder="Enter Password..."  required>
                          </div>
                          <div class="col-sm-12 col-xl-12 mb-3">
                            <input type="password" name="password_confirmation" class="form-control"  placeholder="Enter Confirm Password..."  required>
                      </div>
                        </div>
                        <div style="text-align: center;">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                </div>
                
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
