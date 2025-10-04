<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
#Se agrega la ruta de recursos para el controldor de creacion de clientes
Route::resource('cliente', App\Http\Controllers\ClienteController::class);
Route::delete('cliente/{cliente}/eliminar', [App\Http\Controllers\ClienteController::class, 'deleteCliente'])->name('cliente.delete');
#Se agrega la ruta de recursos para el controldor de creacion de proveedores
Route::resource('proveedor', App\Http\Controllers\ProveedorController::class);
#Se agrega la ruta de recursos para el controldor de creacion de categorias
Route::resource('categoria', App\Http\Controllers\CategoriaController::class);
#Se agrega la ruta de recursos para el controldor de creacion de productos
Route::resource('producto', App\Http\Controllers\ProductoController::class);
#se agrega la ruta de recursos para el controldor de creacion de ventas
Route::resource('pedido', App\Http\Controllers\PedidoController::class);
#se agrega la ruta de recursos para el controldor de creacion de detalles de ventas
Route::resource('pedido_detalle', App\Http\Controllers\PedidoDetalleController::class);
