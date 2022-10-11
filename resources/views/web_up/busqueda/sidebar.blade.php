<div class="col-lg-3 col-md-4">

    <!-- Price Start -->
    @if($listarDestacados->count() > 0)
        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Productos Destacados</span></h5>
        <div class="bg-light p-4 mb-30">
            @foreach($listarDestacados as $stock)
                @if(auth()->check())
                    @php($ruta = route('web.detalles', $stock->id))
                @else
                    @php($ruta = route('guest.detalles', $stock->id))
                @endif
                <a href="{{ $ruta }}" class="btn-link text-dark" onclick="preSubmit()">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        {{ $stock->producto->nombre }}
                        <span class="badge border font-weight-normal">${{ calcularPrecio($stock->id, $stock->pvp) }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
<!-- Price End -->

</div>
