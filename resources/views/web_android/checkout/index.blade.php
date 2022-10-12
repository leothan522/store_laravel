@extends('layouts.multishop.master_android')

@section('title', 'Checkout')

@section('content')


    <!-- Breadcrumb Start -->
    @include('web_android.checkout.breadcrumb')
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    @include('web_android.checkout.checkout')
    <!-- Checkout End -->


@endsection


@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">
        console.log('Hi!');
    </script>

@endsection
