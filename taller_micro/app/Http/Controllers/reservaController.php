<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


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



    $hoy = Carbon::now()->toDateString(); // Fecha actual
    $rows = Reserva::all(); // Traer todas las reservas

    foreach ($rows as $row) {
        // Verificar y actualizar el estado automáticamente
        if ($hoy == $row->fecha_inicio) {
            $row->estado = 'activa';
        } elseif ($hoy > $row->fecha_fin) {
            $row->estado = 'finalizada';
        } else {
            $row->estado = 'pendiente'; // o 'programada', según tus reglas
        }

        $row->save(); // Guardar los cambios en la base de datos

        // Agregar información extra para la respuesta
        $vehiculo = Vehiculo::find($row->vehiculo_id);
        $cliente = Cliente::find($row->cliente_id);

        $row['nombreVehiculo'] = $vehiculo ? $vehiculo->categoria : '';
        $row['nombreCliente'] = $cliente ? $cliente->nombre : '';
    }

    return response()->json(['data' => $rows], 200);
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
    public function actualizarEstadosPorFecha()
{
    $hoy = Carbon::now()->toDateString(); // Fecha actual
    $rows = Reserva::all(); // Obtener todas las reservas

    foreach ($rows as $row) {
        if ($hoy == $row->fecha_inicio) {
            $row->estado = 'activa';
        } elseif ($hoy > $row->fecha_fin) {
            $row->estado = 'finalizada';
        } else {
            $row->estado = 'pendiente';
        }

        $row->save();
    }

    return response()->json(['mensaje' => 'Estados actualizados correctamente'], 200);
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


    public function disponiblesPorFecha(Request $request)
{
    $fecha = $request->query('fecha'); // Obtener la fecha desde la URL (?fecha=...)

    if (!$fecha) {
        return response()->json(['message' => 'Fecha requerida'], 400);
    }

    // Vehículos ya reservados ese día
    $reservados = Reserva::whereDate('fecha_inicio', '<=', $fecha)
        ->whereDate('fecha_fin', '>=', $fecha)
        ->pluck('vehiculo_id');

    // Filtrar los que están disponibles y no reservados
    $vehiculos = Vehiculo::where('estado', 'disponible')
        ->whereNotIn('id', $reservados)
        ->get();

    return response()->json(['data' => $vehiculos], 200);
}

public function alquiladosPorFecha(Request $request)
{
    $fecha = $request->query('fecha'); // Obtener la fecha desde la URL (?fecha=...)

    if (!$fecha) {
        return response()->json(['message' => 'Fecha requerida'], 400);
    }

    // Vehículos ya reservados ese día
    $reservados = Reserva::whereDate('fecha_inicio', '<=', $fecha)
        ->whereDate('fecha_fin', '>=', $fecha)
        ->pluck('vehiculo_id');

    // Filtrar los que están alquilados y están reservados en esa fecha
    $vehiculos = Vehiculo::where('estado', 'alquilado')
        ->whereIn('id', $reservados)
        ->get();

    return response()->json(['data' => $vehiculos], 200);
}

public function consultarPorLicencia($numero_licencia)
{
    // Buscar cliente por número de licencia
    $cliente = Cliente::where('numero_licencia', $numero_licencia)->first();

    if (!$cliente) {
        return response()->json(['mensaje' => 'Cliente no encontrado'], 404);
    }

    // Obtener reservas con datos del vehículo usando join
    $reservas = Reserva::select('reservas.id', 'vehiculos.marca', 'vehiculos.modelo', 'reservas.fecha_inicio', 'reservas.fecha_fin', 'reservas.estado')
        ->join('vehiculos', 'reservas.vehiculo_id', '=', 'vehiculos.id')
        ->where('reservas.cliente_id', $cliente->id)
        ->get();

    if ($reservas->isEmpty()) {
        return response()->json(['mensaje' => 'No hay reservas para este cliente'], 200);
    }

    
    $respuesta = $reservas->map(function ($reserva) {
        return [
            'id' => $reserva->id,
            'vehiculo' => $reserva->marca . ' ' . $reserva->modelo,
            'fecha_inicio' => $reserva->fecha_inicio,
            'fecha_fin' => $reserva->fecha_fin,
            'estado' => $reserva->estado,
        ];
    });

    return response()->json($respuesta);
}




}
