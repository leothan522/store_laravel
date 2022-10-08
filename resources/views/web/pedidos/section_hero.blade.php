<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Todos tus Pedidos</span>
                    </div>
                    <ul>
                        @if($listarPedidos->isNotEmpty())

                            @foreach($listarPedidos as $order)
                                {{-- @if($pedido && $pedido->id == $order->id) @continue @endif--}}
                                <li class="col-md-11">
                                    <a href="
                                            @if($ruta == "android")
                                            {{ route('android.pedidos', [auth()->id(), $order->id]) }}
                                            @else
                                            {{ route('web.pedidos', $order->id) }}
                                            @endif
                                            " onclick="preSubmit()">
                                        Pedido {{ $order->numero }}
                                        @if($order->estatus == 0)
                                            <span class="float-right text-warning">
                                        <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                        </span>
                                        @endif
                                        @if($order->estatus == 1)
                                            <span class="float-right text-info">
                                        <i class="fa fa-money" aria-hidden="true"></i>
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
                                            <span class="float-right text-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        </span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach

                            @else

                            <li class="col-md-11">
                                Aun NO tienes Pedidos
                            </li>

                        @endif
                    </ul>
                </div>
                <br>
                {{--<div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('web.home') }}" class="btn btn-primary">¡Seguir Comprando!</a>
                    </div>
                </div>--}}
            </div>
            <div class="col-lg-9">
                @if($pedido)
                    @include('web.pedidos.checkout')
                    @else
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <div class="col-md-12 text-center p-3">
                                Selecciona uno de tus pedidos para ver su estatus.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->
