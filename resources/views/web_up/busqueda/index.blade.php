@extends('layouts.multishop.master')

@section('title', 'Busqueda')

@section('content')

    <!-- Breadcrumb Start -->
        @include('web_up.busqueda.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
            @include('web_up.busqueda.sidebar')
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
            @include('web_up.busqueda.show')
        <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

@endsection

@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script>
        console.log('Hi!');
    </script>

@endsection
