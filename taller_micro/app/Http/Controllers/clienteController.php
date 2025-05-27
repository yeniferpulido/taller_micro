<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class clienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $rows = Cliente::all();
        return response()
        ->json(['data'=>$rows], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all(); 
        $newCliente = new Cliente(); 
        $newCliente->nombre=$data['nombre']; 
        $newCliente->telefono=$data['telefono'];
        $newCliente->correo=$data['correo'];
        $newCliente->numero_licencia=$data['numero_licencia'];
        //$newCliente->created_at=$data['created_at'];
        //$newCliente->updated_at=$data['updated_at'];

        $newCliente->save();    //guardar 

        return response()->json(['data' => 'Datos guardados'], 201); // retorna un mesaje datos guardados
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $row = Cliente::find($id); //busca el id que el usurio selecciona para consultarlo
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
         $row = Cliente::find($id); //busca el id que el usurio selecciona para consultarlo
        if(empty($row)){
            return response()->json(['data'=>'no existe'], 404);

    }
        $data = $request->all();
        $row->nombre = $data['nombre'];
        $row->telefono = $data['telefono'];
        $row->correo = $data['correo'];
        $row->numero_licencia = $data['numero_licencia'];
        //$row->created_at = $data['created_at'];
        //$row->updated_at = $data['updated_at'];
        $row->save();
        return response()->json(['data' => 'Datos guardados'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $row = Cliente::find($id); //busca el id que el usurio selecciona para consultarlo
            if(empty($row)){
                return response()->json(['data'=>'no existe'], 404);
    
            }
            $row->delete();
            return response()->json(['data' => 'Datos eliminados'], 200);
    }




    
    }

    /**
     * Remove the specified resource from storage.
     */
    