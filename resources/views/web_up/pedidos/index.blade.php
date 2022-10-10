@extends('layouts.multishop.master')

@section('title', 'Pedidos')

@section('content')

    <!-- Breadcrumb Start -->
    @include('web_up.pedidos.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
        @include('web_up.pedidos.sidebar')
        <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
        @include('web_up.pedidos.show')
        <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

@endsection

@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">

        $("#btn_corregir").click(function(e) {
            e.preventDefault();
            Cargando.fire();
            document.getElementById('pago_default_ped').classList.add('d-none');
            document.getElementById('pago_corregir_ped').classList.remove('d-none');
            Toast.fire({
                icon: 'success',
                title: 'Corregir Habilitado.',
            });
        });

        console.log('Hi!');
    </script>

@endsection
