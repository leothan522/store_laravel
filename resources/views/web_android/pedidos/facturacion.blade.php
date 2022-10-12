<div class="bg-light p-30 mb-5">
    <div class="row">
        <div class="col-md-12 form-group">
            <label>Cedula</label>
            <input class="form-control" type="text" value="{{ $pedido->cedula }}" placeholder="V99999999" id="fact_cedula" readonly>
        </div>
        <div class="col-md-12 form-group">
            <label>Nombre</label>
            <input class="form-control" type="text" value="{{ $pedido->nombre }}" placeholder="Nombre Apellido" id="fact_nombre" readonly>
        </div>
        @if($pedido->email)
        <div class="col-md-12 form-group">
            <label>E-mail</label>
            <input class="form-control" type="text" value="{{ $pedido->email }}" placeholder="example@email.com (opcional)" id="fact_email" readonly>
        </div>
        @endif
        <div class="col-md-12 form-group">
            <label>Telefono</label>
            <input class="form-control" type="text" value="{{ $pedido->telefono }}" placeholder="0424 999 9999" id="fact_telefono" readonly>
        </div>
        <div class="col-md-12 form-group">
            <label>Dirección Línea 1</label>
            <input class="form-control" type="text" value="{{ $pedido->direccion_1 }}" placeholder="Número de la casa y nombre de la calle" id="fact_direccion_1" readonly>
        </div>
        @if($pedido->direccion_2)
        <div class="col-md-12 form-group">
            <label>Dirección Línea 2</label>
            <input class="form-control" type="text" value="{{ $pedido->direccion_2 }}" placeholder="Apartamento, habitación, etc. (opcional)" id="fact_direccion_2" readonly>
        </div>
        @endif
    </div>
</div>
