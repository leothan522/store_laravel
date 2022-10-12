<div class="col-lg-12 col-md-8">
    <div class="row pb-3">
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    {{--<button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                    <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>--}}
                </div>
                <div class="ml-2">
                    <span class="section-title position-relative mb-3">
                        <span class="bg-secondary pr-3">
                            {{ $listarProductos->sum('cantidad') }} Productos Disponibles
                        </span>
                    </span>
                    {{--<div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Latest</a>
                            <a class="dropdown-item" href="#">Popularity</a>
                            <a class="dropdown-item" href="#">Best Rating</a>
                        </div>
                    </div>
                    <div class="btn-group ml-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">10</a>
                            <a class="dropdown-item" href="#">20</a>
                            <a class="dropdown-item" href="#">30</a>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>

        @if($listarProductos->isNotEmpty())

            @foreach($listarProductos as $producto)
                @foreach($producto->stock as $stock)
                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset(verImg($stock->producto->miniatura)) }}{{--img/product-1.jpg--}}" alt="">
                        <div class="product-action">
                            @if(auth()->check())
                                @php($ruta = route('web.detalles', $stock->id))
                                <a class="btn btn-outline-dark btn-square btn_favoritos @if($stock->favoritos) fondo-favoritos @endif"
                                   id="favoritos_{{ $stock->id }}" data-id-stock="{{ $stock->id }}" data-tipo="_productos" data-key="favoritos_" href="#">
                                    <i class="far fa-heart"></i>
                                </a>
                                <a class="btn btn-outline-dark btn-square" href="{{ route('android.detalles', [auth()->id(), $stock->id]) }}" onclick="preSubmit()"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-outline-dark btn-square btn_carrito @if($stock->carrito) fondo-favoritos @endif"
                                   id="carrito_{{ $stock->id }}" data-id-stock="{{ $stock->id }}" data-cantidad="1" data-opcion="sumar" data-key="carrito_" href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                            @else
                                @php($ruta = route('guest.detalles', $stock->id))
                                <a class="btn btn-outline-dark btn-square" onclick="preSubmit()" href="{{ route('web.home') }}"><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" onclick="preSubmit()" href="{{ route('guest.detalles', $stock->id) }}"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-outline-dark btn-square" onclick="preSubmit()" href="{{ route('web.home') }}"><i class="fa fa-shopping-cart"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="{{ $ruta }}">{{ $producto->nombre }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>${{ calcularPrecio($stock->id, $stock->pvp) }}{{--$123.00--}}</h5>
                            {{--<h6 class="text-muted ml-2"><del>$123.00</del></h6>--}}
                        </div>
                        {{--<div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small>(99)</small>
                        </div>--}}
                    </div>
                </div>
            </div>
                @endforeach
            @endforeach


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


        @endif
    </div>
</div>
