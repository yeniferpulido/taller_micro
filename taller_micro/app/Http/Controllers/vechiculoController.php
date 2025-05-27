<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;


class vechiculoController extends Controller
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
        $data = $request->all(); //traer todos los elementos
        $newVehiculo = new Vehiculo();
        $newVehiculo->marca=$data['marca']; //  crear un registro
        $newVehiculo->modelo=$data['modelo'];
        $newVehiculo->anio=$data['anio'];
        $newVehiculo->categoria=$data['categoria'];
        $newVehiculo->estado=$data['estado'];
        //$newVehiculo->created_at=$data['created_at'];
        //$newVehiculo->updated_at=$data['updated_at'];
        $newVehiculo->save();    //guardar

        return response()->json(['data' => 'Datos guardados'], 201); // retorna un mesaje datos guardados
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $row = Vehiculo::find($id); //busca el id que el usurio selecciona para consultarlo
        if(empty($row)){
            return response()->json(['data'=>'no existe'], 404);

        }
        return response()->json(['data' => $row], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $row = Vehiculo::find($id); //busca el id que el usurio selecciona para consultarlo
        if(empty($row)){
            return response()->json(['data'=>'no existe'], 404);

        }

         
        $data = $request->all();
        $row->marca=$data['marca'];
        $row->modelo=$data['modelo'];
        $row->anio=$data['anio'];
        $row->categoria=$data['categoria'];
        $row->estado=$data['estado'];
        //$row->created_at=$data['created_at'];
        //$row->updated_at=$data['updated_at'];

        $row->save();
        return response()->json(['data' => 'Datos guardados'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $row = Vehiculo::find($id); //busca el id que el usurio selecciona para consultarlo
            if(empty($row)){
                return response()->json(['data'=>'no existe'], 404);
    
            }
            $row->delete();
            return response()->json(['data' => 'Datos eliminados'], 200);
    }
}
