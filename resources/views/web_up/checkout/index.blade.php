@extends('layouts.multishop.master')

@section('title', 'Carrito')

@section('content')


    <!-- Breadcrumb Start -->
        @include('web_up.checkout.breadcrumb')
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
        @include('web_up.checkout.checkout')
    <!-- Checkout End -->


@endsection


@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">
        console.log('Hi!');
    </script>

@endsection
