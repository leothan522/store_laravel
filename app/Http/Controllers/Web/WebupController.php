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

class WebupController extends Controller
{
    public function headerFavoritos()
    {
        return Parametro::where('nombre', 'LIKE', "%favoritos%")->where('tabla_id', Auth::id())->count();
    }

    public function headerCarrito()
    {
        $carrito = [];
        $carritos = Carrito::where('users_id', Auth::id())->where('estatus', 0)->get();
        $suma= null;
        foreach ($carritos as $cart){
            $precio = calcularPrecio($cart->stock_id, $cart->stock->pvp);
            $suma = $suma + ($precio * $cart->cantidad);
        }

        $delivery = Delivery::where('users_id', Auth::id())
            ->where('estatus', 0)
            ->first();
        if ($delivery){
            $zona = $delivery->zona->precio;
        }else{
            $zona = 0;
        }

        $carrito['total'] = $suma + $zona;
        $carrito['items'] = $carritos->sum('cantidad');
        $carrito['ruta'] = 'web';
        return $carrito;
    }

    public function navCategorias()
    {
        $categorias = Categoria::where('tipo', 0)->orderBy('nombre')->get();
        $categorias->each(function ($categoria){
            $productos = Producto::where('categorias_id', $categoria->id)->get();
            $productos->each(function ($producto){
                $existencias = Stock::where('estatus', 1)
                    ->where('stock_disponible', '>', 0)
                    ->where('productos_id', $producto->id)
                    ->first();
                if ($existencias){
                    $producto->cantidad = 1;
                }
            });
            $categoria->cantidad  = $productos->sum('cantidad');
        });
        return $categorias;
    }

