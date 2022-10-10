@extends('layouts.multishop.master')

@section('title', 'Carrito')

@section('content')

    <!-- Breadcrumb Start -->
        @include('web_up.carrito.breadcrumb')
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
        @include('web_up.carrito.cart')
    <!-- Cart End -->


@endsection


@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script>
        console.log('Hi!');
    </script>

@endsection
