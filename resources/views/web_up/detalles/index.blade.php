@extends('layouts.multishop.master')

@section('title', 'Detalles')

@section('content')

    <!-- Breadcrumb Start -->
        @include('web_up.detalles.breadcrumb')
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
        @include('web_up.detalles.details')
    <!-- Shop Detail End -->


    <!-- Products Start -->
        @include('web_up.detalles.products')
    <!-- Products End -->

@endsection

@section('js')

    @if(\Illuminate\Support\Facades\Route::currentRouteName() != "guest.detalles")
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
        console.log('Hi!')
    </script>

@endsection