    public function productosDestacados()
    {
        $destacados = Stock::orderBy('stock_vendido', 'DESC')
            ->where('estatus', 1)
            ->where('stock_disponible', '>', 0)
            ->limit(12)
            ->get();
        $destacados->each(function ($stock){
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

        return $destacados;
    }

    public function productosCategoria($categorias_id)
    {
        $productos = Producto::where('categorias_id', $categorias_id)->paginate(12);
        $productos->each(function ($producto){
            $destacados = Stock::orderBy('stock_vendido', 'DESC')
                ->where('estatus', 1)
                ->where('stock_disponible', '>', 0)
                ->where('productos_id', $producto->id)
                ->get();
            $destacados->each(function ($stock){
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
                $stock->cantidad = $stock->cantidad + 1;
                $stock->empresa = Empresa::find($stock->empresas_id);
            });
            $producto->cantidad = $destacados->sum('cantidad');
            $producto->stock = $destacados;
        });
        return $productos;
    }

    public function productosRelacionados($stock_id)
    {
        $listarRelacionados = Stock::where('stock_disponible', '>', 0)
            ->where('id', '!=', $stock_id)
            ->where('estatus', '!=', 0)
            ->orderBy('stock_disponible', 'DESC')
            ->get();
        $listarRelacionados->each(function ($stock){
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
        return $listarRelacionados;
    }

    public function index()
    {
        $categorias = $this->navCategorias();
        $destacados = $this->productosDestacados();

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

        return view('web_up.home.index')
            ->with('ruta', 'web')
            ->with('headerFavoritos', 0)
            ->with('headerItems', 0)
            ->with('headerTotal', 0)
            ->with('listarCategorias', $categorias)
            ->with('listarDestacados', $destacados)
            ->with('listarRecientes', $recientes)
            ->with('listarVendor', $vendor)
            ->with('modulo', 'home')
            /*->with('listarBanner', $banner)
            ->with('listarRevisar', $revisar)
            ->with('modulo', 'HOME')
            ->with('titulo', null)*/;
    }

    public function home()
    {
        $favoritos = $this->headerFavoritos();
        $carrito = $this->headerCarrito();
        $categorias = $this->navCategorias();
        $destacados = $this->productosDestacados();

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


        return view('web_up.home.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $categorias)
            ->with('listarDestacados', $destacados)
             ->with('listarRecientes', $recientes)
            ->with('listarVendor', $vendor)
            ->with('modulo', 'home')
            /*->with('listarBanner', $banner)
            ->with('listarRevisar', $revisar)
            ->with('modulo', 'HOME')
            ->with('titulo', null)*/;

    }

    public function guestCategorias($id)
    {
        $categorias = $this->navCategorias();
        $destacados = $this->productosDestacados();

        $categoria = Categoria::find($id);
        $productos = $this->productosCategoria($categoria->id);

        /*$cantidad  = $productos->sum('cantidad');

        $ultimos = Stock::orderBy('id', 'DESC')
            ->where('estatus', 1)
            ->where('stock_disponible', '>', 0)
            ->limit(6)
            ->get();*/

        return view('web_up.categorias.index')
            ->with('ruta', 'web')
            ->with('headerFavoritos', 0)
            ->with('headerItems', 0)
            ->with('headerTotal', 0)
            ->with('listarCategorias', $categorias)
            ->with('listarDestacados', $destacados)
            ->with('listarProductos', $productos)
            ->with('categoria', $categoria)
            ->with('modulo', 'Categorias')
            ->with('titulo', $categoria->nombre)
            /*->with('cantidad', $cantidad)
            ->with('listarUltimos', $ultimos)*/;
    }

    public function categorias($id)
    {
        $favoritos = $this->headerFavoritos();
        $carrito = $this->headerCarrito();
        $categorias = $this->navCategorias();
        $destacados = $this->productosDestacados();

        $categoria = Categoria::find($id);

        $productos = $this->productosCategoria($categoria->id);

        /*$cantidad  = $productos->sum('cantidad');

        $ultimos = Stock::orderBy('id', 'DESC')
            ->where('estatus', 1)
            ->where('stock_disponible', '>', 0)
            ->limit(6)
            ->get();*/


        return view('web_up.categorias.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $categorias)
            ->with('listarDestacados', $destacados)
            ->with('listarProductos', $productos)
            ->with('categoria', $categoria)
            ->with('modulo', 'Categorias')
            ->with('titulo', $categoria->nombre)
            /*->with('cantidad', $cantidad)
            ->with('listarUltimos', $ultimos)*/;
    }

    public function guestDetalles($id)
    {
        $categorias = $this->navCategorias();

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

        $listarRelacionados = $this->productosRelacionados($stock->id);

        return view('web_up.detalles.index')
            ->with('ruta', 'web')
            ->with('headerFavoritos', 0)
            ->with('headerItems', 0)
            ->with('headerTotal', 0)
            ->with('listarCategorias', $categorias)
            ->with('listarRelacionados', $listarRelacionados)
            ->with('stock', $stock)
            ->with('cantCarrito', $cantidad)
            ->with('categoria', $categoria)
            ->with('modulo', 'Detalles')
            ->with('titulo', $stock->producto->nombre);
    }

    public function detalles($id)
    {
        $favoritos = $this->headerFavoritos();
        $carrito = $this->headerCarrito();
        $categorias = $this->navCategorias();

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

        $listarRelacionados = $this->productosRelacionados($stock->id);

        return view('web_up.detalles.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $categorias)
            ->with('listarRelacionados', $listarRelacionados)
            ->with('stock', $stock)
            ->with('cantCarrito', $cantidad)
            ->with('categoria', $categoria)
            ->with('modulo', 'Detalles')
            ->with('titulo', $stock->producto->nombre);
    }


    public function carrito()
    {
        $favoritos = $this->headerFavoritos();
        $carrito = $this->headerCarrito();
        $categorias = $this->navCategorias();

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


        return view('web_up.carrito.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $categorias)
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

    public function checkout($id = null)
    {
        $favoritos = $this->headerFavoritos();
        $carrito = $this->headerCarrito();
        $categorias = $this->navCategorias();

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


        return view('web_up.checkout.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $categorias)
            ->with('modulo', 'Checkout')
            ->with('titulo', 'Facturaci??n')
            ->with('pedido', $pedido)
            ->with('listarCarrito', $listarCarrito)
            ->with('listarMetodos', $listarMetodos)
            ;

    }

    public function pedidos($id = null)
    {
        $favoritos = $this->headerFavoritos();
        $carrito = $this->headerCarrito();
        $categorias = $this->navCategorias();

        if (is_null($id)){
            $pedido = null;
            $listarCarrito = null;
        }else{
            $pedido = Pedido::findOrFail($id);

            if ($pedido->users_id == Auth::id() && $pedido->estatus == 1){
                if ($pedido->estatus == 0){
                    return redirect()->route('web.checkout', $pedido->id);
                }
                $listarCarrito = Carrito::where('pedidos_id', $pedido->id)->get();
                $listarMetodos = Parametro::where('nombre', 'metodo_pago')->where('tabla_id', 1)->get();
            }else{
                return redirect()->route('web.pedidos');
            }
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


        return view('web_up.pedidos.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $categorias)
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

    public function favoritos()
    {

        $favoritos = $this->headerFavoritos();
        $carrito = $this->headerCarrito();
        $categorias = $this->navCategorias();
        $destacados = $this->productosDestacados();
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


        return view('web_up.favoritos.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $categorias)
            ->with('listarDestacados', $destacados)
            ->with('modulo', 'Favoritos')
            ->with('titulo', 'Favoritos')
            ->with('listarFavoritos', $verFavoritos)
            ->with('listarTiendas', $verTiendas);
    }

    public function busqueda(Request $request)
    {
        $favoritos = $this->headerFavoritos();
        $carrito = $this->headerCarrito();
        $categorias = $this->navCategorias();
        $destacados = $this->productosDestacados();

        $productos = Producto::where('nombre', 'LIKE', "%$request->buscar%")->paginate(30);
        $productos->each(function ($producto){
            $stock = Stock::where('productos_id', $producto->id)
                /*->where('stock_disponible', '>', 0)
                ->where('estatus', 1)*/
                ->get();
            $producto->stock = $stock;
        });


        return view('web_up.busqueda.index')
            ->with('ruta', $carrito['ruta'])
            ->with('headerFavoritos', $favoritos)
            ->with('headerItems', $carrito['items'])
            ->with('headerTotal', $carrito['total'])
            ->with('listarCategorias', $categorias)
            ->with('listarDestacados', $destacados)
            ->with('modulo', $request->buscar)
            ->with('titulo', 'Busqueda')
            ->with('listarProductos', $productos)
            ;

    }



}
