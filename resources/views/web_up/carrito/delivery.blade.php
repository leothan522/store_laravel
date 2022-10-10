{{--<form class="mb-30" action="">
    <div class="input-group">
        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
        <div class="input-group-append">
            <button class="btn btn-primary">Apply Coupon</button>
        </div>
    </div>
</form>--}}

<div class="col-lg-12 text-right" id="boton_incluir_del">
    @if($listarCarrito->isNotEmpty())
        <button class="btn btn-sm btn-info btn-delivery" data-accion="remover" id="btn_delivery">
            NO INCLUIR DELIVERY
        </button>
    @endif
</div>

<div class="col-lg-12 mt-3" id="lista_zonas">
    @if($listarCarrito->isNotEmpty())
        <input type="hidden" id="estatus_zona" value="activo">
        {{--<h5>ZONA PARAE EL ENVIO</h5>--}}
        <form action="#">
            <select class="select-zonas" id="select_zo" data-estatus="activo">
                @if(!is_null($delivery_zona))
                    <option value="{{ $delivery_zona }}">{{ $delivery_nombre }}</option>
                @else
                    <option value="vacia">Seleccione la zona para el envio</option>
                @endif
                @foreach($listarZonas as $zona)
                    @if($zona->id == $delivery_zona) @continue @endif
                    <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                @endforeach
            </select>
        </form>
        @else
        <input type="hidden" id="estatus_zona" value="inactivo">
    @endif
</div>
