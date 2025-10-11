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
Route::delete('proveedor/{proveedor}/eliminar', [App\Http\Controllers\ProveedorController::class, 'deleteProveedor'])->name('proveedor.delete');
#Se agrega la ruta de recursos para el controldor de creacion de categorias
Route::resource('categoria', App\Http\Controllers\CategoriaController::class);
Route::delete('categoria/{categoria}/eliminar', [App\Http\Controllers\CategoriaController::class, 'deteleCategoria'])->name('categoria.delete');
#Se agrega la ruta de recursos para el controldor de creacion de productos
Route::resource('producto', App\Http\Controllers\ProductoController::class);
#se agrega la ruta de recursos para el controldor de creacion de ventas
Route::resource('pedido', App\Http\Controllers\PedidoController::class);
#se agrega la ruta de recursos para el controldor de creacion de detalles de ventas
Route::resource('pedido_detalle', App\Http\Controllers\PedidoDetalleController::class);

// Ruta para mostrar la vista de login y registro de clientes
Route::get('login/cliente', [App\Http\Controllers\ClienteController::class, 'loginCliente'])->name('cliente.login');
Route::post('login/cliente', [App\Http\Controllers\ClienteController::class, 'Login'])->name('cliente.login.post');

Route::get('registrar/cliente', [App\Http\Controllers\ClienteController::class, 'registerCliente'])->name('cliente.register');

Route::middleware('auth:clientes')->group(function () {
    Route::get('dashboard/', [App\Http\Controllers\ClienteController::class, 'dashboardclient'])->name('dashboardecommerce.index');
    Route::post('logout/cliente', [App\Http\Controllers\ClienteController::class, 'logout'])->name('cliente.logout');
});
