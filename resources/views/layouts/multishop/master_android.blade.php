<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>{{ ucwords(strtolower(config('app.name'))). ' | ' }} @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{--<meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">--}}

    <!-- Favicon -->
    <link href="{{ asset('favicons/favicon.ico') }}{{--img/favicon.ico--}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('vendor/multishop/lib/animate/animate.min.css') }}{{--lib/animate/animate.min.css--}}" rel="stylesheet">
    <link href="{{ asset('vendor/multishop/lib/owlcarousel/assets/owl.carousel.min.css') }}{{--lib/owlcarousel/assets/owl.carousel.min.css--}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('vendor/multishop/css/style.css') }}{{--css/style.css--}}" rel="stylesheet">

    @yield('css')
</head>

<body>

<!-- Topbar Start -->
    @include('web_android.topbar')
<!-- Topbar End -->


<!-- Navbar Start -->
    {{--@include('web_up.navbar')--}}
<!-- Navbar End -->

<!-- Content Start -->
    @yield('content')
<!-- Content End -->

<!-- Footer Start -->
    {{--@include('web_up.footer')--}}
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('vendor/multishop/lib/easing/easing.js') }}{{--lib/easing/easing.min.js--}}"></script>
<script src="{{ asset('vendor/ogani/js/owl.carousel.min.js') }}{{--lib/owlcarousel/owl.carousel.min.js--}}"></script>

<!-- Contact Javascript File -->
<script src="{{ asset('vendor/multishop/mail/jqBootstrapValidation.min.js') }}{{--mail/jqBootstrapValidation.min.js--}}"></script>
<script src="{{ asset('vendor/multishop/mail/contact.js') }}{{--mail/contact.js--}}"></script>

<!-- Template Javascript -->
<script src="{{ asset('vendor/multishop/js/main.js') }}{{--js/main.js--}}"></script>

<!-- Sweetalert2-->
<script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

<style type="text/css">
    .fondo-favoritos{
        /*background-color: rgb(127, 173, 57) !important;*/
        background-color: #343a40 !important;
        color: #FFD333 !important;
        /*border-color: rgb(127, 173, 57) !important;*/
    }

    .num_carrito {
        height: 13px;
        width: 13px;
        background: #7fad39;
        font-size: 10px;
        color: #ffffff;
        line-height: 13px;
        text-align: center;
        font-weight: 700;
        display: inline-block;
        border-radius: 50%;
        position: absolute;
        top: 0;
        right: -12px;
        padding: 10px 0 24px;
    }
</style>

@yield('js')
</body>

</html>
