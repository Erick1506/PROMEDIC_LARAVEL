<?php

namespace App\Http\Controllers;

use App\Models\FormulaMedica;
use Illuminate\Http\Request;

class FormulaMedicaController extends Controller
{
    // Lista todas las fórmulas médicas
    public function index()
    {
        return FormulaMedica::all();
    }

    // Registra una nueva fórmula médica
    public function store(Request $request)
    {
        $data = $request->validate([
            'Nombre_Paciente' => 'nullable|string|max:45',
            'Identificacion_Paciente' => 'nullable|integer',
            'Fecha_Insercion' => 'nullable|date',
            'Id_Administrador' => 'nullable|integer|exists:administrador,Id_Administrador',
            'Imagen' => 'required|string|max:500',
        ]);

        $formulaMedica = FormulaMedica::create($data);

        return response()->json($formulaMedica, 201);
    }

    // Muestra una fórmula médica por ID
    public function show($id)
    {
        return FormulaMedica::findOrFail($id);
    }

    // Actualiza una fórmula médica existente
    public function update(Request $request, $id)
    {
        $formulaMedica = FormulaMedica::findOrFail($id);

        $data = $request->validate([
            'Nombre_Paciente' => 'nullable|string|max:45',
            'Identificacion_Paciente' => 'nullable|integer',
            'Fecha_Insercion' => 'nullable|date',
            'Id_Administrador' => 'nullable|integer|exists:administrador,Id_Administrador',
            'Imagen' => 'required|string|max:500',
        ]);

        $formulaMedica->update($data);

        return response()->json($formulaMedica);
    }

    // Elimina una fórmula médica por ID
    public function destroy($id)
    {
        FormulaMedica::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
