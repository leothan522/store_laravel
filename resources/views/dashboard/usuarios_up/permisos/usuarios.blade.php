<div class="card card-gray-dark @if($tabla != "parametros") collapsed-card @endif" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">Usuarios</h3>

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
                Ver Usuarios
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'usuarios.index')"
                           @if(leerJson($tabla_permisos, 'usuarios.index')) checked @endif
                           class="custom-control-input" id="customSwitch0" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitch0"></label>
                </div>
            </li>
            <li class="list-group-item">
                Crear Usuarios
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'usuarios.create')"
                           @if(leerJson($tabla_permisos, 'usuarios.create')) checked @endif
                           class="custom-control-input" id="customSwitch1" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitch1"></label>
                </div>
            </li>
            <li class="list-group-item">
                Editar Usuarios
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'usuarios.edit')"
                           @if(leerJson($tabla_permisos, 'usuarios.edit')) checked @endif
                           class="custom-control-input" id="customSwitch2" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitch2"></label>
                </div>
            </li>
            <li class="list-group-item">
                Reestablecer Contraseña
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'usuarios.update')"
                           @if(leerJson($tabla_permisos, 'usuarios.update')) checked @endif
                           class="custom-control-input" id="customSwitch3" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitch3"></label>
                </div>
            </li>
            <li class="list-group-item">
                Descargar Excel
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'usuarios.excel')"
                           @if(leerJson($tabla_permisos, 'usuarios.excel')) checked @endif
                           class="custom-control-input" id="customSwitch5" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitch5"></label>
                </div>
            </li>
            <li class="list-group-item">
                Descargar PDF
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'usuarios.pdf')"
                           @if(leerJson($tabla_permisos, 'usuarios.pdf')) checked @endif
                           class="custom-control-input" id="customSwitch7" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitch7"></label>
                </div>
            </li>
            <li class="list-group-item">
                Eliminar Usuarios
                <div class="custom-control custom-switch custom-switch-on-success float-right">
                    <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'usuarios.destroy')"
                           @if(leerJson($tabla_permisos, 'usuarios.destroy')) checked @endif
                           class="custom-control-input" id="customSwitch6" @if(is_null($tabla_id)) disabled @endif>
                    <label class="custom-control-label" for="customSwitch6"></label>
                </div>
            </li>
        </ul>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
