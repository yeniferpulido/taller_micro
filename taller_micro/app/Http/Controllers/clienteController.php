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
        $rows = Cliente::all();
        $data = $request->all(); 
        $clientenuevo = true;
        foreach ($rows as $row) {
         if ($row->numero_licencia == $data['numero_licencia']) {
             $clientenuevo = false;
             break; 
           }
        }
    if ($clientenuevo) {
         $newVehiculo = new Cliente();
         $newVehiculo->nombre = $data['nombre'];
         $newVehiculo->telefono = $data['telefono'];
         $newVehiculo->correo = $data['correo'];
         $newVehiculo->numero_licencia = $data['numero_licencia'];
         $newVehiculo->save();

         return response()->json(['data' => 'Datos guardados'], 201);
     } else {
         return response()->json(['data' => 'Error: ya hay un usuario con ese numero de licencia'], 409);
    }
    
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
    public function update(Request $request, String $numero_licencia)
    {
         $cliente = Cliente::whereRaw('LOWER(numero_licencia) = ?', [strtolower($numero_licencia)])->first(); //busca el id que el usurio selecciona para consultarlo
       
         if(!$cliente){
            return response()->json(['data'=>'no existe'], 404);
        }

        $data = $request->all();
        $cliente->nombre = $data['nombre'];
        $cliente->telefono = $data['telefono'];
        $cliente->correo = $data['correo'];
        $cliente->numero_licencia = $data['numero_licencia'];
        $cliente->save();
        return response()->json(['data' => 'Cliente actualizado'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $numero_licencia)
    {
        $row = Cliente::where('numero_licencia', $numero_licencia)->first();

        if (!$row) {
            return response()->json(['data' => 'no existe'], 404);
        }

        $row->delete();
        return response()->json(['data' => 'Datos eliminados'], 200);
    }





    
    }

    /**
     * Remove the specified resource from storage.
     */
    