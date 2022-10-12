@extends('layouts.multishop.master_android')

@section('title', 'Detalles')

@section('content')


    <!-- Breadcrumb Start -->
    @include('web_android.detalles.breadcrumb')
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    @include('web_android.detalles.details')
    <!-- Shop Detail End -->


    <!-- Products Start -->
    @include('web_android.detalles.products')
    <!-- Products End -->


@endsection


@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">
        console.log('Hi!');
    </script>

@endsection
