<div class="card card-gray-dark @if($tabla != "parametros") collapsed-card @endif"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">Tiendas</h3>

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
                Ver Tiendas
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'empresas.index')"
                           @if(leerJson($tabla_permisos, 'empresas.index')) checked @endif
                           class="custom-control-input" id="customSwitchEmpr0" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchEmpr0"></label>
                </div>
            </li>
            <li class="list-group-item">
                [Abrir|Cerrar] Tiendas
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'empresas.estatus')"
                           @if(leerJson($tabla_permisos, 'empresas.estatus')) checked @endif
                           class="custom-control-input" id="customSwitchEmpr0E" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchEmpr0E"></label>
                </div>
            </li>
            <li class="list-group-item">
                Definir Horarios
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'empresas.horario')"
                           @if(leerJson($tabla_permisos, 'empresas.horario')) checked @endif
                           class="custom-control-input" id="customSwitchEmpr0H" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchEmpr0H"></label>
                </div>
            </li>
            <li class="list-group-item">
                Crear Tiendas
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'empresas.create')"
                           @if(leerJson($tabla_permisos, 'empresas.create')) checked @endif
                           class="custom-control-input" id="customSwitchEmpr1" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchEmpr1"></label>
                </div>
            </li>
            <li class="list-group-item">
                Editar Tiendas
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'empresas.edit')"
                           @if(leerJson($tabla_permisos, 'empresas.edit')) checked @endif
                           class="custom-control-input" id="customSwitchEmpr2" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchEmpr2"></label>
                </div>
            </li>
            <li class="list-group-item">
                Borrar Tiendas
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'empresas.destroy')"
                           @if(leerJson($tabla_permisos, 'empresas.destroy')) checked @endif
                           class="custom-control-input" id="customSwitchEmpr3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitchEmpr3"></label>
                </div>
            </li>

        </ul>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
