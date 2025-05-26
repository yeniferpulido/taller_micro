<?php

use App\Http\Controllers\vechiculoController;
use App\Http\Controllers\reservaController;
use App\Http\Controllers\clienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(vechiculoController::class)->group(function(){
    route::get('vehiculos', 'index'); //obtiene los datos de la tabla reservass
    route::post('vehiculos', 'store'); //configurando la url 
    route::get('vehiculos/{id}', 'show'); // obtener el los datos de la reservas a parrtir del id
    route::put('vehiculos/{id}', 'update'); // buscar la parsona para modificar a partir del id
    route::delete('vehiculos/{id}', 'destroy'); // borra datos, buscandolo con el id
});

Route::controller(reservaController::class)->group(function(){
    route::get('reservas', 'index'); //obtiene los datos de la tabla reservass
    route::post('reservas', 'store'); //configurando la url 
    route::get('reservas/{id}', 'show'); // obtener el los datos de la reservas a parrtir del id
    route::put('reservas/{id}', 'update'); // buscar la parsona para modificar a partir del id
    route::delete('reservas/{id}', 'destroy'); // borra datos, buscandolo con el id
});

Route::controller(clienteController::class)->group(function(){
    route::get('clientes', 'index'); //obtiene los datos de la tabla clientes
    route::post('clientes', 'store'); //configurando la url 
    route::get('clientes/{id}', 'show'); // obtener el los datos de la clientes a parrtir del id
    route::put('clientes/{id}', 'update'); // buscar la parsona para modificar a partir del id
    route::delete('clientes/{id}', 'destroy'); // borra datos, buscandolo con el id
});