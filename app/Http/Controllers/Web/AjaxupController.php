<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\Delivery;
use App\Models\Parametro;
use App\Models\Pedido;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxupController extends Controller
{
    public function favoritos(Request $request)
    {
        $id_stock = $request->id_stock;
        $id_usuario = Auth::id();
        $tipo = $request->tipo;
        $key = $request->key;

        $favoritos = Parametro::where('nombre', 'favoritos' . $tipo)
            ->where('tabla_id', $id_usuario)
            ->where('valor', $id_stock)
            ->first();

        $cantidad = Parametro::where('nombre', 'LIKE', "%favoritos%")
            ->where('tabla_id', $id_usuario)
            ->count();
        if ($favoritos) {
            $favoritos->delete();
            $cantidad = $cantidad - 1;
            $json = [
                'type' => 'info',
                'message' => 'Eliminado de tus favoritos',
                'cantidad' => $cantidad,
                'id' => $key . $id_stock//"favoritos_$id_stock"
            ];
        } else {
            $favoritos = new Parametro();
            $favoritos->nombre = "favoritos" . $tipo;
            $favoritos->tabla_id = $id_usuario;
            $favoritos->valor = $id_stock;
            $favoritos->save();
            $cantidad = $cantidad + 1;
            $json = [
                'type' => 'success',
                'message' => 'Agregado a tus favoritos.',
                'cantidad' => $cantidad,
                'id' => $key . $id_stock//"favoritos_$id_stock"
            ];
        }

        return response()->json($json);
    }

    public function totalizar($id, $estatus = 0, $pedido = null)
    {
        $totalizar = [];
        $listarCarrito = Carrito::where('users_id', $id)
            ->where('estatus', $estatus)
            ->where('pedidos_id', $pedido)
            ->get();
        $listarCarrito->each(function ($carrito) {
            $id_producto = $carrito->stock->productos_id;
            $cantidad = $carrito->cantidad;
            $pvp = $carrito->stock->pvp;
            $precio = calcularPrecio($carrito->stock_id, $pvp);
            $iva = calcularPrecio($carrito->stock_id, $pvp, true);
            $carrito->iva = $iva * $cantidad;
            $carrito->subtotal = ($precio - $iva) * $cantidad;
            $carrito->total = $precio * $cantidad;
        });
        $subtotal = $listarCarrito->sum('subtotal');
        $iva = $listarCarrito->sum('iva');
        $total = $listarCarrito->sum('total');
        $cantidad = $listarCarrito->sum('cantidad');

        if ($total == 0) {
            $delivery = Delivery::where('users_id', Auth::id())
                ->where('estatus', $estatus)
                ->where('pedidos_id', $pedido)
                ->first();
            if ($delivery) {
                $delivery->delete();
            }
        }

        $totalizar['subtotal'] = $subtotal;
        $totalizar['iva'] = $iva;
        $totalizar['cantidad'] = $cantidad;

        $delivery = Delivery::where('users_id', $id)
            ->where('estatus', $estatus)
            ->where('pedidos_id', $pedido)
            ->first();
        if ($delivery) {
            $zona = $delivery->zona->precio;
        } else {
            $zona = 0;
        }

        $totalizar['delivery'] = $zona;
        $totalizar['total'] = $total + $zona;

        return $totalizar;
    }

    public function carrito(Request $request)
    {

        $id_usuario = Auth::id();
        $opcion = $request->opcion;
        $btn = false;


        if ($opcion == 'sumar' || $opcion == 'agregar') {

            $id_stock = $request->id_stock;
            $cantidad = $request->cantidad;
            $key = $request->key;

            $stock = Stock::find($id_stock);
            $estatus = $stock->estatus;
            $empresas_id = $stock->empresas_id;
            $disponible = $stock->stock_disponible;
            $comprometido = $stock->stock_comprometido;

            if (estatusTienda($empresas_id)) {

                if ($disponible >= $cantidad && $estatus == 1) {

                    $pedido = Pedido::where('users_id', Auth::id())
                        ->where('estatus', 0)
                        ->first();

                    $pedido2 = Pedido::where('users_id', Auth::id())
                        ->where('estatus', 4)
                        ->first();

                    if ($pedido || $pedido2) {

                        if ($pedido){
                            if ($pedido->estatus == 0) {
                                $type = "warning";
                                $mensage = "Tienes un Pedido Pendiente.";
                            } else {
                                $type = "warning";
                                $mensage = "Tienes un Pago por Verificar.";
                            }
                        }else{
                            if ($pedido2->estatus == 0) {
                                $type = "warning";
                                $mensage = "Tienes un Pedido Pendiente.";
                            } else {
                                $type = "warning";
                                $mensage = "Tienes un Pago por Verificar.";
                            }
                        }

                        $nueva_cantidad = $cantidad;

                    } else {

                        //restamos del stock_disponible
                        $stock->stock_disponible = $disponible - $cantidad;
                        $stock->stock_comprometido = $comprometido + $cantidad;
                        $stock->update();

                        $carrito = Carrito::where('users_id', $id_usuario)
                            ->where('stock_id', $id_stock)
                            ->where('estatus', 0)
                            ->first();

                        if ($carrito) {

                            $nueva_cantidad = $carrito->cantidad + $cantidad;
                            $nombre = $carrito->stock->producto->nombre;
                            $carrito->cantidad = $nueva_cantidad;
                            $carrito->update();

                            $type = 'info';
                            $mensage = "Tienes " . formatoMillares($nueva_cantidad, 0) . " " . $nombre;
                            $btn = true;

                        } else {

                            $carrito = new Carrito();
                            $carrito->users_id = $id_usuario;
                            $carrito->stock_id = $id_stock;
                            $carrito->cantidad = $cantidad;
                            $carrito->save();

                            $type = 'success';
                            $mensage = 'Agregado al Carrito.';
                            $btn = true;

                        }

                        $nueva_cantidad = $carrito->cantidad;

                    }


                } else {

                    $type = 'warning';
                    $mensage = "Stock Agotado";
                    $nueva_cantidad = $cantidad;

                }

            } else {

                $type = "warning";
                $mensage = "La tienda " . $stock->empresa->nombre . " \n esta cerrada.";
                $nueva_cantidad = $cantidad;
            }
            $totalizar = $this->totalizar(Auth::id());

            $json = [
                'type' => $type,
                'message' => $mensage,
                'cantidad' => formatoMillares($totalizar['cantidad'], 0),
                'items' => formatoMillares($totalizar['total'], 2),
                'id' => $key . $id_stock,//"carrito_$id_stock",
                'cart' => formatoMillares($nueva_cantidad, 0),
                'opcion' => $opcion,
                'input' => 'cantAgregar',
                'btn' => $btn
            ];

        }

        if ($opcion == "remover") {

            $id_carrito = $request->id_carrito;
            $tr = $request->tr;

            $carrito = Carrito::find($id_carrito);
            $id_stock = $carrito->stock_id;
            $cantidad = $carrito->cantidad;
            $carrito->delete();

            $stock = Stock::find($id_stock);
            $disponible = $stock->stock_disponible;
            $comprometido = $stock->stock_comprometido;
            $stock->stock_disponible = $disponible + $cantidad;
            $stock->stock_comprometido = $comprometido - $cantidad;
            $stock->update();

            $totalizar = $this->totalizar(Auth::id());

            $json = [
                'type' => 'success',
                'message' => 'Eliminado del Carrito.',
                'cantidad' => formatoMillares($totalizar['cantidad'], 0),
                'opcion' => $opcion,
                'tr' => $tr,
                'subtotal' => $totalizar['subtotal'],
                'iva' => $totalizar['iva'],
                'total' => $totalizar['total'],
                'delivery' => $totalizar['delivery'],
                'label_delivery' => "$ " . formatoMillares($totalizar['delivery'], 2),
                'label_subtotal' => "$ " . formatoMillares($totalizar['subtotal'], 2),
                'label_iva' => "$ " . formatoMillares($totalizar['iva'], 2),
                'label_total' => "$ " . formatoMillares($totalizar['total'], 2),
            ];
        }

        if ($opcion == "editar") {

            $boton = $request->boton;
            $valor = $request->valor;
            $carrito_id = $request->carrito_id;
            $carrito_item = $request->carrito_item;
            $subtotal = $request->subtotal;
            $iva = $request->iva;
            $total = $request->total;

            $type = 'success';
            $mensage = 'Carrito Actualizado.';

            $carrito = Carrito::find($carrito_id);
            $carrito_producto = $carrito->stock->id;
            $carrito_cantidad = $carrito->cantidad;
            $carrito_pvp = $carrito->stock->pvp;
            $carrito_precio = calcularPrecio($carrito_producto, $carrito_pvp);

            $stock = Stock::find($carrito_producto);
            $estatus = $stock->estatus;
            $disponible = $stock->stock_disponible;
            $comprometido = $stock->stock_comprometido;

            if ($boton == "btn-sumar") {
                $cantidad = $carrito_cantidad + 1;
                $nuevo_item = $carrito_precio * $cantidad;
            }
            if ($boton == "btn-restar") {
                $cantidad = $carrito_cantidad - 1;
                $nuevo_item = $carrito_precio * $cantidad;
            }
            if ($boton == "input") {
                $cantidad = $valor;
                $nuevo_item = $carrito_precio * $cantidad;
            }

            if ($cantidad <= 0) {
                $carrito->delete();
                $stock->stock_disponible = $disponible + $carrito_cantidad;
                $stock->stock_comprometido = $comprometido - $carrito_cantidad;
                $stock->update();
                $borrar = "si";
            } else {
                if ($cantidad > $carrito_cantidad) {
                    $diferencia = $cantidad - $carrito_cantidad;
                    if ($disponible < $diferencia || $estatus == 0) {
                        $type = "warning";
                        $mensage = "Stock Agotado.";
                    } else {
                        $stock->stock_disponible = $disponible - $diferencia;
                        $stock->stock_comprometido = $comprometido + $diferencia;
                        $carrito->cantidad = $cantidad;
                    }
                } else {
                    $diferencia = $carrito_cantidad - $cantidad;
                    $stock->stock_disponible = $disponible + $diferencia;
                    $stock->stock_comprometido = $comprometido - $diferencia;
                    $carrito->cantidad = $cantidad;
                }
                $stock->update();
                $carrito->update();
                $borrar = "no";
            }

            $totalizar = $this->totalizar(Auth::id());

            $json = [
                'type' => $type,
                'message' => $mensage,
                'hcantidad' => formatoMillares($totalizar['cantidad'], 0),
                'valor' => $cantidad,
                'carrito_item' => $carrito_item,
                'label_carrito_item' => formatoMillares($nuevo_item, 2),
                'subtotal' => $totalizar['subtotal'],
                'iva' => $totalizar['iva'],
                'total' => $totalizar['total'],
                'delivery' => $totalizar['delivery'],
                'label_delivery' => "$ " . formatoMillares($totalizar['delivery'], 2),
                'label_subtotal' => "$ " . formatoMillares($totalizar['subtotal'], 2),
                'label_iva' => "$ " . formatoMillares($totalizar['iva'], 2),
                'label_total' => "$ " . formatoMillares($totalizar['total'], 2),
                'borrar' => $borrar,
                'tr' => "tr_$carrito_id",
                'id' => 'valor_id_' . $carrito_id,
                'cantidad' => formatoMillares($carrito_cantidad, 0)
            ];
        }

        if ($opcion == "remover-delivery") {

            $accion = $request->accion;
            $zona_id = $request->zona;

            if ($accion == "remover") {

                $this->editarZonas("vacia");
                $tipo = "info";
                $mensage = "Desactivado";
                $accion = "incluir";

            } else {

                $this->editarZonas($zona_id);
                $tipo = "success";
                $mensage = "Activado";
                $accion = "remover";

            }

            $totalizar = $this->totalizar(Auth::id());

            $json = [
                'type' => $tipo,
                'message' => "Delivery $mensage.",
                'accion' => $accion,
                'subtotal' => $totalizar['subtotal'],
                'iva' => $totalizar['iva'],
                'total' => $totalizar['total'],
                'delivery' => $totalizar['delivery'],
                'label_delivery' => "$ " . formatoMillares($totalizar['delivery'], 2),
                'label_subtotal' => "$ " . formatoMillares($totalizar['subtotal'], 2),
                'label_iva' => "$ " . formatoMillares($totalizar['iva'], 2),
                'label_total' => "$ " . formatoMillares($totalizar['total'], 2),
            ];

        }

        if ($opcion == "select-delivery") {

            $zona_id = $request->zona;

            $this->editarZonas($zona_id);

            $totalizar = $this->totalizar(Auth::id());

            $json = [
                'type' => 'success',
                'message' => "Delivery Actualizado.",
                'subtotal' => $totalizar['subtotal'],
                'iva' => $totalizar['iva'],
                'total' => $totalizar['total'],
                'delivery' => $totalizar['delivery'],
                'label_delivery' => "$ " . formatoMillares($totalizar['delivery'], 2),
                'label_subtotal' => "$ " . formatoMillares($totalizar['subtotal'], 2),
                'label_iva' => "$ " . formatoMillares($totalizar['iva'], 2),
                'label_total' => "$ " . formatoMillares($totalizar['total'], 2),
            ];
        }

        if ($opcion == "btn-procesar") {

            $this->dbPedido();

            //dd($this->dbPedido(Auth::id())->id);

            $listarCarrito = Carrito::where('users_id', Auth::id())
                ->where('estatus', 0)
                ->get();
            $listarCarrito->each(function ($carrito) {
                $id_producto = $carrito->stock->productos_id;
                $cantidad = $carrito->cantidad;
                $pvp = $carrito->stock->pvp;
                $precio = calcularPrecio($carrito->stock_id, $pvp);
                $iva = calcularPrecio($carrito->stock_id, $pvp, true);
                $carrito->iva = $iva * $cantidad;
                $carrito->subtotal = ($precio - $iva) * $cantidad;
                $carrito->total = $precio * $cantidad;

                $procesar = Carrito::find($carrito->id);
                $procesar->precio_dolar = $this->dollar();
                $procesar->precio_stock = $precio;
                $procesar->total = $carrito->total;
                $procesar->iva = $carrito->iva;
                $procesar->subtotal = $carrito->subtotal;
                $procesar->estatus = 1;
                $procesar->pedidos_id = $this->dbPedido(Auth::id())->id;
                $procesar->update();
            });

            $delivery = Delivery::where('users_id', Auth::id())
                ->where('estatus', 0)
                ->first();
            if ($delivery) {
                $delivery->precio_dolar = $this->dollar();
                $delivery->precio_delivery = $delivery->zona->precio;
                $delivery->bs = $delivery->zona->precio * $this->dollar();
                $delivery->nombre = $delivery->zona->nombre;
                $delivery->estatus = 1;
                $delivery->pedidos_id = $this->dbPedido(Auth::id())->id;
                $delivery->update();
            }

            $totalizar = $this->totalizar(Auth::id(), 1, $this->dbPedido(Auth::id())->id);

            $pedido = Pedido::find($this->dbPedido(Auth::id())->id);

            $parametro = Parametro::where('nombre', 'codigo_pedido')->first();
            if ($parametro) {
                $codigo = $parametro->valor . "" . cerosIzquierda($pedido->id, $parametro->tabla_id);
            } else {
                $codigo = cerosIzquierda($pedido->id, 6);
            }
            $pedido->numero = $codigo;
            $pedido->subtotal = $totalizar['subtotal'];
            $pedido->iva = $totalizar['iva'];
            $pedido->delivery = $totalizar['delivery'];
            $pedido->total = $totalizar['total'];
            $pedido->bs = $totalizar['total'] * $this->dollar();
            $pedido->update();

            $json = [
                'type' => 'success',
                'id' => $pedido->id
            ];


        }

        return response()->json($json);
    }

    public function editarZonas($zona_id)
    {
        if ($zona_id != "vacia") {

            $delivery = Delivery::where('users_id', Auth::id())
                ->where('estatus', 0)
                ->first();
            if ($delivery) {
                $delivery->zonas_id = $zona_id;
                $delivery->update();
            } else {
                $delivery = new Delivery();
                $delivery->users_id = Auth::id();
                $delivery->zonas_id = $zona_id;
                $delivery->save();
            }

        } else {
            $delivery = Delivery::where('users_id', Auth::id())
                ->where('estatus', 0)
                ->first();
            if ($delivery) {
                $delivery->delete();
            }
        }
    }

    public function dollar()
    {
        $parametro = Parametro::where('nombre', 'precio_dolar')->first();
        if ($parametro) {
            $precio_dolar = $parametro->valor;
        } else {
            $precio_dolar = 1;
        }
        return $precio_dolar;
    }

    public function dbPedido($id = false)
    {
        if ($id) {
            $pedido = Pedido::where('users_id', $id)
                ->where('estatus', 0)
                ->orderBy('id', 'DESC')
                ->first();
        } else {
            $pedido = new Pedido();
            $pedido->fecha = date('Y-m-d');
            $pedido->precio_dolar = $this->dollar();
            $pedido->users_id = Auth::id();
            $pedido->save();
        }

        return $pedido;
    }

    public function cliente(Request $request)
    {
        $cedula = $request->cedula;
        $cliente = Cliente::where('cedula', $cedula)
            ->where('users_id', Auth::id())
            ->first();
        if ($cliente) {
            $type = 'success';
            $message = 'Cedula Encontrada';
            $nombre = $cliente->nombre;
            $telefono = $cliente->telefono;
            $direccion_1 = $cliente->direccion_1;
            $direccion_2 = $cliente->direccion_2;
            $email = $cliente->email;
            $opcion = $cliente->id;
        } else {
            $type = 'info';
            $message = 'Cedula Nueva';
            $nombre = null;
            $telefono = null;
            $direccion_1 = null;
            $direccion_2 = null;
            $email = null;
            $opcion = 'create';
        }

        $json = [
            'type' => $type,
            'message' => $message,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion_1' => $direccion_1,
            'direccion_2' => $direccion_2,
            'email' => $email,
            'opcion' => $opcion
        ];
        return response()->json($json);
    }

    public function metodo(Request $request)
    {
        $id_parametro = $request->id_parametro;
        $bs = $request->bs;

        if ($id_parametro == "") {
            $valor = null;
        } else {
            $parametro = Parametro::find($id_parametro);
            if ($parametro->valor == "efectivo_bs" || $parametro->valor == "efectivo_dolares" || $parametro->valor == "debito") {
                $valor = "efectivo";
            } else {
                $valor = $parametro->valor;
            }
        }

        switch ($valor) {
            case "efectivo":
                $type = "success";
                $message = "Metodo Pago Actualizado.";
                $label = "";
                $div = "quitar";
                $requerido = 'no';
                break;
            case "transferencia":
                $label = '';
                $cuentas = Cuenta::where('tipo', '!=', 'PAGO_MOVIL')->get();
                foreach ($cuentas as $cuenta) {
                    $label .= '<p class="text-center col-md-6">';
                    $label .= 'Banco: <strong class="text-bold text-dark text-xl-center">' . $cuenta->banco . '</strong><br>';
                    $label .= '# <strong class="text-bold text-dark text-xl-center">' . $cuenta->numero . '</strong> <br>';
                    $label .= 'Cuenta: <strong class="text-bold text-dark text-xl-center">' . $cuenta->tipo . '</strong><br>';
                    $label .= 'Titular: <strong class="text-bold text-dark text-xl-center">' . $cuenta->titular . '</strong><br>';
                    $label .= 'Rif: <strong class="text-bold text-dark text-xl-center">' . $cuenta->rif . '</strong>';
                    $label .= '</p>';
                }
                $type = "success";
                $message = "Metodo Pago Actualizado.";
                $div = "mostrar";
                $requerido = 'si';
                break;
            case "movil":
                $label = '';
                $cuentas = Cuenta::where('tipo', 'PAGO_MOVIL')->get();
                foreach ($cuentas as $cuenta) {
                    $label .= '<p class="text-center col-md-6">';
                    $label .= 'Pago Movil <br>';
                    $label .= '<strong class="text-bold text-dark text-xl-center">Pagar <span class="text-danger">' . $cuenta->banco . '</span></strong>';
                    $label .= ' <strong class="text-bold text-dark text-xl-center">' . $cuenta->numero . '</strong>';
                    $label .= ' <strong class="text-bold text-dark text-xl-center"><span class="text-danger">' . $cuenta->rif . '</span></strong>';
                    $label .= ' <strong class="text-bold text-dark text-xl-center">' . formatoMillares($bs, 2) . '</strong>';
                    $label .= '</p>';
                }

                $type = "success";
                $message = "Metodo Pago Actualizado.";
                $div = "mostrar";
                $requerido = 'no';
                break;
            default:
                $type = 'warning';
                $message = "Debes seleccionar un metodo de pago";
                $div = "quitar";
                $label = "";
                $requerido = 'no';
                break;
        }
        $json = [
            'type' => $type,
            'message' => $message,
            'div' => $div,
            'label' => $label,
            'requerido' => $requerido
        ];
        return response()->json($json);
    }

    public function procesarPedido(Request $request)
    {
        $cedula = $request->cedula;
        $opcion = $request->opcion;
        $nombre = $request->nombre;
        $telefono = $request->telefono;
        $direccion_1 = $request->direccion_1;
        $direccion_2 = $request->direccion_2;
        $email = $request->email;
        $metodo = $request->metodo;
        $comprobante = $request->comprobante;
        $requerido = $request->requerido;
        $id_pedido = $request->id_pedido;

        $procesar = true;

        $alert_cedula = false;
        $alert_nombre = false;
        $alert_telefono = false;
        $alert_direccion_1 = false;
        $alert_metodo = false;
        $alert_comprobante = false;

        if ($cedula == "") {
            $alert_cedula = true;
            $procesar = false;
        }
        if ($nombre == "") {
            $alert_nombre = true;
            $procesar = false;
        }
        if ($telefono == "") {
            $alert_telefono = true;
            $procesar = false;
        }
        if ($direccion_1 == "") {
            $alert_direccion_1 = true;
            $procesar = false;
        }

        if ($metodo == "") {
            $alert_metodo = true;
            $procesar = false;
        }

        if ($requerido == "si") {
            if ($comprobante == "") {
                $alert_comprobante = true;
                $procesar = false;
            }
        }

        $pedido = Pedido::find($id_pedido);

        if ($procesar) {

            if ($pedido->estatus > 0) {

                if ($pedido->estatus == 4) {

                    if ($pedido->comprobante_pago == $comprobante) {
                        $type = 'warning';
                        $message = "Esta mandando el mismo comprobante. Verifique!";
                    } else {
                        $type = 'warning';
                        $message = "nuevo comprobante";

                        if ($opcion == "create") {
                            $cliente = new Cliente();
                            $cliente->cedula = strtoupper($cedula);
                            $cliente->nombre = strtoupper($nombre);
                            $cliente->telefono = strtoupper($telefono);
                            $cliente->direccion_1 = strtoupper($direccion_1);
                            $cliente->direccion_2 = strtoupper($direccion_2);
                            $cliente->email = strtolower($email);
                            $cliente->users_id = Auth::id();
                            $cliente->save();
                        } else {
                            $cliente = Cliente::find($opcion);
                            $cliente->cedula = strtoupper($cedula);
                            $cliente->nombre = strtoupper($nombre);
                            $cliente->telefono = strtoupper($telefono);
                            $cliente->direccion_1 = strtoupper($direccion_1);
                            $cliente->direccion_2 = strtoupper($direccion_2);
                            $cliente->email = strtolower($email);
                            $cliente->users_id = Auth::id();
                            $cliente->update();
                        }


                        $pedido->cedula = strtoupper($cedula);
                        $pedido->nombre = strtoupper($nombre);
                        $pedido->telefono = strtoupper($telefono);
                        $pedido->direccion_1 = strtoupper($direccion_1);
                        $pedido->direccion_2 = strtoupper($direccion_2);
                        $pedido->email = strtolower($email);
                        $pedido->metodo_pago = $metodo;
                        $pedido->comprobante_pago = strtoupper($comprobante);
                        $pedido->estatus = 1;
                        $pedido->update();
                        $type = "success";
                        $message = "Procesar";
                    }

                } else {
                    $type = 'warning';
                    $message = "Este pedido ya fue procesado anteriormente.";
                }


            } else {

                if ($opcion == "create") {
                    $cliente = new Cliente();
                    $cliente->cedula = strtoupper($cedula);
                    $cliente->nombre = strtoupper($nombre);
                    $cliente->telefono = strtoupper($telefono);
                    $cliente->direccion_1 = strtoupper($direccion_1);
                    $cliente->direccion_2 = strtoupper($direccion_2);
                    $cliente->email = strtolower($email);
                    $cliente->users_id = Auth::id();
                    $cliente->save();
                } else {
                    $cliente = Cliente::find($opcion);
                    $cliente->cedula = strtoupper($cedula);
                    $cliente->nombre = strtoupper($nombre);
                    $cliente->telefono = strtoupper($telefono);
                    $cliente->direccion_1 = strtoupper($direccion_1);
                    $cliente->direccion_2 = strtoupper($direccion_2);
                    $cliente->email = strtolower($email);
                    $cliente->users_id = Auth::id();
                    $cliente->update();
                }


                $pedido->cedula = strtoupper($cedula);
                $pedido->nombre = strtoupper($nombre);
                $pedido->telefono = strtoupper($telefono);
                $pedido->direccion_1 = strtoupper($direccion_1);
                $pedido->direccion_2 = strtoupper($direccion_2);
                $pedido->email = strtolower($email);
                $pedido->metodo_pago = $metodo;
                $pedido->comprobante_pago = strtoupper($comprobante);
                $pedido->estatus = 1;
                $pedido->update();
                $type = "success";
                $message = "Procesar";

            }


        } else {
            $type = 'warning';
            $message = "Algunos campos son requeridos.";
        }


        $json = [
            'type' => $type,
            'message' => $message,
            'alert_cedula' => $alert_cedula,
            'alert_nombre' => $alert_nombre,
            'alert_telefono' => $alert_telefono,
            'alert_direccion_1' => $alert_direccion_1,
            'alert_metodo' => $alert_metodo,
            'alert_comprobante' => $alert_comprobante,
            'id' => $id_pedido
        ];
        return response()->json($json);
    }

    public function showPedido(Request $request)
    {
        $label = '';
        $id_pedido = $request->id_pedido;

        $pedido = Pedido::find($id_pedido);
        $numero = $pedido->numero;
        $fecha = $pedido->fecha;
        $precio_dolar = $pedido->precio_dolar;
        $subtotal = $pedido->subtotal;
        $iva = $pedido->iva;
        $delivery = $pedido->delivery;
        $total = $pedido->total;
        $bs = $pedido->bs;
        $estatus = $pedido->estatus;
        $cedula = $pedido->cedula;
        $nombre = $pedido->nombre;
        $telefono = $pedido->telefono;
        $direccion_1 = $pedido->direccion_1;
        $direccion_2 = $pedido->direccion_2;
        $email = $pedido->email;
        $metodo_pago = $pedido->metodo_pago;
        $pago_validado = $pedido->pago_validado;
        $comprobante_pago = $pedido->comprobante_pago;

        $listarCarrito = Carrito::where('pedidos_id', $pedido->id)->get();
        foreach ($listarCarrito as $carrito){
            $label .= '<div class="d-flex justify-content-between">';
            $label .= '<p>'.$carrito->stock->producto->nombre.'';
            $label .= '<small>(x'.formatoMillares($carrito->cantidad, 0).')</small>';
            $label .= '</p>';
            $label .= '<p>$'.formatoMillares($carrito->total, 2).'</p>';
            $label .= '</div>';
        }

        if ($delivery > 0.0){
            $mostrarDelivery = true;
        }else{
            $mostrarDelivery = false;
        }

        $mostrarEstatus = '';

        switch ($estatus){
            case 1:
                $mostrarEstatus = '<span class="text-info"><i class="fas fa-money-bill-wave"></i> Pedido en espera de la verificacion del pago.</span>';
            break;
            case 2:
                $mostrarEstatus = '<span class="text-info"><i class="fa fa-truck"></i> Pedido en proceso de despacho.</span>';
            break;
            case 3:
                $mostrarEstatus = '<span class="text-success"><i class="fa fa-check"></i> Pedido entregado.</span>';
            break;
            case 4:
                $mostrarEstatus = '<span class="text-danger"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> Pago NO Validado.</span>';
            break;
            default:
                $mostrarEstatus = '<span class="text-warning"><i class="far fa-address-card"></i> Pedido pendiente.</span>';
            break;
        }

        if ($metodo_pago){
            $parametro = Parametro::find($metodo_pago);
            $valor = $parametro->valor;
            $metodo = str_replace('_', ' ', $parametro->valor);
            if ($valor == "efectivo_bs" || $valor == "efectivo_dolares"){
                $pedido->icono_metodo = "efectivo";
                $efectivo = explode('_', $valor);
                $metodo = 'EFECTIVO '.$efectivo[1];
                $mostrarComprobante = false;
            }else{
                $pedido->icono_metodo = $valor;
                $mostrarComprobante = true;
            }
        }else{
            $metodo = "Pendiente";
            $mostrarComprobante = false;
        }
        $label_metodo = strtoupper($metodo);

        $json = [
            'type' => 'success',
            'message' => 'Mostrando Pedido #: '.$numero,
            'id_pedido' => $pedido->id,
            'numero' => $numero,
            'fecha' => $fecha,
            'precio_dolar' => $precio_dolar,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'delivery' => $delivery,
            'mostrar_delivery' => $mostrarDelivery,
            'total' => $total,
            'bs' => $bs,
            'estatus' => $estatus,
            'mostrar_estatus' => $mostrarEstatus,
            'cedula' => $cedula,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion_1' => $direccion_1,
            'direccion_2' => $direccion_2,
            'email' => $email,
            'metodo_pago' => $metodo_pago,
            'label_metodo' => $label_metodo,
            'pago_validado' => $pago_validado,
            'comprobante_pago' => $comprobante_pago,
            'mostrar_comprobante' => $mostrarComprobante,
            'productos' => $label,
        ];

        return response()->json($json);
    }

    public function corregirMetodo(Request $request)
    {
        $id_parametro = $request->id_parametro;

        if ($id_parametro == "") {
            $valor = null;
        } else {
            $parametro = Parametro::find($id_parametro);
            if ($parametro->valor == "efectivo_bs" || $parametro->valor == "efectivo_dolares" || $parametro->valor == "debito") {
                $valor = "efectivo";
            } else {
                $valor = $parametro->valor;
            }
        }

        switch ($valor) {
            case "efectivo":
                $type = "success";
                $message = "Metodo Pago Actualizado.";
                $label = "";
                $div = "quitar";
                $requerido = 'no';
                break;
            case "transferencia":
                $type = "success";
                $message = "Metodo Pago Actualizado.";
                $div = "mostrar";
                $requerido = 'si';
                break;
            case "movil":
                $type = "success";
                $message = "Metodo Pago Actualizado.";
                $div = "mostrar";
                $requerido = 'no';
                break;
            default:
                $type = 'warning';
                $message = "Debes seleccionar un metodo de pago";
                $div = "quitar";
                $label = "";
                $requerido = 'no';
                break;
        }
        $json = [
            'type' => $type,
            'message' => $message,
            'div' => $div,
            'requerido' => $requerido
        ];
        return response()->json($json);
    }

    public function corregirPagoPedido(Request $request)
    {
        $metodo = $request->metodo;
        $comprobante = $request->comprobante;
        $requerido = $request->requerido;
        $id_pedido = $request->id_pedido;

        $procesar = true;

        $alert_metodo = false;
        $alert_comprobante = false;

        if ($metodo == "") {
            $alert_metodo = true;
            $procesar = false;
        }

        if ($requerido == "si") {
            if ($comprobante == "") {
                $alert_comprobante = true;
                $procesar = false;
            }
        }

        $pedido = Pedido::find($id_pedido);

        if ($procesar) {

            if ($pedido->comprobante_pago == $comprobante) {
                $type = 'warning';
                $message = "¡Esta mandando el mismo comprobante. Verifique!";
            } else {
                $pedido->metodo_pago = $metodo;
                $pedido->comprobante_pago = strtoupper($comprobante);
                $pedido->estatus = 1;
                $pedido->update();
                $type = "success";
                $message = "Procesar";
            }

        } else {
            $type = 'warning';
            $message = "Algunos campos son requeridos.";
        }

        $json = [
            'type' => $type,
            'message' => $message,
            'alert_metodo' => $alert_metodo,
            'alert_comprobante' => $alert_comprobante,
            'id' => $id_pedido
        ];
        return response()->json($json);
    }

    public function buscarPedido(Request $request)
    {
        $label = '';
        $buscar = $request->buscar;

        $pedido = Pedido::where('numero', $buscar)->where('users_id', Auth::id())->first();
        if ($pedido){

            $numero = $pedido->numero;
            $fecha = $pedido->fecha;
            $precio_dolar = $pedido->precio_dolar;
            $subtotal = $pedido->subtotal;
            $iva = $pedido->iva;
            $delivery = $pedido->delivery;
            $total = $pedido->total;
            $bs = $pedido->bs;
            $estatus = $pedido->estatus;
            $cedula = $pedido->cedula;
            $nombre = $pedido->nombre;
            $telefono = $pedido->telefono;
            $direccion_1 = $pedido->direccion_1;
            $direccion_2 = $pedido->direccion_2;
            $email = $pedido->email;
            $metodo_pago = $pedido->metodo_pago;
            $pago_validado = $pedido->pago_validado;
            $comprobante_pago = $pedido->comprobante_pago;

            $listarCarrito = Carrito::where('pedidos_id', $pedido->id)->get();
            foreach ($listarCarrito as $carrito){
                $label .= '<div class="d-flex justify-content-between">';
                $label .= '<p>'.$carrito->stock->producto->nombre.'';
                $label .= '<small>(x'.formatoMillares($carrito->cantidad, 0).')</small>';
                $label .= '</p>';
                $label .= '<p>$'.formatoMillares($carrito->total, 2).'</p>';
                $label .= '</div>';
            }

            if ($delivery > 0.0){
                $mostrarDelivery = true;
            }else{
                $mostrarDelivery = false;
            }

            $mostrarEstatus = '';

            switch ($estatus){
                case 1:
                    $mostrarEstatus = '<span class="text-info"><i class="fas fa-money-bill-wave"></i> Pedido en espera de la verificacion del pago.</span>';
                    break;
                case 2:
                    $mostrarEstatus = '<span class="text-info"><i class="fa fa-truck"></i> Pedido en proceso de despacho.</span>';
                    break;
                case 3:
                    $mostrarEstatus = '<span class="text-success"><i class="fa fa-check"></i> Pedido entregado.</span>';
                    break;
                case 4:
                    $mostrarEstatus = '<span class="text-danger"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> Pago NO Validado.</span>';
                    break;
                default:
                    $mostrarEstatus = '<span class="text-warning"><i class="far fa-address-card"></i> Pedido pendiente.</span>';
                    break;
            }

            if ($metodo_pago){
                $parametro = Parametro::find($metodo_pago);
                $valor = $parametro->valor;
                $metodo = str_replace('_', ' ', $parametro->valor);
                if ($valor == "efectivo_bs" || $valor == "efectivo_dolares"){
                    $pedido->icono_metodo = "efectivo";
                    $efectivo = explode('_', $valor);
                    $metodo = 'EFECTIVO '.$efectivo[1];
                    $mostrarComprobante = false;
                }else{
                    $pedido->icono_metodo = $valor;
                    $mostrarComprobante = true;
                }
            }else{
                $metodo = "Pendiente";
                $mostrarComprobante = false;
            }
            $label_metodo = strtoupper($metodo);

            $json = [
                'type' => 'success',
                'message' => 'Mostrando Pedido #: '.$numero,
                'id_pedido' => $pedido->id,
                'numero' => $numero,
                'fecha' => $fecha,
                'precio_dolar' => $precio_dolar,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'delivery' => $delivery,
                'mostrar_delivery' => $mostrarDelivery,
                'total' => $total,
                'bs' => $bs,
                'estatus' => $estatus,
                'mostrar_estatus' => $mostrarEstatus,
                'cedula' => $cedula,
                'nombre' => $nombre,
                'telefono' => $telefono,
                'direccion_1' => $direccion_1,
                'direccion_2' => $direccion_2,
                'email' => $email,
                'metodo_pago' => $metodo_pago,
                'label_metodo' => $label_metodo,
                'pago_validado' => $pago_validado,
                'comprobante_pago' => $comprobante_pago,
                'mostrar_comprobante' => $mostrarComprobante,
                'productos' => $label,
            ];

        }else{

            $json = [
                'type' => 'warning',
                'message' => 'Pedido #: <span class="text-danger">'.strtoupper($buscar).'</span>',
                'text' => 'NO encontrado en la lista de Tus Pedidos.',
            ];

        }


        return response()->json($json);
    }

}
