<div class="card card-gray-dark @if($tabla != "parametros") collapsed-card @endif"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">Almacen</h3>

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
                Ver Almacenes
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'almacen.index')"
                           @if(leerJson($tabla_permisos, 'almacen.index')) checked @endif
                           class="custom-control-input" id="customSwitchalmacen0" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchalmacen0"></label>
                </div>
            </li>
            <li class="list-group-item">
                [Crear|Editar] Almacenes
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'almacen.create')"
                           @if(leerJson($tabla_permisos, 'almacen.create')) checked @endif
                           class="custom-control-input" id="customSwitchalmacen1" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchalmacen1"></label>
                </div>
            </li>
            <li class="list-group-item">
                Borrar Almacenes
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'almacen.destroy')"
                           @if(leerJson($tabla_permisos, 'almacen.destroy')) checked @endif
                           class="custom-control-input" id="customSwitchalmacen3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchalmacen3"></label>
                </div>
            </li>
            {{--<li class="list-group-item">
                [Exportar|Excel] almacen
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'almacen.excel')"
                           @if(leerJson($tabla_permisos, 'almacen.excel')) checked @endif
                           class="custom-control-input" id="customSwitchalmacen4">
                    <label class="custom-control-label" for="customSwitchalmacen4"></label>
                </div>
            </li>--}}

        </ul>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
