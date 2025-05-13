<?php

namespace App\Http\Controllers;

use App\Models\Regente;
use Illuminate\Http\Request;

class RegenteController extends Controller
{
    // Lista todos los regentes
    public function index()
    {
        return Regente::all();
    }

    // Crea un nuevo regente
    public function store(Request $request)
    {
        $data = $request->validate([
            'Nombre' => 'nullable|string|max:45',
            'Apellido' => 'nullable|string|max:45',
            'DNI' => 'nullable|integer',
            'Fecha_Contratacion' => 'nullable|date',
            'Licencia' => 'nullable|integer',
            'Correo' => 'nullable|string|email|max:45',
            'Telefono' => 'nullable|numeric',
            'Contraseña_Encriptada' => 'required',
            'Id_Turno' => 'nullable|integer|exists:turno_regente,Id_Turno',
            'token_recuperacion' => 'nullable|string|max:255',
            'token_expiracion' => 'nullable|date',
        ]);

        $regente = Regente::create($data);

        return response()->json($regente, 201);
    }

    // Muestra un regente por ID
    public function show($id)
    {
        return Regente::findOrFail($id);
    }

    // Actualiza un regente existente
    public function update(Request $request, $id)
    {
        $regente = Regente::findOrFail($id);

        $data = $request->validate([
            'Nombre' => 'nullable|string|max:45',
            'Apellido' => 'nullable|string|max:45',
            'DNI' => 'nullable|integer',
            'Fecha_Contratacion' => 'nullable|date',
            'Licencia' => 'nullable|integer',
            'Correo' => 'nullable|string|email|max:45',
            'Telefono' => 'nullable|numeric',
            'Contraseña_Encriptada' => 'sometimes|required',
            'Id_Turno' => 'nullable|integer|exists:turno_regente,Id_Turno',
            'token_recuperacion' => 'nullable|string|max:255',
            'token_expiracion' => 'nullable|date',
        ]);

        $regente->update($data);

        return response()->json($regente);
    }

    // Elimina un regente por ID
    public function destroy($id)
    {
        Regente::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
