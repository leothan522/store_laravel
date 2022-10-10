<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            @include('web_up.carrito.table')
        </div>
        <div class="col-lg-4">

            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Delivery</span></h5>
            @include('web_up.carrito.delivery')

            <h5 class="section-title position-relative text-uppercase mb-3 mt-4"><span class="bg-secondary pr-3">Resumen de la compra</span></h5>
            @include('web_up.carrito.resumen')

        </div>
    </div>
</div>
