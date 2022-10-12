@extends('layouts.multishop.master_android')

@section('title', 'Pedidos')

@section('content')


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('android.pedidos', auth()->id()) }}" onclick="preSubmit()">Tus Pedidos</a>
                    {{--<a class="breadcrumb-item text-dark" href="{{ route('web.carrito') }}" onclick="preSubmit()">{{ $modulo }}</a>--}}
                    <span class="breadcrumb-item active">Detalles del Pedido</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Product Start -->
                @include('web_android.pedidos.show')
                @include('web_android.pedidos.offer')
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
