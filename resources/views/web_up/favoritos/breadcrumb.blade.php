<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{ route('web.home') }}" onclick="preSubmit()">Inicio</a>
                {{--<a class="breadcrumb-item text-dark" href="{{ route('web.carrito') }}" onclick="preSubmit()">{{ $modulo }}</a>--}}
                <span class="breadcrumb-item active">{{ $titulo }}</span>
            </nav>
        </div>
    </div>
</div>
