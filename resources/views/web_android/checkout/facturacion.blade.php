<div class="bg-light p-30 mb-5">
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Cedula</label>
            <input class="form-control" type="text" placeholder="V99999999"
                   value="{{ $pedido->cedula }}" @if($pedido->cedula)
                   data-opcion="{{ $pedido->cliente_id }}" @else data-opcion="vacio" @endif id="checkout_cedula">
            <span class="col-sm-12 text-sm text-bold text-danger d-none" id="alert_cedula">
                <i class="fa fa-exclamation-triangle"></i>
                El campo cedula es obligatorio.
            </span>
        </div>
        <div class="col-md-6 form-group">
            <label>Nombre</label>
            <input class="form-control" type="text" placeholder="Nombre Apellido"
                   value="{{ $pedido->nombre }}" id="checkout_nombre">
            <span class="col-sm-12 text-sm text-bold text-danger d-none" id="alert_nombre">
                <i class="fa fa-exclamation-triangle"></i>
                El campo nombre es obligatorio.
            </span>
        </div>
        <div class="col-md-6 form-group">
            <label>E-mail</label>
            <input class="form-control" type="text" placeholder="example@email.com (opcional)"
                   value="{{ $pedido->email }}" id="checkout_email">
        </div>
        <div class="col-md-6 form-group">
            <label>Telefono</label>
            <input class="form-control" type="text" placeholder="0424 999 9999"
                   value="{{ $pedido->telefono }}" id="checkout_telefono">
            <span class="col-sm-12 text-sm text-bold text-danger d-none" id="alert_telefono">
                <i class="fa fa-exclamation-triangle"></i>
                El campo telefono es obligatorio.
            </span>
        </div>
        <div class="col-md-6 form-group">
            <label>Dirección Línea 1</label>
            <input class="form-control" type="text" placeholder="Número de la casa y nombre de la calle"
                   value="{{ $pedido->direccion_1 }}" id="checkout_direccion_1">
            <span class="col-sm-12 text-sm text-bold text-danger d-none" id="alert_direccion_1">
                <i class="fa fa-exclamation-triangle"></i>
                El campo direccion es obligatorio.
            </span>
        </div>
        <div class="col-md-6 form-group">
            <label>Dirección Línea 2</label>
            <input class="form-control" type="text" placeholder="Apartamento, habitación, etc. (opcional)"
                   value="{{ $pedido->direccion_2 }}" id="checkout_direccion_2">
        </div>
        {{--<div class="col-md-6 form-group">
            <label>Country</label>
            <select class="custom-select">
                <option selected>United States</option>
                <option>Afghanistan</option>
                <option>Albania</option>
                <option>Algeria</option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label>City</label>
            <input class="form-control" type="text" placeholder="New York">
        </div>
        <div class="col-md-6 form-group">
            <label>State</label>
            <input class="form-control" type="text" placeholder="New York">
        </div>
        <div class="col-md-6 form-group">
            <label>ZIP Code</label>
            <input class="form-control" type="text" placeholder="123">
        </div>
        <div class="col-md-12 form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="newaccount">
                <label class="custom-control-label" for="newaccount">Create an account</label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="shipto">
                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
            </div>
        </div>--}}
    </div>
</div>

<div class="row justify-content-center" id="checkout_label_cuentas">

    {{--<p class="text-center col-md-6">
        Banco: <strong class="text-bold text-dark text-xl-center">Venezuela</strong><br>
        # <strong class="text-bold text-dark text-xl-center">Venezuela</strong> <br>
        Cuenta: <strong class="text-bold text-dark text-xl-center">Corriente</strong><br>
        Titular: <strong class="text-bold text-dark text-xl-center">Corriente</strong><br>
        Rif: <strong class="text-bold text-dark text-xl-center">Corriente</strong><br>
    </p>--}}

</div>
