<div class="card card-gray-dark @if($tabla != "parametros") collapsed-card @endif"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">Pedidos</h3>

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
                Ver Pedidos
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'pedidos.index')"
                           @if(leerJson($tabla_permisos, 'pedidos.index')) checked @endif
                           class="custom-control-input" id="customSwitchPediso0" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchPediso0"></label>
                </div>
            </li>
            <li class="list-group-item">
                Validar Pagos
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'pedidos.validar_pago')"
                           @if(leerJson($tabla_permisos, 'pedidos.validar_pago')) checked @endif
                           class="custom-control-input" id="customSwitchPediso1" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchPediso1"></label>
                </div>
            </li>
            <li class="list-group-item">
                Procesar Despachos
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'pedidos.procedar_despacho')"
                           @if(leerJson($tabla_permisos, 'pedidos.procedar_despacho')) checked @endif
                           class="custom-control-input" id="customSwitchPediso3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchPediso3"></label>
                </div>
            </li>
            <li class="list-group-item">
                Imprimir Pedidos
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'pedidos.pdf')"
                           @if(leerJson($tabla_permisos, 'pedidos.pdf')) checked @endif
                           class="custom-control-input" id="customSwitchPedisoAs3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchPedisoAs3"></label>
                </div>
            </li>
            <li class="list-group-item">
                Reportes Excel
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'pedidos.excel')"
                           @if(leerJson($tabla_permisos, 'pedidos.excel')) checked @endif
                           class="custom-control-input" id="customSwitchPedisoEx4" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchPedisoEx4"></label>
                </div>
            </li>

        </ul>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
