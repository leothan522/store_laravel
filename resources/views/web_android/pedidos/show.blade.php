<div class="col-lg-12 col-md-8">
    <div class="row pb-3">
        <div class="container-fluid text-center" id="show_mensaje">

                <div class="row justify-content-center">
                    <div class="col-md-5">

                        @if($pedido->estatus == 1)
                            <div class="alert alert-info">
                                <h5><i class="fas fa-money-check-alt"></i> Verificando Pago!</h5>
                                Pedido en espera de la verificacion del pago.
                            </div>
                        @endif
                        @if($pedido->estatus == 2)
                            <div class="alert alert-info">
                                <h5><i class="fas fa-shipping-fast"></i> Pedido en ruta!</h5>
                                Pedido en proceso de despacho.
                            </div>
                        @endif
                        @if($pedido->estatus == 3)
                            <div class="alert alert-success">
                                <h5><i class="fas fa-check-circle"></i> Pedido Entregado!</h5>
                                Pedido procesado completamente.
                            </div>
                        @endif

                        @if($pedido->estatus == 4)
                            <div class="alert alert-danger">
                                <h5><i class="fas fa-exclamation-triangle"></i> Pago NO Validado!</h5>
                                Pedido pendiente por revision.
                            </div>
                        @endif






                    </div>
                </div>

        </div>

        <div class="container-fluid" id="show_pedido">
            <div class="row px-xl-5">
                <div class="col-lg-6">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pedido #: <strong class="text-danger" id="show_numero">{{ $pedido->numero }}</strong></span></h5>
                    @include('web_android.pedidos.productos')
                </div>
                <div class="col-lg-6">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pago</span></h5>
                    @include('web_android.pedidos.pago')
                </div>
                <div class="col-lg-6">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Dirección de Envio</span></h5>
                        @include('web_android.pedidos.facturacion')
                </div>
            </div>
        </div>

    </div>
</div>
