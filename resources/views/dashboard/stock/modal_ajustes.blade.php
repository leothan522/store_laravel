<div wire:ignore.self class="modal fade" id="modal-lg-ajustes" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content fondo">

            <div class="overlay-wrapper" wire:loading>
                <div class="overlay">
                    <i class="fas fa-2x fa-sync-alt"></i>
                </div>
            </div>

            <div class="modal-header">
                <h4 class="modal-title">Ajuste de {{ $ajuste }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{--<div wire:loading>
                    <div class="overlay">
                        <i class="fas fa-2x fa-sync-alt"></i>
                    </div>
                </div>--}}


                <div class="table-responsive bg-white mt-4">
                    <table class="table table-hover {{--table-hover bg-light--}}">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">&nbsp;</th>
                            <th scope="col">Producto</th>
                            <th scope="col" style="width: 20%" class="text-right">Cantidad</th>
                            <th scope="col" style="width: 5%;">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 0)
                        @foreach($listarAjustes as $item)
                            @php($i++)
                            <tr>
                                <td scope="col" class="text-center">
                                    <button class="btn btn-danger btn-xs" wire:click="destroyAjuste('{{ $item->id }}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td scope="col">{{ $item->stock->producto->nombre }}</td>
                                <td scope="col" class="text-right">
                                    @if($item->stock->producto->decimales)
                                        {{ formatoMillares($item->cantidad, 2) }}
                                        @else
                                        {{ formatoMillares($item->cantidad, 0) }}
                                    @endif

                                </td>
                                <td scope="col">
                                    <button class="btn btn-info btn-sm" wire:click="editAjuste({{ $item->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        @if($i < 1)
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table {{--table-hover bg-light--}}">

                        <tbody>
                        <form @if($icono == 'create') wire:submit.prevent="storeAjustes" @else wire:submit.prevent="updateAjuste({{ $ajuste_id }})" @endif>
                            <tr>
                                <td scope="col" class="text-center" style="width: 5%;">
                                    @if($icono == 'create')
                                        <i class="btn disabled fas fa-plus-square"></i>
                                        @else
                                        <button type="button" class="btn" wire:click="verAjuste('{{ $ajuste }}')">
                                            <i class="fas fa-plus-square text-success"></i>
                                        </button>

                                    @endif

                                </td>
                                <td scope="col">
                                    <div wire:ignore>
                                        {!! Form::select('stock', [], null, ['id' => 'select_ajustes', 'class' => 'custom-select select_ajustes', 'wire:model' => 'lista' , 'placeholder' => 'Seleccione Stock']); !!}
                                    </div>
                                    @error('lista')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                    <i class="icon fas fa-exclamation-triangle"></i>
                                    {{ $message }}
                                </span>
                                    @enderror
                                </td>
                                <td scope="col" style="width: 20%" >
                                    <input type="number" step="{{ $step }}" min="{{ $step }}" max="{{ $max }}" class="form-control" wire:model.defer="cantidad" placeholder="Cantidad">
                                    @error('cantidad')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </td>
                                <td scope="col" style="width: 5%;">
                                    @if($icono == 'create')
                                        <button type="submit"  class="btn btn-success">
                                            <i class="fas fa-plus-square"></i>
                                        </button>
                                        @else
                                        <button type="submit"  class="btn btn-info">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </form>
                        </tbody>
                    </table>

                </div>
            <div class="modal-footer justify-content-end">
                @if($i > 0)
                    @if($ajuste == 'Entrada')
                        <button type="button" class="btn btn-warning btn-sm" wire:click="totalizar">
                            <i class="fas fa-download"></i>
                            Totalizar Entrada
                        </button>
                    @else
                        <button type="button" class="btn btn-warning btn-sm" wire:click="totalizar">
                            <i class="fas fa-upload"></i> Totalizar Salida
                        </button>
                    @endif
                @endif
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
