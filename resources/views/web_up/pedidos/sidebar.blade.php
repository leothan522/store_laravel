<div class="col-lg-3 col-md-4">

    <!-- Price Start -->
    {{--@if($listarDestacados->count() > 0)--}}
        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Todos tus Pedidos</span></h5>


        <div class="col-lg-12 col-6 text-left mb-3">
            <form onsubmit="buscarPedido(event)" id="form_submit_pedido">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar Pedido" id="submit_buscar" required>
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>


        <div class="bg-light p-4 mb-30">

            @if($listarPedidos->isNotEmpty())
                <div class="d-flex align-items-center justify-content-between">
                    <span class="badge border font-weight-normal">Pedidos</span>
                    <span class="badge border font-weight-normal">Estatus</span>
                </div>
                <hr>
                @foreach($listarPedidos as $order)

                    <a href="#" class="btn-link text-dark btn_show_pedido" data-id="{{ $order->id }}" onclick="preSubmit()">
                        <div class="d-flex align-items-center justify-content-between mb-3">

                            Pedido {{ $order->numero }}

                            <span class="{{--badge--}} {{--border--}} font-weight-normal">
                                @if($order->estatus == 0)
                                    <span class="text-warning">
                                        <i class="far fa-address-card"></i>
                                    </span>
                                @endif
                                @if($order->estatus == 1)
                                    <span class="text-info">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </span>
                                @endif
                                @if($order->estatus == 2)
                                    <span class="float-right">
                                        <i class="fa fa-truck"></i>
                                    </span>
                                @endif
                                @if($order->estatus == 3)
                                    <span class="float-right text-success">
                                        <i class="fa fa-check"></i>
                                    </span>
                                @endif
                                @if($order->estatus == 4)
                                    <span class="text-danger">
                                        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </span>
                        </div>
                    </a>

                @endforeach

                <div class="d-flex align-items-center justify-content-between mt-4">
                    {{ $listarPedidos->links() }}
                </div>

            @else
                <div class="d-flex align-items-center justify-content-between">
                    Aun NO tienes Pedidos
                    {{--<span class="badge border font-weight-normal">${{ calcularPrecio($stock->id, $stock->pvp) }}</span>--}}
                </div>
            @endif

        </div>

   {{-- @endif--}}
<!-- Price End -->

    {{--<!-- Color Start -->
    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by color</span></h5>
    <div class="bg-light p-4 mb-30">
        <form>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" checked id="color-all">
                <label class="custom-control-label" for="price-all">All Color</label>
                <span class="badge border font-weight-normal">1000</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="color-1">
                <label class="custom-control-label" for="color-1">Black</label>
                <span class="badge border font-weight-normal">150</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="color-2">
                <label class="custom-control-label" for="color-2">White</label>
                <span class="badge border font-weight-normal">295</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="color-3">
                <label class="custom-control-label" for="color-3">Red</label>
                <span class="badge border font-weight-normal">246</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="color-4">
                <label class="custom-control-label" for="color-4">Blue</label>
                <span class="badge border font-weight-normal">145</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                <input type="checkbox" class="custom-control-input" id="color-5">
                <label class="custom-control-label" for="color-5">Green</label>
                <span class="badge border font-weight-normal">168</span>
            </div>
        </form>
    </div>
    <!-- Color End -->

    <!-- Size Start -->
    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
    <div class="bg-light p-4 mb-30">
        <form>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" checked id="size-all">
                <label class="custom-control-label" for="size-all">All Size</label>
                <span class="badge border font-weight-normal">1000</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="size-1">
                <label class="custom-control-label" for="size-1">XS</label>
                <span class="badge border font-weight-normal">150</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="size-2">
                <label class="custom-control-label" for="size-2">S</label>
                <span class="badge border font-weight-normal">295</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="size-3">
                <label class="custom-control-label" for="size-3">M</label>
                <span class="badge border font-weight-normal">246</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" id="size-4">
                <label class="custom-control-label" for="size-4">L</label>
                <span class="badge border font-weight-normal">145</span>
            </div>
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                <input type="checkbox" class="custom-control-input" id="size-5">
                <label class="custom-control-label" for="size-5">XL</label>
                <span class="badge border font-weight-normal">168</span>
            </div>
        </form>
    </div>
    <!-- Size End -->--}}
</div>
