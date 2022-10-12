<div class="col-12">
    <div class="container-fluid bg-dark text-secondary pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-4 col-md-12 mb-3 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Ponerse en contacto</h5>
                <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>{{ $categoria->direccion }}</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ $categoria->email }}</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ $categoria->telefono }}</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        {{--<h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>--}}
                    </div>
                    <div class="col-md-4 mb-5">
                        {{--<h5 class="text-secondary text-uppercase mb-4">Datos de la Tienda</h5>--}}
                        <div class="d-flex flex-column justify-content-start">
                            @if(auth()->check())
                                @php($home = route('web.home'))
                            @else
                                @php($home = route('web.index'))
                            @endif
                            <span class="text-secondary mb-2"><i class="fa fa-angle-right mr-2"></i>Nombre: <span class="text-primary">{{ $categoria->nombre }}</span></span>
                            <span class="text-secondary mb-2"><i class="fa fa-angle-right mr-2"></i>RIF: <span class="text-primary">{{ $categoria->rif }}</span></span>
                            {{--<span class="text-secondary mb-2"><i class="fa fa-angle-right mr-2"></i>Teléfono: <span class="text-primary">{{ $categoria->telefono }}</span></span>
                            <span class="text-secondary mb-2"><i class="fa fa-angle-right mr-2"></i>Email: <span class="text-primary">{{ $categoria->email }}</span></span>
                            <span class="text-secondary mb-2"><i class="fa fa-angle-right mr-2"></i>Dirección&nbsp;&nbsp;Favoritos</span>--}}
                            <a class="text-secondary mt-3" href="{{ asset('apk/sportec_tienda.apk') }}"><i class="fa fa-angle-right mr-2"></i>Descargar APK</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        {{--<h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Sign Up</button>
                                </div>
                            </div>
                        </form>--}}
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Síguenos</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
