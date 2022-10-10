<div class="col-lg-9 col-md-8">
    <div class="row pb-3">
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    {{--<button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                    <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>--}}
                </div>
                <div class="ml-2">
                    <span class="section-title position-relative mb-3">
                        <span class="bg-secondary pr-3" id="show_estatus">
                            Selecciona un Pedido
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="container-fluid text-center" id="show_mensaje">
            @if($pedido)
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="alert alert-info">
                            <h2><i class="fas fa-shopping-bag"></i> Pedido Relizado</h2>
                            <h1 class="mb-3">
                                <a href="#" class="text-danger btn_show_pedido" data-id="{{ $pedido->id }}" onclick="preSubmit()">
                                    # {{ $pedido->numero }}
                                </a>
                            </h1>
                            <h5><i class="fas fa-money-check-alt"></i> Verificando Pago!</h5>
                            Pedido en espera de la verificacion del pago.
                        </div>
                    </div>
                </div>
                @else
                Los detalles del pedido apareceran aqui...
            @endif
        </div>

        <div class="container-fluid d-none" id="show_pedido">
            <div class="row px-xl-5">
                <div class="col-lg-6">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Dirección de Envio</span></h5>
                        @include('web_up.pedidos.facturacion')
                    <div class="mb-5">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pago</span></h5>
                        @include('web_up.pedidos.pago')
                    </div>
                </div>

                <div class="col-lg-6">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pedido #: <strong class="text-danger" id="show_numero">{{--{{ $pedido->numero }}--}}</strong></span></h5>
                        @include('web_up.pedidos.pedido')
                </div>
            </div>
        </div>

        @include('web_up.pedidos.offer')

    </div>
</div>
