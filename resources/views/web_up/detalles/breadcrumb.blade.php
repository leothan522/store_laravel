<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                @if(auth()->check())
                    @php($home = route('web.home'))
                    @php($deta = route('web.detalles', $stock->id))
                @else
                    @php($home = route('web.index'))
                    @php($deta = route('guest.detalles', $stock->id))
                @endif
                <a class="breadcrumb-item text-dark" href="{{ $home }}" onclick="preSubmit()">Inicio</a>
                <a class="breadcrumb-item text-dark" href="{{ $deta }}" onclick="preSubmit()">{{ $modulo }}</a>
                <span class="breadcrumb-item active">{{ $titulo }}</span>
            </nav>
        </div>
    </div>
</div>
