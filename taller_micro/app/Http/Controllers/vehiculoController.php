<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;


class vehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $rows = Vehiculo::all();
        return response()
        ->json(['data'=>$rows], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $rows = Vehiculo::all();
    $data = $request->all(); // Traer todos los elementos
    $placanueva = true;

    foreach ($rows as $row) {
        if (strtolower($row->categoria) == strtolower($data['categoria'])) {
        $placanueva = false;
    break;
}

    }

    if ($placanueva) {
        $newVehiculo = new Vehiculo();
        $newVehiculo->marca = $data['marca'];
        $newVehiculo->modelo = $data['modelo'];
        $newVehiculo->anio = $data['anio'];
        $newVehiculo->categoria = $data['categoria'];
        $newVehiculo->estado = $data['estado'];
        $newVehiculo->save();

        return response()->json(['data' => 'Datos guardados'], 201);
    } else {
        return response()->json(['data' => 'Error: la placa ya existe'], 409);
    }
}

    public function show(string $categoria)
    {
        $categoria = strtolower($categoria);
        $vehiculo = Vehiculo::whereRaw('LOWER(categoria) = ?', [$categoria])->first();

        if (!$vehiculo) {
            return response()->json(['data' => 'No existe'], 404);
        }

        return response()->json(['data' => $vehiculo], 200);
    }


    public function showbyestado()
    {
    $vehiculosestado = Vehiculo::where('estado', 'disponible')->get();

    if ($vehiculosestado->isEmpty()) {
        return response()->json(['data' => 'No hay vehículos disponibles'], 404);
    }

    return response()->json(['data' => $vehiculosestado], 200);
    }

    public function showbyestadoalqui()
    {
    $vehiculosestado = Vehiculo::where('estado', 'alquilado')->get();

    if ($vehiculosestado->isEmpty()) {
        return response()->json(['data' => 'No hay vehículos alquilado'], 404);
    }

    return response()->json(['data' => $vehiculosestado], 200);
    }

    public function showmantenimientoalqui()
    {
    $vehiculosestado = Vehiculo::whereIn('estado', ['alquilado', 'mantenimiento'])->get();

    if ($vehiculosestado->isEmpty()) {
        return response()->json(['data' => 'No hay vehículos alquilados ni en mantenimiento'], 404);
    }

    return response()->json(['data' => $vehiculosestado], 200);
}


    

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, string $categoria)
{
    $vehiculo = Vehiculo::whereRaw('LOWER(categoria) = ?', [strtolower($categoria)])->first();

    if (!$vehiculo) {
        return response()->json(['data' => 'No existe'], 404);
    }

    $data = $request->all();

    // Solo actualizar el estado si viene ese campo
    if (isset($data['estado']) && count($data) === 1) {
        $vehiculo->estado = $data['estado'];
        $vehiculo->save();
        return response()->json(['data' => 'Estado actualizado correctamente'], 200);
    }

    // Si vienen más campos, actualiza normalmente
    if (isset($data['marca'])) {
        $vehiculo->marca = $data['marca'];
    }

    if (isset($data['modelo'])) {
        $vehiculo->modelo = $data['modelo'];
    }

    if (isset($data['anio'])) {
        $vehiculo->anio = $data['anio'];
    }

    if (isset($data['estado'])) {
        $vehiculo->estado = $data['estado'];
    }

    $vehiculo->save();
    return response()->json(['data' => 'Vehículo actualizado correctamente'], 200);
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $categoria)
{
    // Búsqueda sin distinguir mayúsculas/minúsculas
    $vehiculo = Vehiculo::whereRaw('LOWER(categoria) = ?', [strtolower($categoria)])->first();

    if (!$vehiculo) {
        return response()->json(['data' => 'No existe vehiculo con esa placa'], 404);
    }

    $vehiculo->delete();
    return response()->json(['data' => 'Vehículo eliminado'], 200);
}



}
