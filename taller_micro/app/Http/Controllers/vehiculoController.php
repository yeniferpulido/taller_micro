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
        if ($row->categoria == $data['categoria']) {
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
    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $row = Vehiculo::find($id); //busca el id que el usurio selecciona para consultarlo
    //     if(empty($row)){
    //         return response()->json(['data'=>'no existe'], 404);

    //     }
    //     return response()->json(['data' => $row], 200);
    // }

    public function showbyestado()
    {
    $vehiculosestado = Vehiculo::where('estado', 'disponible')->get();

    if ($vehiculosestado->isEmpty()) {
        return response()->json(['data' => 'No hay vehículos disponibles'], 404);
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
    $vehiculo->marca = $data['marca'];
    $vehiculo->modelo = $data['modelo'];
    $vehiculo->anio = $data['anio'];
    
    $vehiculo->estado = $data['estado'];
    $vehiculo->save();

    return response()->json(['data' => 'Vehículo actualizado'], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $categoria)
{
    // Búsqueda sin distinguir mayúsculas/minúsculas
    $vehiculo = Vehiculo::whereRaw('LOWER(categoria) = ?', [strtolower($categoria)])->first();

    if (!$vehiculo) {
        return response()->json(['data' => 'No existe'], 404);
    }

    $vehiculo->delete();
    return response()->json(['data' => 'Vehículo eliminado'], 200);
}

}
