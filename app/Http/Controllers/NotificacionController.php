<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    // Lista todas las notificaciones
    public function index()
    {
        return Notificacion::all();
    }

    // Crea una nueva notificación
    public function store(Request $request)
    {
        $data = $request->validate([
            'mensaje' => 'required|string',
            'fecha_creacion' => 'nullable|date',
        ]);

        $notificacion = Notificacion::create($data);

        return response()->json($notificacion, 201);
    }

    // Muestra una notificación por ID
    public function show($id)
    {
        return Notificacion::findOrFail($id);
    }

    // Actualiza una notificación existente
    public function update(Request $request, $id)
    {
        $notificacion = Notificacion::findOrFail($id);

        $data = $request->validate([
            'mensaje' => 'required|string',
            'fecha_creacion' => 'nullable|date',
        ]);

        $notificacion->update($data);

        return response()->json($notificacion);
    }

    // Elimina una notificación por ID
    public function destroy($id)
    {
        Notificacion::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
