<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Delivery;
use App\Models\Empresa;
use App\Models\Parametro;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Stock;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAndroidController extends Controller
{
    public function index($id)
    {
        if (!Auth::check()) {
            $user = User::findOrFail($id);
            Auth::loginUsingId($user->id, true);
        }
        $webupcontroller = new WebupController();
        return $webupcontroller;
    }

    public function home($id)
    {
        $webController = $this->index($id);
        $favoritos =  $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();
        $destacados = $webController->productosDestacados();

        $recientes = Stock::orderBy('id', 'DESC')
            ->where('estatus', 1)
            ->where('stock_disponible', '>', 0)
            ->limit(8)
            ->get();
        $recientes->each(function ($stock){
            $favoritos = Parametro::where('nombre', 'favoritos_productos')
                ->where('tabla_id', Auth::id())
                ->where('valor', $stock->id)->first();
            if ($favoritos){
                $stock->favoritos = true;
            }else{
                $stock->favoritos = false;
            }
            $carrito = Carrito::where('stock_id', $stock->id)
                ->where('users_id', Auth::id())
                ->where('estatus', 0)->first();
            if ($carrito){
                $stock->carrito = true;
            }else{
                $stock->carrito = false;
            }
        });

        $vendor = Stock::orderBy('id', 'ASC')
            ->where('estatus', 1)
            ->where('stock_disponible', '>', 0)
            ->limit(6)
            ->get();

        /*$revisar = Stock::orderByRaw("RAND()")
            ->where('estatus', 1)
            ->where('stock_disponible', '>', 0)
            ->limit(6)
            ->get();

        $banner = Empresa::orderByRaw("RAND()")
            ->limit(2)
            ->get();*/


        return view('web_android.home.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarDestacados', $destacados)
            ->with('listarRecientes', $recientes)
            ->with('listarVendor', $vendor)
            ->with('modulo', 'home')
            /*->with('listarBanner', $banner)
            ->with('listarRevisar', $revisar)
            ->with('modulo', 'HOME')
            ->with('titulo', null)*/;

    }

    public function detalles($user, $id)
    {
        $webController = $this->index($user);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();

        $stock = Stock::find($id);
        $categoria = $stock->producto->categorias_id;

        $cart = Carrito::where('stock_id', $stock->id)
            ->where('users_id', Auth::id())
            ->where('estatus', 0)
            ->first();
        if ($cart){
            if ($stock->producto->decimales){
                $cantidad = formatoMillares($cart->cantidad, 2);
            }else{
                $cantidad = $cantidad = formatoMillares($cart->cantidad, 0);
            }
        }else{
            $cantidad = 0;
        }

        $favor = Parametro::where('nombre', 'favoritos_productos')
            ->where('tabla_id', Auth::id())
            ->where('valor', $stock->id)->first();
        if ($favor){
            $stock->favoritos = true;
        }else{
            $stock->favoritos = false;
        }

        $listarRelacionados = $webController->productosRelacionados($stock->id);

        return view('web_android.detalles.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarRelacionados', $listarRelacionados)
            ->with('stock', $stock)
            ->with('cantCarrito', $cantidad)
            ->with('categoria', $categoria)
            ->with('modulo', 'Detalles')
            ->with('titulo', $stock->producto->nombre);
    }

    public function carrito($id)
    {
        $webController = $this->index($id);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();

        $listarCarrito = Carrito::where('users_id', Auth::id())
            ->where('estatus', 0)
            ->get();
        $listarCarrito->each(function ($carrito){

            $id_producto = $carrito->stock->productos_id;
            $cantidad = $carrito->cantidad;
            $pvp = $carrito->stock->pvp;
            $precio = calcularPrecio($carrito->stock_id, $pvp);
            $iva = calcularPrecio($carrito->stock_id, $pvp, true);
            $carrito->iva = $iva * $cantidad;
            $carrito->subtotal = $cantidad * ($precio - $iva);
            $carrito->total = $precio * $cantidad;
            $carrito->item = $carrito->total;
            $carrito->precio = $precio;
        });

        $subtotal = $listarCarrito->sum('subtotal');
        $iva = $listarCarrito->sum('iva');
        $total = $listarCarrito->sum('total');

        $zonas = Zona::orderBy('nombre', 'ASC')->get();
        $zonas->each(function ($zona){
            $zona->nombre = $zona->nombre." [Costo = $".formatoMillares($zona->precio)."]";
        });

        $delivery = Delivery::where('users_id', Auth::id())
            ->where('estatus', 0)
            ->first();
        if ($delivery){
            $delivery_zona = $delivery->zonas_id;
            $delivery_nombre = $delivery->zona->nombre." [Costo = $".formatoMillares($delivery->zona->precio)."]";
            $delivery_precio = $delivery->zona->precio;
        }else{
            $delivery_zona = null;
            $delivery_nombre = null;
            $delivery_precio = 0;
        }

        $total = $total + $delivery_precio;


        return view('web_android.carrito.index')
            ->with('ruta', "android")
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCarrito', $listarCarrito)
            ->with('subtotal', $subtotal)
            ->with('iva', $iva)
            ->with('total', $total)
            ->with('listarZonas', $zonas)
            ->with('delivery_zona', $delivery_zona)
            ->with('delivery_nombre', $delivery_nombre)
            ->with('delivery_precio', $delivery_precio)
            ->with('modulo', 'Carrito de compras')
            ->with('titulo', 'Carrito de compras')
            ;
    }

    public function checkout($user, $id = null)
    {
        $webController = $this->index($user);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();

        $pedido = Pedido::findOrFail($id);

        if ($pedido->estatus > 0 && $pedido->estatus != 4){
            return redirect()->route('web.pedidos', $pedido->id);
        }

        $listarCarrito = Carrito::where('pedidos_id', $pedido->id)->get();
        $listarMetodos = Parametro::where('nombre', 'metodo_pago')->where('tabla_id', 1)->get();
        $listarMetodos->each(function ($parametro){
            $nombre = str_replace("_", " ", $parametro->valor);
            if ($parametro->valor == 'movil'){
                $nombre = "pago movil";
            }
            $parametro->metodo = ucwords($nombre);
        });

        if ($pedido->metodo_pago){
            $parametro = Parametro::find($pedido->metodo_pago);
            $nombre = str_replace("_", " ", $parametro->valor);
            if ($parametro->valor == 'movil'){
                $nombre = "pago movil";
            }
            $pedido->revisar = $nombre;
        }

        if ($pedido->cedula){
            $cliente = Cliente::where('cedula', $pedido->cedula)->first();
            $pedido->cliente_id = $cliente->id;
        }

        $dolarParametro = Parametro::where('nombre', 'precio_dolar')->first();
        if ($dolarParametro){
            $precio_dolar = floatval($dolarParametro->valor);
        }else{
            $precio_dolar = 1;
        }

        //dd($precio_dolar);

        if ($precio_dolar != floatval($pedido->precio_dolar)){
            $pedido->precio_dolar = $precio_dolar;
            $pedido->bs = $pedido->total * $precio_dolar;
            $pedido->update();
        }


        return view('web_android.checkout.index')
            ->with('ruta', "android")
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('modulo', 'Checkout')
            ->with('titulo', 'Facturación')
            ->with('pedido', $pedido)
            ->with('listarCarrito', $listarCarrito)
            ->with('listarMetodos', $listarMetodos)
            ;

    }

    public function finalizado($user, $id = null)
    {
        $webController = $this->index($user);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();

        if (is_null($id)){

            $pedido = null;
            $listarCarrito = null;
            $view = 'web_android.pedidos.index';

        }else{

            $pedido = Pedido::findOrFail($id);

            if ($pedido->users_id == Auth::id()){
                if ($pedido->estatus == 0){
                    return redirect()->route('android.checkout', [Auth::id(), $pedido->id]);
                }
                $listarCarrito = Carrito::where('pedidos_id', $pedido->id)->get();
                $listarMetodos = Parametro::where('nombre', 'metodo_pago')->where('tabla_id', 1)->get();
            }else{
                return redirect()->route('android.pedidos', Auth::id());
            }

            $view = 'web_android.pedidos.finalizado';
        }

        $listarPedidos = Pedido::where('users_id', Auth::id())
            ->orderBy('numero', 'DESC')
            ->paginate(25);

        $listarMetodos = Parametro::where('nombre', 'metodo_pago')->where('tabla_id', 1)->get();
        $listarMetodos->each(function ($parametro){
            $nombre = str_replace("_", " ", $parametro->valor);
            if ($parametro->valor == 'movil'){
                $nombre = "pago movil";
            }
            $parametro->metodo = ucwords($nombre);
        });



        return view($view)
            ->with('ruta', "android")
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('modulo', 'pedidos')
            ->with('titulo', 'Tus Pedidos')
            ->with('pedido', $pedido)
            ->with('listarCarrito', $listarCarrito)
            ->with('listarPedidos', $listarPedidos)
            ->with('listarMetodos', $listarMetodos)
            ;

    }

    public function pedidos($user, $id = null)
    {
        $webController = $this->index($user);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();

        if (is_null($id)){

            $pedido = null;
            $listarCarrito = null;
            $view = 'web_android.pedidos.index';

        }else{

            $pedido = Pedido::findOrFail($id);

            if ($pedido->users_id == Auth::id()){
                if ($pedido->estatus == 0){
                    return redirect()->route('android.checkout', [Auth::id(), $pedido->id]);
                }
                $listarCarrito = Carrito::where('pedidos_id', $pedido->id)->get();
                $parametro = Parametro::find($pedido->metodo_pago);
                $nombre = str_replace("_", " ", $parametro->valor);
                if ($parametro->valor == 'movil'){
                    $nombre = "pago movil";
                }
                $pedido->metodo = ucwords($nombre);
            }else{
                return redirect()->route('android.pedidos', Auth::id());
            }

            $view = 'web_android.pedidos.verpedido';
        }

        $listarPedidos = Pedido::where('users_id', Auth::id())
            ->orderBy('numero', 'DESC')
            ->paginate(25);

        $listarMetodos = Parametro::where('nombre', 'metodo_pago')->where('tabla_id', 1)->get();
        $listarMetodos->each(function ($parametro){
            $nombre = str_replace("_", " ", $parametro->valor);
            if ($parametro->valor == 'movil'){
                $nombre = "pago movil";
            }
            $parametro->metodo = ucwords($nombre);
        });



        return view($view)
            ->with('ruta', "android")
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('modulo', 'pedidos')
            ->with('titulo', 'Tus Pedidos')
            ->with('pedido', $pedido)
            ->with('listarCarrito', $listarCarrito)
            ->with('listarPedidos', $listarPedidos)
            ->with('listarMetodos', $listarMetodos)
            ;

    }

    public $arrayFavoritos = array();
    public $arrayTiendas = array();

    public function favoritos($id)
    {
        $webController = $this->index($id);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();
        //$verFavoritos = null;

        $listarFavoritos = Parametro::where('nombre', 'favoritos_productos')
            ->where('tabla_id', Auth::id())
            ->get();
        //dd($listarFavoritos->count());
        if ($listarFavoritos->count()){
            $listarFavoritos->each(function ($parametro){
                $ultimos = Stock::orderBy('id', 'DESC')
                    //->where('estatus', 1)
                    //->where('stock_disponible', '>', 0)
                    ->where('id', $parametro->valor)
                    ->get();
                $ultimos->each(function ($stock){
                    array_push($this->arrayFavoritos, $stock->id);
                });
            });

            foreach ($this->arrayFavoritos as $key => $id) {
                $stock = Stock::find($id);
                if ($stock->estatus == 0 || $stock->stock_disponible <= 0){
                    $estatus = true;
                }else{
                    $estatus = false;
                }
                $verFavoritos[$key] = collect(array(
                    'id'            => $stock->id,
                    'miniatura'     => $stock->producto->miniatura,
                    'nombre'        => $stock->producto->nombre,
                    'producto_id'   => $stock->id,
                    'pvp'           => $stock->pvp,
                    'moneda'        => '$',//$stock->empresa->moneda,
                    'estatus'       => $estatus
                ));
            }
        }else{
            $verFavoritos = null;
        }


        $listarFavoritos = Parametro::where('nombre', 'favoritos_tiendas')
            ->where('tabla_id', Auth::id())
            ->get();
        //dd($listarFavoritos->count());
        if ($listarFavoritos->count()){
            $listarFavoritos->each(function ($parametro){
                $ultimos = Stock::orderBy('id', 'DESC')
                    //->where('estatus', 1)
                    //->where('stock_disponible', '>', 0)
                    ->where('id', $parametro->valor)
                    ->get();
                $ultimos->each(function ($stock){
                    array_push($this->arrayTiendas, $stock->id);
                });
            });

            foreach ($this->arrayTiendas as $key => $id) {
                $stock = Stock::find($id);
                $verTiendas[$key] = collect(array(
                    'id'            => $stock->empresas_id,
                    'miniatura'     => $stock->empresa->miniatura,
                    'nombre'        => $stock->empresa->nombre,
                ));
            }
        }else{
            $verTiendas = null;
        }


        return view('web_android.favoritos.index')
            ->with('ruta', 'android')
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('modulo', 'Favoritos')
            ->with('titulo', 'Favoritos')
            ->with('listarFavoritos', $verFavoritos)
            ->with('listarTiendas', $verTiendas);
    }

    public function categorias($user, $id = null)
    {
        $webController = $this->index($user);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();
        $listarCategorias = $webController->navCategorias();

        if (is_null($id)){
            $categoria = null;
            $productos = null;
        }else{
            $categoria = Categoria::find($id);
            $productos = $webController->productosCategoria($categoria->id);
        }

        return view('web_android.categorias.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $listarCategorias)
            ->with('listarProductos', $productos)
            ->with('categoria', $categoria)
            ->with('modulo', 'Categorias')
            ->with('titulo', 'Categorias');
    }

    public function busqueda($id, Request $request)
    {
        $webController = $this->index($id);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();
        $destacados = $webController->productosDestacados();

        $productos = Producto::where('nombre', 'LIKE', "%$request->buscar%")->paginate(30);
        $productos->each(function ($producto){
            $stock = Stock::where('productos_id', $producto->id)
                /*->where('stock_disponible', '>', 0)
                ->where('estatus', 1)*/
                ->get();
            $producto->stock = $stock;
        });


        return view('web_android.busqueda.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarDestacados', $destacados)
            ->with('modulo', $request->buscar)
            ->with('titulo', 'Busqueda')
            ->with('listarProductos', $productos)
            ;

    }

    public function tiendas($user, $id = null)
    {
        $webController = $this->index($user);
        $favoritos = $webController->headerFavoritos();
        $carrito = $webController->headerCarrito();

        $listarCategorias = Empresa::orderBy('nombre', 'ASC')->get();

        if (is_null($id)){
            $categoria = null;
        }else{
            $categoria = Empresa::find($id);
        }

        return view('web_android.tiendas.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $listarCategorias)
            ->with('categoria', $categoria)
            ->with('modulo', 'Tienda')
            ->with('titulo', 'Tienda');
    }



}
