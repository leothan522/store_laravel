<table class="table table-light table-borderless table-hover text-center mb-0">
    <thead class="thead-dark">
    <tr>
        <th>Productos</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Total</th>
        <th>Quitar</th>
    </tr>
    </thead>
    <tbody class="align-middle">


    @foreach($listarCarrito as $carrito)

        <tr id="tr_{{ $carrito->id }}">
        <td class="align-middle text-left">
            <img src="{{ asset(verImg($carrito->stock->producto->cart)) }}{{--img/product-1.jpg--}}" alt="" style="width: 50px;" class="mr-3">
            {{ $carrito->stock->producto->nombre }}
        </td>
        <td class="align-middle text-right">
            $ {{ formatoMillares($carrito->precio, 2) }}
        </td>
        <td class="align-middle">
            <div class="input-group quantity mx-auto" style="width: 100px;">

                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-minus qtybtn" data-input="valor_id_{{ $carrito->id }}">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>

                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center btn_editar_input"
                       data-carrito-id="{{ $carrito->id }}"
                       data-carrito-item="carrito_item_{{ $carrito->id }}"
                       value="{{ formatoMillares($carrito->cantidad, 0) }}"
                       id="valor_id_{{ $carrito->id }}">

                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-plus qtybtn" data-input="valor_id_{{ $carrito->id }}">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>

            </div>
        </td>
        <td class="align-middle text-right">
            <span id="carrito_item_{{ $carrito->id }}">
                {{ formatoMillares($carrito->item, 2) }}
            </span>
        </td>
        <td class="align-middle">
            <button class="btn btn-sm btn-danger btn_remover" data-id-carrito="{{ $carrito->id }}" data-item-carrito="tr_{{ $carrito->id }}">
                <i class="fa fa-times"></i>
            </button>
        </td>
    </tr>

    @endforeach


    {{--<tr>
        <td class="align-middle"><img src="{{ asset('vendor/multishop/img/product-1.jpg') }}--}}{{--img/product-1.jpg--}}{{--" alt="" style="width: 50px;"> Product Name</td>
        <td class="align-middle">$150</td>
        <td class="align-middle">
            <div class="input-group quantity mx-auto" style="width: 100px;">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-minus" >
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="1">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-plus">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </td>
        <td class="align-middle">$150</td>
        <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="{{ asset('vendor/multishop/img/product-2.jpg') }}--}}{{--img/product-2.jpg--}}{{--" alt="" style="width: 50px;"> Product Name</td>
        <td class="align-middle">$150</td>
        <td class="align-middle">
            <div class="input-group quantity mx-auto" style="width: 100px;">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-minus" >
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="1">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-plus">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </td>
        <td class="align-middle">$150</td>
        <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="{{ asset('vendor/multishop/img/product-3.jpg') }}--}}{{--img/product-3.jpg--}}{{--" alt="" style="width: 50px;"> Product Name</td>
        <td class="align-middle">$150</td>
        <td class="align-middle">
            <div class="input-group quantity mx-auto" style="width: 100px;">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-minus" >
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="1">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-plus">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </td>
        <td class="align-middle">$150</td>
        <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="{{ asset('vendor/multishop/img/product-4.jpg') }}--}}{{--img/product-4.jpg--}}{{--" alt="" style="width: 50px;"> Product Name</td>
        <td class="align-middle">$150</td>
        <td class="align-middle">
            <div class="input-group quantity mx-auto" style="width: 100px;">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-minus" >
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="1">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-plus">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </td>
        <td class="align-middle">$150</td>
        <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="{{ asset('vendor/multishop/img/product-5.jpg') }}--}}{{--img/product-5.jpg--}}{{--" alt="" style="width: 50px;"> Product Name</td>
        <td class="align-middle">$150</td>
        <td class="align-middle">
            <div class="input-group quantity mx-auto" style="width: 100px;">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-minus" >
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="1">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-plus">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </td>
        <td class="align-middle">$150</td>
        <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
    </tr>--}}
    </tbody>
</table>
