<div class="bg-light p-30 mb-5">
    <div class="border-bottom">
        <h6 class="mb-3">Productos</h6>
        <div>
            @foreach($listarCarrito as $carrito)
            <div class="d-flex justify-content-between">
                <p>
                    {{ $carrito->stock->producto->nombre }}
                    <small>(x{{ formatoMillares($carrito->cantidad, 0) }})</small>
                </p>
                <p>${{ formatoMillares($carrito->total, 2) }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="border-bottom pt-3 pb-2">


        <div class="d-flex justify-content-between mb-3">
            <h6>Subtotal</h6>
            <h6>
                <span>
                    ${{ formatoMillares($pedido->subtotal, 2) }}
                </span>
            </h6>
        </div>

        <div class="d-flex justify-content-between {{--mb-3--}}">
            <h6>I.V.A. ({{ calcularIVA(null, null, null, true) }}%)</h6>
            <h6>
                <span>
                    ${{ formatoMillares($pedido->iva, 2) }}
                </span>
            </h6>
        </div>

        @if($pedido->delivery > 0)
        <div class="d-flex justify-content-between mt-3">
            <h6>Delivery</h6>
            <h6>
                <span id="carrito_delivery">
                    ${{ formatoMillares($pedido->delivery, 2) }}
                </span>
            </h6>
        </div>
        @endif
    </div>
    <div class="pt-2">
        <div class="d-flex justify-content-between mt-2">
            <h5 class="text-danger"><strong>Total</strong></h5>
            <h5 class="text-danger"><strong>${{ formatoMillares($pedido->total, 2) }}</strong></h5>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <h5>Bs.</h5>
            <h5>
                <span>{{ formatoMillares($pedido->bs, 2) }} Bs.</span>
            </h5>
        </div>
    </div>
</div>
