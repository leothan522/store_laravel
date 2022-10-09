@extends('layouts.multishop.master')

@section('title', 'Categoria')

@section('content')

    <!-- Breadcrumb Start -->
        @include('web_up.categorias.breadcrumb')
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
                @include('web_up.categorias.sidebar')
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
                @include('web_up.categorias.product')
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

@endsection

@section('js')

    @if(\Illuminate\Support\Facades\Route::currentRouteName() != "guest.categorias")
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

