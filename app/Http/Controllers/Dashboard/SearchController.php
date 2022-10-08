<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function showNavbarSearchResults(Request $request)
    {
        //  Comprobar que la palabra clave de búsqueda está presente.

        if (! $request->filled('searchVal')) {
            return back();
        }

        // Obtener la palabra clave de búsqueda.

        $keyword = $request->input('searchVal');

        //obtiene ruta anterior
        $route = redirect()->getUrlGenerator()->previous();

        //chequeamos las rutas
        if (strpos($route, '/dashboard/usuarios') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('usuarios.index', $keyword);
        }

        if (strpos($route, '/dashboard/parametros') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('parametros.index', $keyword);
        }

        if (strpos($route, '/dashboard/clientes') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('clientes.index', $keyword);
        }

        if (strpos($route, '/dashboard/categorias') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('categorias.index', $keyword);
        }

        if (strpos($route, '/dashboard/productos') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('productos.index', $keyword);
        }

        if (strpos($route, '/dashboard/delivery') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('delivery.index', $keyword);
        }

        if (strpos($route, '/dashboard/almacen') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('almacen.index', $keyword);
        }

        if (strpos($route, '/dashboard/stock') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('stock.index', $keyword);
        }

        if (strpos($route, '/dashboard/pedidos') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('pedidos.index', $keyword);
        }

        if (strpos($route, '/dashboard/clientes') !== false){
            //verSweetAlert2("Resultados encontrados", 'toast');
            return redirect()->route('clientes.index', $keyword);
        }

        //en caso de no encontrar ninguna ruta
        verSweetAlert2("Opcion no encontrada", 'toast');
        return back();

    }
}
