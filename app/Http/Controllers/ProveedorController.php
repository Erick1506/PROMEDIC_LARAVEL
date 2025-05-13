<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // Lista todos los proveedores
    public function index()
    {
        return Proveedor::all();
    }

    // Crea un nuevo proveedor
    public function store(Request $request)
    {
        $data = $request->validate([
            'Nombre_Proveedor' => 'nullable|string|max:45',
            'Direccion_Proveedor' => 'nullable|string|max:45',
            'Correo' => 'nullable|string|email|max:45',
            'Telefono' => 'nullable|numeric',
            'Id_Administrador' => 'nullable|integer|exists:administrador,Id_Administrador',
        ]);

        $proveedor = Proveedor::create($data);

        return response()->json($proveedor, 201);
    }

    // Muestra un proveedor por ID
    public function show($id)
    {
        return Proveedor::findOrFail($id);
    }

    // Actualiza un proveedor existente
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $data = $request->validate([
            'Nombre_Proveedor' => 'nullable|string|max:45',
            'Direccion_Proveedor' => 'nullable|string|max:45',
            'Correo' => 'nullable|string|email|max:45',
            'Telefono' => 'nullable|numeric',
            'Id_Administrador' => 'nullable|integer|exists:administrador,Id_Administrador',
        ]);

        $proveedor->update($data);

        return response()->json($proveedor);
    }

    // Elimina un proveedor por ID
    public function destroy($id)
    {
        Proveedor::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
