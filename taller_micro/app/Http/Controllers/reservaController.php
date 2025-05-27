<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class reservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $rows = Reserva::all();
        return response()
        ->json(['data'=>$rows], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all(); //traer todos los elementos
        $newReserva = new Reserva(); //crea un objeto de la clasewReservas
        $newReserva->cliente_id=$data['cliente_id']; //  crear un registro
        $newReserva->vehiculo_id=$data['vehiculo_id'];
        $newReserva->fecha_inicio=$data['fecha_inicio'];
        $newReserva->fecha_fin=$data['fecha_fin'];
        $newReserva->estado=$data['estado'];
        //$newReserva->created_at=$data['created_at'];
        //$newReserva->updated_at=$data['updated_at'];
        $newReserva->save();    //guardar

        return response()->json(['data' => 'Datos guardados'], 201); // retorna un mesaje datos guardados
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $row = Reserva::find($id); //busca el id que el usurio selecciona para consultarlo
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
         $row = Reserva::find($id); //busca el id que el usurio selecciona para consultarlo
        if(empty($row)){
            return response()->json(['data'=>'no existe'], 404);

        }
        

        $data = $request->all();
        $row->cliente_id=$data['cliente_id'];
        $row->vehiculo_id=$data['vehiculo_id'];
        $row->fecha_inicio=$data['fecha_inicio'];
        $row->fecha_fin=$data['fecha_fin'];
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
         $row = Reserva::find($id); //busca el id que el usurio selecciona para consultarlo
            if(empty($row)){
                return response()->json(['data'=>'no existe'], 404);
    
            }
            $row->delete();
            return response()->json(['data' => 'Datos eliminados'], 200);
    }
}
