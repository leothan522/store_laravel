@extends('layouts.multishop.master_android')

@section('title', 'Carrito')

@section('content')


    <!-- Breadcrumb Start -->
    @include('web_android.carrito.breadcrumb')
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    @include('web_android.carrito.cart')
    <!-- Cart End -->


@endsection


@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">
        console.log('Hi!');
    </script>

@endsection
