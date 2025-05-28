<?php

use App\Http\Controllers\vehiculoController;
use App\Http\Controllers\reservaController;
use App\Http\Controllers\clienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(vehiculoController::class)->group(function(){
    Route::get('vehiculos', 'index'); //ver vehiculo-obtiene los datos de la tabla reservass
    Route::post('vehiculos', 'store'); //crearvehiculo-configurando la url 
    Route::get('vehiculos/disponible', 'showbyestado'); //vervehiculosdisponibles-muestra los vehiculos disponibles
    //Route::get('vehiculos/{id}', 'show'); //mostrarvehiculoporid-obtener el los datos de la reservas a parrtir del id
    Route::put('vehiculos/{categoria}', 'update'); // actualizarvehiculoporplaca-buscar la parsona para modificar a partir del id
    Route::delete('vehiculos/{categoria}', 'destroy'); // borra datos, buscandolo con el id
});


Route::controller(reservaController::class)->group(function(){
    Route::get('reservas', 'index'); //obtiene los datos de la tabla reservass
    Route::post('reservas', 'store'); //configurando la url 
    Route::get('reservas/{id}', 'show'); // obtener el los datos de la reservas a parrtir del id
    Route::put('reservas/{id}', 'update'); // buscar la parsona para modificar a partir del id
    Route::delete('reservas/{id}', 'destroy'); // borra datos, buscandolo con el id
});

Route::controller(clienteController::class)->group(function(){
    Route::get('clientes', 'index'); //obtiene los datos de la tabla clientes
    Route::post('clientes', 'store'); //configurando la url 
    Route::get('clientes/{id}', 'show'); // obtener el los datos de la clientes a parrtir del id
    Route::put('clientes/{id}', 'update'); // buscar la parsona para modificar a partir del id
    Route::delete('clientes/{id}', 'destroy'); // borra datos, buscandolo con el id
});