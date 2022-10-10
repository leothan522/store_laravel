<div class="bg-light p-30 mb-5">
    <div class="border-bottom pb-2">

        <div class="d-flex justify-content-between mb-3">
            <h6>Subtotal</h6>
            <h6>
                <span id="carrito_subtotal" data-cantidad="{{ $subtotal }}">
                    $ {{ formatoMillares($subtotal, 2) }}
                </span>
            </h6>
        </div>

        <div class="d-flex justify-content-between {{--mb-3--}}">
            <h6>I.V.A. ({{ calcularIVA(null, null, null, true) }}%)</h6>
            <h6>
                <span id="carrito_iva" data-cantidad="{{ $iva }}">
                    $ {{ formatoMillares($iva, 2) }}
                </span>
            </h6>
        </div>

        <div class="@if(is_null($delivery_zona)) d-none @else d-flex @endif justify-content-between mt-3" id="li_delivery">
            <h6>Delivery</h6>
            <h6>
                <span id="carrito_delivery" data-cantidad="{{ $delivery_precio }}">
                    $ {{ formatoMillares($delivery_precio, 2) }}
                </span>
            </h6>
        </div>

        {{--<div class="d-flex justify-content-between">
            <h6 class="font-weight-medium">Shipping</h6>
            <h6 class="font-weight-medium">$10</h6>
        </div>--}}

    </div>
    <div class="pt-2">
        <div class="d-flex justify-content-between mt-2">
            <h5>Total</h5>
            <h5>
                <span id="carrito_total" data-cantidad="{{ $total }}">
                    $ {{ formatoMillares($total, 2) }}
                </span>
            </h5>
        </div>
        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3 btn_procesar_carrito"
                @if($listarCarrito->isNotEmpty()) data-estatus="lleno" @else data-estatus="vacio" @endif id="btn_procesar_carrito">
            Proceder al Pago
        </button>
        <input type="hidden" id="ruta_app" value="{{ $ruta }}">
    </div>
</div>
