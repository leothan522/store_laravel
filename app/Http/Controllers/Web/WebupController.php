<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Categoria;
use App\Models\Delivery;
use App\Models\Empresa;
use App\Models\Parametro;
use App\Models\Producto;
use App\Models\Stock;
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

    public function index()
    {

        /*$categorias = Categoria::where('tipo', 0)->orderBy('nombre')->get();
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
        });*/

        $categorias = $this->navCategorias();

        /*$destacados = Stock::orderBy('stock_vendido', 'DESC')
            ->where('estatus', 1)
            ->where('stock_disponible', '>', 0)
            ->limit(8)
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
        });*/

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

        /*$productos = Producto::where('categorias_id', $categoria->id)->paginate(12);
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
        });*/

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

}
