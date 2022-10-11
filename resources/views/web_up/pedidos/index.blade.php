@extends('layouts.multishop.master')

@section('title', 'Pedidos')

@section('content')

    <!-- Breadcrumb Start -->
    @include('web_up.pedidos.breadcrumb')
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
        @include('web_up.pedidos.sidebar')
        <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
        @include('web_up.pedidos.show')
        <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

@endsection

@section('js')

    @include('web_up.funciones_ajax')
    @include('web_up.funciones_android')

    <script type="text/javascript">

        $("#btn_corregir").click(function(e) {
            e.preventDefault();
            Cargando.fire();
            document.getElementById('pago_default_ped').classList.add('d-none');
            document.getElementById('pago_corregir_ped').classList.remove('d-none');
            Toast.fire({
                icon: 'success',
                title: 'Corregir Habilitado.',
            });
        });

        function buscarPedido(e){
            e.preventDefault();
            Cargando.fire();
            let buscar = document.getElementById('submit_buscar').value;
            $.ajax({
                type: 'POST',
                url: "{{ route('ajax.buscar_pedido') }}",
                data: {
                    buscar: buscar
                },
                success: function (data) {

                    if (data.type === "success"){

                        if (data.estatus === 0){
                            window.location.href = "{{ route('web.checkout') }}" + "/" + data.id_pedido;
                        }else{

                            Toast.fire({
                                icon: data.type,
                                title: data.message,
                            });

                            document.getElementById('show_mensaje').classList.add('d-none');
                            document.getElementById('show_pedido').classList.remove('d-none');

                            document.getElementById('show_estatus').innerHTML = data.mostrar_estatus;

                            document.getElementById('fact_cedula').value = data.cedula;
                            document.getElementById('fact_nombre').value = data.nombre;
                            document.getElementById('fact_email').value = data.email;
                            document.getElementById('fact_telefono').value = data.telefono;
                            document.getElementById('fact_direccion_1').value = data.direccion_1;
                            document.getElementById('fact_direccion_2').value = data.direccion_2;

                            document.getElementById('show_numero').innerHTML = data.numero;
                            document.getElementById('show_carrito').innerHTML = data.productos;
                            document.getElementById('carrito_subtotal').innerHTML = data.subtotal;
                            document.getElementById('carrito_iva').innerHTML = data.iva;
                            document.getElementById('carrito_delivery').innerHTML = data.delivery;
                            document.getElementById('carrito_total').innerHTML = data.total;
                            document.getElementById('carrito_bs').innerHTML = data.bs;

                            document.getElementById('pago_metodo').value = data.label_metodo;
                            document.getElementById('pago_referencia').value = data.comprobante_pago;

                            document.getElementById('btn_metodo_corregir').dataset.idPedido = data.id_pedido;

                            document.getElementById('pago_default_ped').classList.remove('d-none');
                            document.getElementById('pago_corregir_ped').classList.add('d-none');

                            if (data.estatus === 4){
                                document.getElementById('pago_no_validado').classList.remove('d-none');
                                if (!data.mostrar_comprobante){
                                    document.getElementById('pago_no_validado_efectivo').classList.remove('d-none');
                                }else{
                                    document.getElementById('pago_no_validado_efectivo').classList.add('d-none');
                                }
                                document.getElementById('btn_corregir').classList.remove('d-none');
                            }else {
                                document.getElementById('pago_no_validado').classList.add('d-none');
                                document.getElementById('pago_no_validado_efectivo').classList.add('d-none');
                                document.getElementById('btn_corregir').classList.add('d-none');
                            }

                            if (data.mostrar_delivery){
                                document.getElementById('show_delivery').classList.remove('d-none');
                                document.getElementById('show_delivery').classList.add('d-flex');
                            }else{
                                document.getElementById('show_delivery').classList.add('d-none');
                                document.getElementById('show_delivery').classList.remove('d-flex');
                            }

                            if (data.mostrar_comprobante){
                                document.getElementById('mostrar_comprobante').classList.remove('d-none');
                            }else{
                                document.getElementById('mostrar_comprobante').classList.add('d-none');
                            }
                        }

                    }else{

                        Alerta.fire({
                            icon: data.type,
                            title: data.message,
                            text: data.text
                        });

                    }

                }
            });

        }

        console.log('Hi!');
    </script>

@endsection
