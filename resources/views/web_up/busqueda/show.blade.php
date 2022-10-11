<div class="col-lg-9 col-md-8">
    <div class="row pb-3">
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    {{--<button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                    <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>--}}
                </div>
                <div class="ml-2">
                    <span class="section-title position-relative mb-3">
                        <span class="bg-secondary pr-3" id="show_estatus">
                            Resultados para "<strong class="text-danger">{{ $modulo }}</strong>"
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="container-fluid text-center">

            @if($listarProductos->isNotEmpty())
                <div class="container-fluid">
                    {{--<h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categorias</span></h2>--}}
                    <div class="row {{--px-xl-5 pb-3--}}">

                        @foreach($listarProductos as $producto)
                            @foreach($producto->stock as $stock)
                            <div class="col-lg-4 col-md-4 col-sm-6 pb-1">
                                <a class="text-decoration-none" onclick="preSubmit()" href="{{ route('web.detalles', $stock->id) }}">
                                    <div class="cat-item d-flex align-items-center mb-4">
                                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                            <img class="img-fluid" src="{{ asset(verImg($stock->producto->miniatura)) }}{{--img/cat-1.jpg--}}" alt="">
                                            {{--<img class="img-fluid" src="{{ asset('vendor/multishop/img/cat-1.jpg') }}--}}{{--img/cat-1.jpg--}}{{--" alt="">--}}
                                        </div>
                                        <div class="flex-fill pl-1 pr-1">
                                            <h6>{{ $stock->producto->nombre }}</h6>
                                            <small class="text-body"><span>$ {{ calcularPrecio($stock->producto->id, $stock->pvp) }}</span></small>
                                            @if($stock->estatus == 0 || $stock->stock_disponible <= 0)
                                                <small class="text-danger"><strong>(Agotado)</strong></small>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        @endforeach

                    </div>
                </div>

                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            {{ $listarProductos->links() }}
                        </ul>
                        {{--<ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>--}}

                    </nav>
                </div>

            @else
                Sin resultados para la busqueda &nbsp; <strong class="text-bold"> { <span class="text-danger">{{ $modulo }}</span> }</strong>
            @endif


        </div>

    </div>
</div>

@include('web_up.busqueda.offer')
