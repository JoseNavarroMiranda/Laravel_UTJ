<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::pattern('cliente', '[0-9]+');

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
#Vista para imprimir archivos pdf 
Route::get('imprimir/proveedores', [App\Http\Controllers\GeneradorController::class, 'printproveedor'])->name('plantillapdf.proveedorpdf');
Route::get('imprimir/clientes', [App\Http\Controllers\GeneradorController::class, 'printcliente'])->name('plantillapdf.clientepdf');




// Ruta para mostrar la vista de login y registro de clientes
Route::get('login/cliente', [App\Http\Controllers\ClienteController::class, 'loginCliente'])->name('cliente.login');
Route::post('login/cliente', [App\Http\Controllers\ClienteController::class, 'Login'])->name('cliente.login.post');
Route::get('cliente/forgot-password', [App\Http\Controllers\ClienteAuth\ClientePasswordResetLinkController::class, 'create'])
    ->name('cliente.password.request');
Route::post('cliente/forgot-password', [App\Http\Controllers\ClienteAuth\ClientePasswordResetLinkController::class, 'store'])
    ->name('cliente.password.email');
Route::get('cliente/reset-password/{token}', [App\Http\Controllers\ClienteAuth\ClienteNewPasswordController::class, 'create'])
    ->name('cliente.password.reset');
Route::post('cliente/reset-password', [App\Http\Controllers\ClienteAuth\ClienteNewPasswordController::class, 'store'])
    ->name('cliente.password.update');
Route::get('dashboard/', [App\Http\Controllers\ClienteController::class, 'dashboardclient'])->name('dashboardecommerce.index');
Route::get('registrar/cliente', [App\Http\Controllers\ClienteController::class, 'registerCliente'])->name('cliente.register');

//Ruta para vista de carrito y detalle 
Route::get('/carrito', [App\Http\Controllers\CartController::class, 'showcart'])->name('carrito.detalle');
Route::post('/carrito/agregar', [App\Http\Controllers\CartController::class, 'addacart'])->name('carrito.agregar');
Route::put('/carrito/items/{item}', [App\Http\Controllers\CartController::class, 'update'])->name('carrito.actualizar');
Route::delete('/carrito/items/{item}', [App\Http\Controllers\CartController::class, 'destroy'])->name('carrito.eliminar');


//Rutas para vistas de productos
Route::get('dashboard/producto', [App\Http\Controllers\ProductoController::class, 'showProducto'])->name('productosdash.produco');

//Ruta para envio de correos
Route::get('/correo-prueba', [App\Http\Controllers\CorreoController::class, 'enviarPrueba']);


//Rutas de vistas que son necesarias middleware/autenticacion de por medio 
Route::middleware('auth:clientes')->group(function () {
    Route::post('logout/cliente', [App\Http\Controllers\ClienteController::class, 'logout'])->name('cliente.logout');
});
