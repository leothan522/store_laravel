<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categorias</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">

                    @foreach($listarCategorias as $categoria)
                        <a href="
                        @if(auth()->check())
                            {{ route('web.categorias', $categoria->id) }}
                        @else
                            {{ route('guest.categorias', $categoria->id) }}
                        @endif
                            " class="nav-item nav-link" onclick="preSubmit()">{{ ucwords($categoria->nombre) }}</a>
                    @endforeach
                    {{--<div class="nav-item dropdown dropright">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dresses <i class="fa fa-angle-right float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div>--}}
                    {{--<a href="" class="nav-item nav-link">Shirts</a>
                    <a href="" class="nav-item nav-link">Jeans</a>
                    <a href="" class="nav-item nav-link">Swimwear</a>
                    <a href="" class="nav-item nav-link">Sleepwear</a>
                    <a href="" class="nav-item nav-link">Sportswear</a>
                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                    <a href="" class="nav-item nav-link">Blazers</a>
                    <a href="" class="nav-item nav-link">Jackets</a>
                    <a href="" class="nav-item nav-link">Shoes</a>--}}
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                @if(auth()->check())
                    @php($home = route('web.home') )
                @else
                    @php($home = route('web.index') )
                @endif
                <a href="{{ $home }}" class="text-decoration-none d-block d-lg-none" onclick="preSubmit()">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Sportec</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Tienda</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ $home }}" class="nav-item nav-link active" onclick="preSubmit()">Inicio</a>
                        <a href="{{ route('web.pedidos') }}" class="nav-item nav-link" onclick="preSubmit()">Tus Pedidos</a>
                        {{--<a href="" class="nav-item nav-link active">Home</a>
                        <a href="shop.html" class="nav-item nav-link">Shop</a>
                        <a href="detail.html" class="nav-item nav-link">Shop Detail</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                            <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                <a href="checkout.html" class="dropdown-item">Checkout</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>--}}
                        <a href="{{ asset('apk/sportec_tienda.apk') }}" class="nav-item nav-link"><i class="fab fa-android"></i> Descargar APK</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="{{ route('web.favoritos') }}" class="btn px-0" onclick="preSubmit()">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;" id="header_favoritos_navbar">{{ $headerFavoritos }}</span>
                        </a>
                        <a href="{{ route('web.carrito') }}" class="btn px-0 ml-3" onclick="preSubmit()">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;" id="header_carrito_navbar">{{ formatoMillares($headerItems, 0) }}</span>
                            {{--<span class="text-secondary">item: <span id="header_item">${{ formatoMillares($headerTotal) }}</span></span>--}}
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
