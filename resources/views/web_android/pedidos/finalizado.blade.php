@extends('layouts.multishop.master_android')

@section('title', 'Pedidos')

@section('content')


    <!-- Breadcrumb Start -->
    @include('web_android.pedidos.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">

            <!-- Shop Product Start -->
        <div class="row justify-content-center px-xl-5">
                <div class="col-md-4 text-center">
                    <div class="alert alert-info">
                        <h2><i class="fas fa-shopping-bag"></i> Pedido Relizado</h2>
                        <h1 class="mb-3">
                            <a href="{{ route('android.pedidos', [auth()->id(), $pedido->id]) }}" class="text-danger" onclick="preSubmit()">
                                # {{ $pedido->numero }}
                            </a>
                        </h1>
                        <h5><i class="fas fa-money-check-alt"></i> Verificando Pago!</h5>
                        Pedido en espera de la verificacion del pago.
                    </div>
                </div>
        </div>

        @include('web_android.pedidos.offer')
        <!-- Shop Product End -->
        </div>

    <!-- Shop End -->



@endsection


@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">
        console.log('Hi!');
    </script>

@endsection
