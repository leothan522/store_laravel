<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pedido #: <strong class="text-danger">{{ $pedido->numero }}</strong></span></h5>
            @include('web_up.checkout.pedido')
        </div>
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Dirección de Envio</span></h5>
            @include('web_up.checkout.facturacion')
        </div>
        <div class="col-lg-4 mb-5">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pago</span></h5>
            @include('web_up.checkout.pago')
        </div>
    </div>
</div>
