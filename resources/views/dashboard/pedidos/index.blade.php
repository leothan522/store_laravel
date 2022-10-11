<div class="container-fluid" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-12">

            {{--<div class="overlay-wrapper" wire:loading>
                <div class="overlay">
                    <i class="fas fa-2x fa-sync-alt"></i>
                </div>
            </div>--}}


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row mb-3">
                    <div class="col-12">
                        <h3>
                            {{--<i class="fas fa-store-alt"></i> {{ $empresa_nombre }}
                            @if($multiple)
                                <small class="float-right">
                                    {!! Form::select('listarEmresa', $listarEmpresas, null , ['class' => 'custom-select', 'wire:model' => 'empresas']) !!}
                                </small>
                            @endif--}}
                        </h3>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-12 mb-3">


                        @if($busqueda)
                            <a href="{{ route('pedidos.index') }}" class="btn btn-default btn-sm">
                                <i class="fas fa-list"></i> Ver Todos
                            </a>
                            <span class="btn">Resultados de la Busqueda { <b class="text-danger">{{ $busqueda }} </b>}</span>
                        @endif

                        {{-- right--}}
                        {{--@if(leerJson(Auth::user()->permisos, 'stock.ajustes') || Auth::user()->role == 1 || Auth::user()->role == 100)
                            <button type="button" --}}{{--wire:click="verAjuste('Salida')"--}}{{--
                                    data-toggle="modal" data-target="#modal-lg-ajustes"
                                    class="btn btn-default btn-sm float-right" style="margin-right: 5px;">
                                <i class="fas fa-upload"></i> Salida
                            </button>
                            <button type="button" --}}{{--wire:click="verAjuste('Entrada')"--}}{{--
                                    data-toggle="modal" data-target="#modal-lg-ajustes"
                                    class="btn btn-default btn-sm float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Entrada
                            </button>
                        @else
                            <button type="button" class="btn btn-default btn-sm float-right disabled" style="margin-right: 5px;">
                                <i class="fas fa-upload"></i> Salida
                            </button>
                            <button type="button" class="btn btn-default btn-sm float-right disabled" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Entrada
                            </button>
                        @endif--}}
                            {{--<a href="{{ route('pedidos.excel') }}" class="btn btn-default btn-sm float-right text-success" >
                                <i class="fas fa-file-excel"></i> <i class="fas fa-download"></i>
                            </a>--}}
                            @if(!$listarPedidos->isEmpty())
                                @if(leerJson(Auth::user()->permisos, 'pedidos.excel') || Auth::user()->role == 1 || Auth::user()->role == 100)
                                    <button type="button" class="btn btn-default btn-sm float-right text-success" style="margin-right: 5px;"
                                            data-toggle="modal" data-target="#modal-lg-reportes-excel">
                                        <i class="fas fa-file-excel"></i> <i class="fas fa-download"></i>
                                    </button>
                                @endif
                            @endif
                        <button type="button" wire:click="limpiar"
                                class="btn btn-default btn-sm float-right" style="margin-right: 5px;">
                            <i class="fas fa-sync"></i> Actualizar
                        </button>
                    </div>
                </div>
                <!-- /.row -->

                @include('dashboard.pedidos.table')
                @include('dashboard.pedidos.modal')
                @include('dashboard.pedidos.modal_reportes')

            </div>
            <!-- /.invoice -->


        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
