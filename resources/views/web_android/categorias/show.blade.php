@if($listarCategorias->count() > 0 && !$categoria)
<div class="container-fluid">
    <div class="row px-xl-5 pb-3">

        @foreach($listarCategorias as $cat)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" onclick="preSubmit()" href="{{ route('android.categorias', [auth()->id(), $cat->id]) }}">
                <div class="cat-item d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px;">
                        <img class="img-fluid" src="{{ asset(verImg($cat->imagen)) }}{{--img/cat-1.jpg--}}" alt="">
                        {{--<img class="img-fluid" src="{{ asset('vendor/multishop/img/cat-1.jpg') }}--}}{{--img/cat-1.jpg--}}{{--" alt="">--}}
                    </div>
                    <div class="flex-fill pl-3">
                        <h6>{{ $cat->nombre }}</h6>
                        <small class="text-body">{{ $cat->cantidad }} Productos Disponibles</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    </div>
</div>

    @else

    @include('web_android.categorias.product')

@endif

@include('web_android.categorias.offer')
