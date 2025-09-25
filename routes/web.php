<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
#Se agrega la ruta de recursos para el controldor de creacion dew clientes
Route::resource('cliente', App\Http\Controllers\ClienteController::class);
