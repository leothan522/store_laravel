<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Dirección de Envio</span></h5>
            @include('web_android.checkout.facturacion')
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pedido #: <strong class="text-danger">{{ $pedido->numero }}</strong></span></h5>
            @include('web_android.checkout.pedido')
        </div>
        <div class="row col-lg-12 justify-content-center" id="checkout_label_cuentas">

            {{--<p class="text-center col-md-6">
                Banco: <strong class="text-bold text-dark text-xl-center">Venezuela</strong><br>
                # <strong class="text-bold text-dark text-xl-center">Venezuela</strong> <br>
                Cuenta: <strong class="text-bold text-dark text-xl-center">Corriente</strong><br>
                Titular: <strong class="text-bold text-dark text-xl-center">Corriente</strong><br>
                Rif: <strong class="text-bold text-dark text-xl-center">Corriente</strong><br>
            </p>--}}

        </div>
        <div class="col-lg-4 mb-5">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Pago</span></h5>
            @include('web_android.checkout.pago')
        </div>
    </div>
</div>
