<div class="col-lg-12 col-md-8">
    <div class="row pb-3">

        <div class="container-fluid text-center">

            @if($listarFavoritos)
                <div class="container-fluid">
                    {{--<h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categorias</span></h2>--}}
                    <div class="row {{--px-xl-5 pb-3--}}">

                        @foreach($listarFavoritos as $key => $favorito)
                        <div class="col-lg-4 col-md-4 col-sm-6 pb-1">
                            <a class="text-decoration-none" onclick="preSubmit()" href="{{ route('android.detalles', [auth()->id(), $favorito['id']]) }}">
                                <div class="cat-item d-flex align-items-center mb-4">
                                    <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                        <img class="img-fluid" src="{{ asset(verImg($favorito['miniatura'])) }}{{--img/cat-1.jpg--}}" alt="">
                                        {{--<img class="img-fluid" src="{{ asset('vendor/multishop/img/cat-1.jpg') }}--}}{{--img/cat-1.jpg--}}{{--" alt="">--}}
                                    </div>
                                    <div class="flex-fill pl-1 pr-1">
                                        <h6>{{ $favorito['nombre'] }}</h6>
                                        <small class="text-body"><span>{{ $favorito['moneda'] }} {{ calcularPrecio($favorito['producto_id'], $favorito['pvp']) }}</span></small>
                                        @if($favorito['estatus'] /*$favorito['estatus'] == 0*/ /*|| $stock->stock_disponible <= 0*/)
                                            <small class="text-danger"><strong>(Agotado)</strong></small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach

                    </div>
                </div>

                @else
                Tus Favoritos apareceran aqui...
            @endif


        </div>

    </div>
</div>

@include('web_android.favoritos.offer')
