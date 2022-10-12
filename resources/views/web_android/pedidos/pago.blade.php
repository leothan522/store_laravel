<div class="bg-light p-30 mb-3" id="pago_default_ped">
    <div class="form-group">
        <label>Metodo de Pago</label>
        <div class="input-group">
            <input type="text" class="form-control" value="{{ $pedido->metodo }}" placeholder="Número de referencia" id="pago_metodo" readonly>
        </div>
        <div class="input-group mt-3 d-none" id="pago_no_validado_efectivo">
            <span class="col-sm-12 text-sm text-bold text-danger">
                <i class="fa fa-exclamation-triangle"></i>
                ¡Pago NO Validado!
            </span>
        </div>
    </div>

    @if($pedido->comprobante_pago)
        <div class="form-group" id="mostrar_comprobante">
        <label>Comprobante</label>
        <div class="input-group">
            <input type="text" class="form-control" value="{{ $pedido->comprobante_pago }}" placeholder="Número de referencia" id="pago_referencia" readonly>
        </div>
        @if($pedido->estatus == 4)
        <div class="input-group mt-3" id="pago_no_validado">
            <span class="col-sm-12 text-sm text-bold text-danger">
                <i class="fa fa-exclamation-triangle"></i>
                ¡Su comprobante NO aparece en nuestro Libro Banco. Verifique!
            </span>
        </div>
        @endif
    </div>
    @endif
    @if($pedido->estatus == 4)
    <button class="btn btn-block btn-info font-weight-bold py-3 mt-4" id="btn_corregir">
        CORREGIR
    </button>
    @endif
    {{--<input type="hidden" id="ruta_app" value="{{ $ruta }}">--}}
</div>

<div class="bg-light p-30 d-none" id="pago_corregir_ped">
    <div class="form-group">
        <label>Metodo de Pago</label>
        <div class="input-group">
            <select id="pedido_metodo_corregir" class="form-control">
                <option value="">Seleccione Metodo</option>
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

    <div class="form-group d-none" id="div_comprobante">
        <label>Comprobante</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Número de referencia" id="checkout_comprobante" data-requerido="no">
            <span class="col-sm-12 text-sm text-bold text-danger d-none" id="alert_comprobante">
                <i class="fa fa-exclamation-triangle"></i>
                El campo comprobante es obligatorio.
            </span>
        </div>
    </div>
    <button class="btn btn-block btn-primary font-weight-bold py-3 mt-4"
            id="btn_metodo_corregir" data-id-pedido="{{ $pedido->id }}">
        GUARDAR
    </button>
    <input type="hidden" id="ruta_app" value="{{ $ruta }}">
</div>
