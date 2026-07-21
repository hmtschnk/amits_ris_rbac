<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/img/nr_logo.png') }}">
    <title>
        NR RIS
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/fontawesome-min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anynomous" referrerpolicy="no-referrer" /> 
    <!--<script src="https://kit.fontawesome.com/a81368914c.js" crossorigin="anonymous"></script> -->
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{  asset('assets/css/argon-dashboard.css')}}" rel="stylesheet" />
    <link href="{{  asset('assets/css/custom.css')}}" rel="stylesheet" />
    <link href="{{  asset('assets/css/daterangepicker.css')}}" rel="stylesheet" />
    <link href="{{  asset('assets/css/select2/select2.min.css')}}" rel="stylesheet" />
    <script src="https://util.amits4u.com/nrris-assistant.js" defer></script>
</head>

<body class="{{ $class ?? '' }}">

    @guest
        @yield('content')
    @endguest

    @auth
        {{-- @if (in_array(request()->route()->getName(), ['login', 'sign-in-static', 'sign-up-static', 'register', 'recover-password', 'rtl', 'virtual-reality'])) --}}
        @if (in_array(request()->route()->getName(), ['login', 'auth.login']))
            @yield('content')
        @else
            @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
                <div class="min-height-300 bg-primary position-absolute w-100"></div>
            @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
                <div class="position-absolute w-100 min-height-300 top-0 bg-primary">
                    <span class="mask bg-primary opacity-6"></span>
                </div>
            @endif
            @include('layouts.navbars.auth.sidenav') 
                <main class="main-content border-radius-lg">
                    @if (auth()->user()->status == 'TESTING')
                        <div class="d-flex justify-content-center container position-sticky z-index-sticky top-0">
                            <nav
                                class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2">
                                <div class="container-fluid">
                                    <p class="navbar-nav mx-auto navbar-brand font-weight-bolder ms-lg-0 ms-3 text-center">
                                        You are in testing mode.
                                    </p>
                                </div>
                            </nav>
                        </div>
                    @endif
                     @yield('content') 
                </main>
        @endif
    @endauth

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate-1.19.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment-2.29.4.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker-3.1.0.min.js') }}"></script>

    @stack('js')

    @yield('script')
</body>

</html>
