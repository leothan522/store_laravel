<div wire:ignore.self class="modal fade" id="modal-lg-permisos" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content fondo">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if($tabla == "parametros")
                        Rol de usuario: <span class="text-bold">{{ $tabla_nombre }}</span>
                        @else
                        Permisos de Usuario: <span class="text-bold">{{ $tabla_nombre }}</span>
                    @endif

                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.usuarios')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.empresas')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.delivery')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.categorias')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.productos')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.almacen')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.metodos')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.stock')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.pedidos')
                    </div>
                    <div class="col-md-4">
                        @include('dashboard.usuarios_up.permisos.clientes')
                    </div>
                </div>


            </div>
            <div class="modal-footer justify-content-end">
                @if(!is_null($tabla_id) && $tabla == "parametros")
                    <button type="button" class="btn btn-danger btn-sm" wire:click="destroyRol({{ $tabla_id }})"><i class="fas fa-trash-alt"></i></button>
                    <form wire:submit.prevent="updateRol">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="nombre" wire:model.defer="tabla_nombre">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-info btn-flat">
                                    <i class="fas fa-save"></i>
                                </button>
                              </span>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary btn-sm" wire:click="updateRolUsuarios">Actualizar Usuarios</button>
                @endif
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" wire:click="limpiar">{{ __('Close') }}</button>
            </div>

            <div class="overlay-wrapper" wire:loading>
                <div class="overlay">
                    <i class="fas fa-2x fa-sync-alt"></i>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
