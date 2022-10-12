<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                <!-- Rigth -->
                <a class="text-dark mr-3 btn btn-link" href="{{ route('cerrar') }}" onclick="preSubmit()"><i class="fas fa-power-off"></i> Cerrar</a>
                @if(auth()->user()->role > 0)
                        <a class="text-dark mr-3 btn btn-link" href="{{ route('dashboard') }}" onclick="preSubmit()"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                @endif
                <a href="{{ route('android.favoritos', auth()->id()) }}" class="btn px-0" onclick="preSubmit()">
                    <i class="fas fa-heart {{--text-primary--}}"></i>
                    <span class="badge {{--text-secondary--}} border {{--border-secondary--}} rounded-circle" style="padding-bottom: 2px;" id="header_favoritos_navbar">{{ $headerFavoritos }}</span>
                </a>
                <a href="{{ route('android.carrito', auth()->id()) }}" class="btn px-0 ml-3" onclick="preSubmit()">
                    <i class="fas fa-shopping-cart {{--text-primary--}}"></i>
                    <span class="badge {{--text-secondary--}} border {{--border-secondary--}} rounded-circle" style="padding-bottom: 2px;" id="header_carrito_navbar">{{ formatoMillares($headerItems, 0) }}</span>
                    {{--<span class="text-secondary">item: <span id="header_item">${{ formatoMillares($headerTotal) }}</span></span>--}}
                </a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="{{ route('android.favoritos', auth()->id()) }}" class="btn px-0 ml-2" onclick="preSubmit()">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;" id="header_favoritos_topbar">{{ $headerFavoritos }}</span>
                </a>
                <a href="{{ route('android.carrito', auth()->id()) }}" class="btn px-0 ml-2" onclick="preSubmit()">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;" id="header_carrito_topbar">{{ formatoMillares($headerItems, 0) }}</span>
                </a>
            </div>
        </div>

    </div>
    {{--<div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            @if(auth()->check())
                @php($home = route('web.home') )
            @else
                @php($home = route('web.index') )
            @endif
            <a href="{{ $home }}" class="text-decoration-none" onclick="preSubmit()">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Sportec</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Tienda</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="{{ route('web.busqueda') }}" method="get" onsubmit="preSubmit()">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar productos" name="buscar" required>
                    <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0">Servicio al Cliente</p>
            <h5 class="m-0">{{ telefonoSoporte() }}</h5>
        </div>
    </div>--}}
</div>
