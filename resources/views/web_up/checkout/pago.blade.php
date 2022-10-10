<div class="bg-light p-30">
    <div class="form-group">
        <label>Metodo de Pago</label>
        <div class="input-group">
            <select id="checkout_metodo" class="form-control">
                @if(!$pedido->metodo_pago)
                    <option value="">Seleccione Metodo</option>
                @else
                    <option value="{{ $pedido->metodo_pago }}">{{ $pedido->revisar }}</option>
                @endif
                @foreach($listarMetodos as $parametro)
                    <option value="{{ $parametro->id }}">{{ $parametro->metodo }}</option>
                @endforeach
            </select>
            <span class="col-sm-12 text-sm text-bold text-danger d-none" id="alert_metodo">
                <i class="fa fa-exclamation-triangle"></i>
                El campo Metodo es obligatorio.
            </span>
        </div>
    </div>

    <div class="form-group @if(!$pedido->metodo_pago) d-none @endif" id="div_comprobante">
        <label>Comprobante</label>
        @if($pedido->metodo_pago)
            <div class="input-group">
            <span class="col-sm-12 text-sm text-bold text-danger">
                <i class="fa fa-exclamation-triangle"></i>
                Su comprobante NO aparece en nuestro Libro Banco. Verifique!
            </span>
            </div>
        @endif
        <div class="input-group mb-3">
            <input type="text" class="form-control" value="{{ $pedido->comprobante_pago }}" placeholder="Número de referencia" id="checkout_comprobante" data-requerido="no">
            <span class="col-sm-12 text-sm text-bold text-danger d-none" id="alert_comprobante">
                <i class="fa fa-exclamation-triangle"></i>
                El campo comprobante es obligatorio.
            </span>
        </div>
    </div>

    {{--<div class="form-group">
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="payment" id="paypal">
            <label class="custom-control-label" for="paypal">Paypal</label>
        </div>
    </div>
    <div class="form-group">
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="payment" id="directcheck">
            <label class="custom-control-label" for="directcheck">Direct Check</label>
        </div>
    </div>
    <div class="form-group mb-4">
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
            <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
        </div>
    </div>--}}
    <button class="btn btn-block btn-primary font-weight-bold py-3 mt-4"
            id="btn_procesar_pedido" data-id-pedido="{{ $pedido->id }}">
        PROCESAR PEDIDO
    </button>
    <input type="hidden" id="ruta_app" value="{{ $ruta }}">
</div>
