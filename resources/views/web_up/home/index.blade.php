@extends('layouts.multishop.master')

@section('title', 'Inicio')

@section('content')

    <!-- Carousel Start -->
        @include('web_up.home.carousel')
    <!-- Carousel End -->


    <!-- Featured Start -->
        @include('web_up.home.featured')
    <!-- Featured End -->


    <!-- Categories Start -->
        @include('web_up.home.categories')
    <!-- Categories End -->


    <!-- Products Start -->
        @include('web_up.home.products')
    <!-- Products End -->


    <!-- Offer Start -->
        @include('web_up.home.offer')
    <!-- Offer End -->


    <!-- Recent Products Start -->
        @include('web_up.home.recent')
    <!-- Products End -->


    <!-- Vendor Start -->
        @include('web_up.home.vendor')
    <!-- Vendor End -->

@endsection

@section('js')

    @if(\Illuminate\Support\Facades\Route::currentRouteName() != "web.index")
            @include('web_up.funciones_ajax')
        @else
        <script type="text/javascript">
            const Cargando = Swal.mixin({
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
                showConfirmButton: false,
                width: '100',
            });
            function preSubmit(){
                Cargando.fire();
            }
        </script>
    @endif
    @include('web_up.funciones_android')

    <script type="text/javascript">
        console.log('Hi!');
    </script>

@endsection
