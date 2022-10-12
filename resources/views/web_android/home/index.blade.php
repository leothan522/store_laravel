@extends('layouts.multishop.master_android')

@section('title', 'Inicio')

@section('content')

    @include('web_android.home.busqueda')

    <!-- Offer Start -->
    @include('web_android.home.offer')
    <!-- Offer End -->

    <!-- Products Start -->
    @include('web_android.home.products')
    <!-- Products End -->

    <!-- Recent Products Start -->
    @include('web_android.home.recent')
    <!-- Products End -->

    <!-- Vendor Start -->
    @include('web_android.home.vendor')
    <!-- Vendor End -->

@endsection


@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">
        console.log('Hi!');
    </script>

@endsection
