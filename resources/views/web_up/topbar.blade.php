<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                @if(auth()->check())
                    <a class="text-dark btn btn-link mr-3" href="{{ route('web.perfil') }}"><i class="fas fa-envelope"></i> {{ auth()->user()->email }}</a>
                    <a class="text-dark btn-link mr-3" href="{{ route('web.perfil') }}"><i class="fas fa-user"></i> {{ auth()->user()->name }}</a>
                    {{--<a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>--}}
                @endif
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            @if(auth()->check())
                @if(auth()->user()->role > 0)
                    <a class="text-dark mr-3 btn btn-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                @endif
                <a class="text-dark mr-3 btn btn-link" href="{{ route('cerrar') }}"><i class="fas fa-power-off"></i> Cerrar</a>
            @else
                <a class="text-dark mr-3 btn btn-link" href="{{ route('web.home') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                <a class="text-dark mr-3 btn btn-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> {{ __('Register') }}</a>
            @endif

            {{--<div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My Account</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">Sign in</button>
                        <button class="dropdown-item" type="button">Sign up</button>
                    </div>
                </div>
                <div class="btn-group mx-2">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">EUR</button>
                        <button class="dropdown-item" type="button">GBP</button>
                        <button class="dropdown-item" type="button">CAD</button>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">FR</button>
                        <button class="dropdown-item" type="button">AR</button>
                        <button class="dropdown-item" type="button">RU</button>
                    </div>
                </div>
            </div>--}}

            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="{{ route('web.favoritos') }}" class="btn px-0 ml-2">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;" id="header_favoritos_topbar">{{ $headerFavoritos }}</span>
                </a>
                <a href="{{ route('web.carrito') }}" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;" id="header_carrito_topbar">{{ formatoMillares($headerItems, 0) }}</span>
                </a>
            </div>
        </div>

    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Sportec</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Tienda</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="{{ route('web.busqueda') }}" method="get">
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
    </div>
</div>
