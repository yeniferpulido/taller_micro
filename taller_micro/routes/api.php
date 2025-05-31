<?php

use App\Http\Controllers\vehiculoController;
use App\Http\Controllers\reservaController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\ReservasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(vehiculoController::class)->group(function(){
    Route::get('vehiculos', 'index'); //ver vehiculo-obtiene los datos de la tabla reservass
    Route::post('vehiculos', 'store'); //crearvehiculo-configurando la url 
    Route::get('vehiculos/disponible', 'showbyestado'); //vervehiculosdisponibles-muestra los vehiculos disponibles
    Route::get('vehiculos/alquilado', 'showbyestadoalqui'); //vervehiculosdisponibles-muestra los vehiculos disponibles
    Route::get('vehiculos/alqmant', 'showmantenimientoalqui'); 
    Route::put('vehiculos/{categoria}', 'update'); // actualizarvehiculoporplaca-buscar la parsona para modificar a partir del id
    Route::delete('vehiculos/{categoria}', 'destroy'); // borra datos, buscandolo con el id
});


Route::controller(reservaController::class)->group(function(){
    Route::get('reservas', 'index'); 
    Route::get('/vehiculos/disponibles-por-fecha', 'disponiblesPorFecha'); 
    Route::get('/vehiculos/alquilados-por-fecha', 'alquiladosPorFecha'); 
    Route::get('reservas/{numero_licencia}',  'consultarPorLicencia');
    Route::get('reservas/activas/{numero_licencia}', 'consultarReservasActivasPorLicencia');  
    Route::post('reservas', 'store'); 
    Route::get('reservas/{id}', 'show'); 
    Route::put('/reservas/actualizar-estados', 'actualizarEstadosPorFecha'); 
    Route::put('reservas/{id}/cancelar', 'cancelarReserva');
});



Route::controller(clienteController::class)->group(function(){
    Route::get('clientes', 'index'); //obtiene los datos de la tabla clientes
    Route::post('clientes', 'store'); //configurando la url 
    Route::get('clientes/{id}', 'show'); // obtener el los datos de la clientes a parrtir del id
    Route::put('clientes/{id}', 'update'); // buscar la parsona para modificar a partir del id
    Route::delete('clientes/{id}', 'destroy'); // borra datos, buscandolo con el id
});