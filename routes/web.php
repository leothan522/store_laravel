<?php

use App\Http\Controllers\Web\AjaxController;
use App\Http\Controllers\Web\AjaxupController;
use App\Http\Controllers\Web\AppController;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Web\WebupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
    //return view('web_up.home.index');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'isadmin'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
});


Route::get('/cerrar', function () {
    Auth::logout();
    return redirect()->route('web.index');
})->name('cerrar');


Route::get('/web', [WebupController::class, 'index'])->name('web.index');
//Route::get('/web', [WebController::class, 'index'])->name('web.index');
Route::get('guest/{id}/detalles', [WebupController::class, 'guestDetalles'])->name('guest.detalles');
//Route::get('guest/{id}/detalles', [WebController::class, 'guestDetalles'])->name('guest.detalles');
Route::get('guest/{id}/categorias', [WebupController::class, 'guestCategorias'])->name('guest.categorias');
//Route::get('guest/{id}/categorias', [WebController::class, 'guestCategorias'])->name('guest.categorias');
Route::get('/busqueda', [WebController::class, 'verBusqueda'])->name('web.busqueda');
Route::get('{id}/tienda', [WebController::class, 'verTienda'])->name('web.tienda');

Route::get('/perfil', function (){
    return view('profile.show_default');
})->name('web.perfil')->middleware('auth');

Route::middleware(['auth', 'verified'])->prefix('/web')->group(function (){

    Route::post('/ajax/favoritos', [AjaxupController::class, 'favoritos'])->name('ajax.favoritos');
    Route::post('/ajax/carrito', [AjaxupController::class, 'carrito'])->name('ajax.carrito');
    Route::post('/ajax/cliente', [AjaxController::class, 'cliente'])->name('ajax.cliente');
    Route::post('/ajax/metodo', [AjaxController::class, 'metodo'])->name('ajax.metodo');
    Route::post('/ajax/pedido', [AjaxController::class, 'procesarPedido'])->name('ajax.pedido');

    Route::get('/home', [WebupController::class, 'home'])->name('web.home');
    //Route::get('/home', [WebController::class, 'home'])->name('web.home');
    Route::get('/carrito', [WebupController::class, 'carrito'])->name('web.carrito');
    //Route::get('/carrito', [WebController::class, 'verCarrito'])->name('web.carrito');
    Route::get('/{id}/detalles', [WebupController::class, 'detalles'])->name('web.detalles');
    //Route::get('/{id}/detalles', [WebController::class, 'verDetalles'])->name('web.detalles');
    Route::get('/{id}/categorias', [WebupController::class, 'categorias'])->name('web.categorias');
    //Route::get('/{id}/categorias', [WebController::class, 'verCategorias'])->name('web.categorias');
    Route::get('/favoritos', [WebController::class, 'verFavoritos'])->name('web.favoritos');
    Route::get('/checkout/{id?}', [WebController::class, 'verCheckout'])->name('web.checkout');
    Route::get('/verpedidos/{id?}', [WebController::class, 'verPedidos'])->name('web.pedidos');

});

Route::middleware(['android'])->prefix('/android')->group(function (){

    Route::get('/{user}/home', [AppController::class, 'home'])->name('android.home');
    Route::get('/{user}/{id}/detalles', [AppController::class, 'verDetalles'])->name('android.detalles');
    Route::get('/{user}/carrito', [AppController::class, 'verCarrito'])->name('android.carrito');
    Route::get('/{user}/{id}/categorias', [AppController::class, 'verCategorias'])->name('android.categorias');
    Route::get('/{user}/favoritos', [AppController::class, 'verFavoritos'])->name('android.favoritos');
    Route::get('/{user}/busqueda', [AppController::class, 'verBusqueda'])->name('android.busqueda');
    Route::get('/{user}/{id}/tienda', [AppController::class, 'verTienda'])->name('android.tienda');
    Route::get('/{user}/checkout/{id?}', [AppController::class, 'verCheckout'])->name('android.checkout');
    Route::get('/{user}/verpedidos/{id?}', [AppController::class, 'verPedidos'])->name('android.pedidos');
    Route::get('/{user}/listarcategorias/', [AppController::class, 'listarCategorias'])->name('android.listar_categorias');
    Route::get('/{user}/listartiendas/', [AppController::class, 'listarTiendas'])->name('android.listar_tiendas');

});

