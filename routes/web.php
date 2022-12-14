<?php

use App\Http\Controllers\Web\AjaxController;
use App\Http\Controllers\Web\AjaxupController;
use App\Http\Controllers\Web\AppController;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Web\WebupController;
use App\Http\Controllers\Web\WebAndroidController;
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
    //return view('layouts.multishop.master_android');
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
Route::get('guest/{id}/detalles', [WebupController::class, 'guestDetalles'])->name('guest.detalles');
Route::get('guest/{id}/categorias', [WebupController::class, 'guestCategorias'])->name('guest.categorias');
Route::get('/busqueda', [WebupController::class, 'busqueda'])->name('web.busqueda');


Route::get('{id}/tienda', [WebController::class, 'verTienda'])->name('web.tienda');
//Route::get('/web', [WebController::class, 'index'])->name('web.index');
//Route::get('guest/{id}/detalles', [WebController::class, 'guestDetalles'])->name('guest.detalles');
//Route::get('guest/{id}/categorias', [WebController::class, 'guestCategorias'])->name('guest.categorias');
//Route::get('/busqueda', [WebController::class, 'verBusqueda'])->name('web.busqueda');

Route::get('/perfil', function (){
    return view('profile.show_default');
})->name('web.perfil')->middleware('auth');

Route::middleware(['auth', 'verified'])->prefix('/web')->group(function (){

    Route::post('/ajax/favoritos', [AjaxupController::class, 'favoritos'])->name('ajax.favoritos');
    Route::post('/ajax/carrito', [AjaxupController::class, 'carrito'])->name('ajax.carrito');
    Route::post('/ajax/cliente', [AjaxupController::class, 'cliente'])->name('ajax.cliente');
    Route::post('/ajax/metodo', [AjaxupController::class, 'metodo'])->name('ajax.metodo');
    Route::post('/ajax/corregir/metodo', [AjaxupController::class, 'corregirMetodo'])->name('ajax.corregir_metodo');
    Route::post('/ajax/pedido', [AjaxupController::class, 'procesarPedido'])->name('ajax.pedido');
    Route::post('/ajax/guardar/metodo', [AjaxupController::class, 'corregirPagoPedido'])->name('ajax.guardar_metodo');
    Route::post('/ajax/show', [AjaxupController::class, 'showPedido'])->name('ajax.show_pedido');
    Route::post('/ajax/buscar/pedido', [AjaxupController::class, 'buscarPedido'])->name('ajax.buscar_pedido');

    Route::get('/home', [WebupController::class, 'home'])->name('web.home');
    Route::get('/carrito', [WebupController::class, 'carrito'])->name('web.carrito');
    Route::get('/{id}/detalles', [WebupController::class, 'detalles'])->name('web.detalles');
    Route::get('/{id}/categorias', [WebupController::class, 'categorias'])->name('web.categorias');
    Route::get('/favoritos', [WebupController::class, 'favoritos'])->name('web.favoritos');
    Route::get('/checkout/{id?}', [WebupController::class, 'checkout'])->name('web.checkout');
    Route::get('/verpedidos/{id?}', [WebupController::class, 'pedidos'])->name('web.pedidos');

    //Route::get('/home', [WebController::class, 'home'])->name('web.home');
    //Route::get('/carrito', [WebController::class, 'verCarrito'])->name('web.carrito');
    //Route::get('/{id}/detalles', [WebController::class, 'verDetalles'])->name('web.detalles');
    //Route::get('/{id}/categorias', [WebController::class, 'verCategorias'])->name('web.categorias');
    //Route::get('/favoritos', [WebController::class, 'verFavoritos'])->name('web.favoritos');
    //Route::get('/checkout/{id?}', [WebController::class, 'verCheckout'])->name('web.checkout');
    //Route::get('/verpedidos/{id?}', [WebController::class, 'verPedidos'])->name('web.pedidos');


});

Route::middleware(['android'])->prefix('/android')->group(function (){

    Route::get('/{user}/home', [WebAndroidController::class, 'home'])->name('android.home');
    //Route::get('/{user}/home', [AppController::class, 'home'])->name('android.home');
    Route::get('/{user}/{id}/detalles', [WebAndroidController::class, 'detalles'])->name('android.detalles');
    //Route::get('/{user}/{id}/detalles', [AppController::class, 'verDetalles'])->name('android.detalles');
    Route::get('/{user}/carrito', [WebAndroidController::class, 'carrito'])->name('android.carrito');
    //Route::get('/{user}/carrito', [AppController::class, 'verCarrito'])->name('android.carrito');
    Route::get('/{user}/checkout/{id?}', [WebAndroidController::class, 'checkout'])->name('android.checkout');
    //Route::get('/{user}/checkout/{id?}', [AppController::class, 'verCheckout'])->name('android.checkout');
    Route::get('/{user}/finalizado/{id?}', [WebAndroidController::class, 'finalizado'])->name('android.finalizado');
    Route::get('/{user}/verpedidos/{id?}', [WebAndroidController::class, 'pedidos'])->name('android.pedidos');
    //Route::get('/{user}/verpedidos/{id?}', [AppController::class, 'verPedidos'])->name('android.pedidos');
    Route::get('/{user}/categorias/{id?}', [WebAndroidController::class, 'categorias'])->name('android.categorias');
    //Route::get('/{user}/{id}/categorias', [AppController::class, 'verCategorias'])->name('android.categorias');
    Route::get('/{user}/favoritos', [WebAndroidController::class, 'favoritos'])->name('android.favoritos');
    //Route::get('/{user}/favoritos', [AppController::class, 'verFavoritos'])->name('android.favoritos');
    Route::get('/{user}/busqueda', [WebAndroidController::class, 'busqueda'])->name('android.busqueda');
    //Route::get('/{user}/busqueda', [AppController::class, 'verBusqueda'])->name('android.busqueda');
    Route::get('/{user}/atiendas/{id?}', [WebAndroidController::class, 'tiendas'])->name('android.tienda');
    //Route::get('/{user}/{id}/tienda', [AppController::class, 'verTienda'])->name('android.tienda');
    //Route::get('/{user}/listarcategorias/', [AppController::class, 'listarCategorias'])->name('android.listar_categorias');
    //Route::get('/{user}/listartiendas/', [AppController::class, 'listarTiendas'])->name('android.listar_tiendas');

});

