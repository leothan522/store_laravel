<div class="card card-gray-dark @if($tabla != "parametros") collapsed-card @endif"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">Stock</h3>

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
                Ver Stock
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'stock.index')"
                           @if(leerJson($tabla_permisos, 'stock.index')) checked @endif
                           class="custom-control-input" id="customSwitchstock0" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchstock0"></label>
                </div>
            </li>
            <li class="list-group-item">
                [Crear|Editar] Stock
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'stock.create')"
                           @if(leerJson($tabla_permisos, 'stock.create')) checked @endif
                           class="custom-control-input" id="customSwitchstock1" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchstock1"></label>
                </div>
            </li>
            <li class="list-group-item">
                Borrar Stock
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'stock.destroy')"
                           @if(leerJson($tabla_permisos, 'stock.destroy')) checked @endif
                           class="custom-control-input" id="customSwitchstock3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchstock3"></label>
                </div>
            </li>
            <li class="list-group-item">
                [Entrada|Salida] Stock
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'stock.ajustes')"
                           @if(leerJson($tabla_permisos, 'stock.ajustes')) checked @endif
                           class="custom-control-input" id="customSwitchstockAs3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchstockAs3"></label>
                </div>
            </li>
            {{--<li class="list-group-item">
                [Exportar|Excel] stock
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'stock.excel')"
                           @if(leerJson($tabla_permisos, 'stock.excel')) checked @endif
                           class="custom-control-input" id="customSwitchstock4">
                    <label class="custom-control-label" for="customSwitchstock4"></label>
                </div>
            </li>--}}

        </ul>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
