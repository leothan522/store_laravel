@extends('layouts.multishop.master')

@section('title', 'Pedidos')

@section('content')

    <!-- Breadcrumb Start -->
    @include('web_up.favoritos.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
        @include('web_up.favoritos.sidebar')
        <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
        @include('web_up.favoritos.show')
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
