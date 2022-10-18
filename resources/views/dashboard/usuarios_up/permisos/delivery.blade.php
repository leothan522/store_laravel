<div class="card card-gray-dark @if($tabla != "parametros") collapsed-card @endif"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">Delivery</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0" wire:ignore.self>

        <ul class="list-group text-sm">
            <li class="list-group-item">
                Ver Delivery
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'delivery.index')"
                           @if(leerJson($tabla_permisos, 'delivery.index')) checked @endif
                           class="custom-control-input" id="customSwitchDeliveryDeli0">
                    <label class="custom-control-label" for="customSwitchDeliveryDeli0"></label>
                </div>
            </li>
            <li class="list-group-item">
                Ver Zonas
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'zonas.show')"
                           @if(leerJson($tabla_permisos, 'zonas.show')) checked @endif
                           class="custom-control-input" id="customSwitchDeliveryZonas0" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchDeliveryZonas0"></label>
                </div>
            </li>
            <li class="list-group-item">
                [Crear|Editar] Zonas
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'zonas.create')"
                           @if(leerJson($tabla_permisos, 'zonas.create')) checked @endif
                           class="custom-control-input" id="customSwitchDeliveryZonas1" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchDeliveryZonas1"></label>
                </div>
            </li>
            <li class="list-group-item">
                Borrar Zonas
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'zonas.destroy')"
                           @if(leerJson($tabla_permisos, 'zonas.destroy')) checked @endif
                           class="custom-control-input" id="customSwitchDeliveryZonas3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchDeliveryZonas3"></label>
                </div>
            </li>
            <li class="list-group-item">
                Ver Mensajeros
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'mensajeros.show')"
                           @if(leerJson($tabla_permisos, 'mensajeros.show')) checked @endif
                           class="custom-control-input" id="customSwitchDeliverymensajeros0" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchDeliverymensajeros0"></label>
                </div>
            </li>
            <li class="list-group-item">
                [Crear|Editar] Mensajeros
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'mensajeros.create')"
                           @if(leerJson($tabla_permisos, 'mensajeros.create')) checked @endif
                           class="custom-control-input" id="customSwitchDeliverymensajeros1" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchDeliverymensajeros1"></label>
                </div>
            </li>
            <li class="list-group-item">
                Borrar Mensajeros
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'mensajeros.destroy')"
                           @if(leerJson($tabla_permisos, 'mensajeros.destroy')) checked @endif
                           class="custom-control-input" id="customSwitchDeliverymensajeros3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchDeliverymensajeros3"></label>
                </div>
            </li>
            {{--<li class="list-group-item">
                [Exportar|Excel] productos
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'productos.excel')"
                           @if(leerJson($tabla_permisos, 'productos.excel')) checked @endif
                           class="custom-control-input" id="customSwitchDeliverymensajeros4">
                    <label class="custom-control-label" for="customSwitchDeliverymensajerosmensajeros4"></label>
                </div>
            </li>--}}

        </ul>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
