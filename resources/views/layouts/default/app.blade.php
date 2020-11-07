<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UMKM Digital') }} - @yield('title', 'Title')</title>

    <!-- Favicon -->
    <link href="{{ asset('favicon.ico') }}" rel="shortcut icon" type="image/ico">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('css/argon.min.css') }}" rel="stylesheet">

    <!-- Custom Stylesheets -->
    @stack('stylesheets')
</head>
<body class="@yield('body.className')">

    @section('simple')
        <!-- Navbar -->
        @include('layouts.default.navbar')

        <!-- Main content -->
        <div class="main-content">
            <!-- Header -->
            @yield('header')

            <!-- Page content -->
            @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts.default.footer')
    @show

    <!-- Modals -->
    @stack('modals')

    <!-- Core -->
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- JSCookie -->
    <script src="{{ asset('vendor/js-cookie/js.cookie.js') }}"></script>

    <!-- Custom Scripts -->
    @stack('scripts')

    <!-- Argon JS -->
    <script src="{{ asset('js/argon.min.js') }}"></script>
</body>
</html>
