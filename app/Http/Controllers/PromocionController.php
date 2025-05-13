<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PromocionService;
use App\Models\Producto;

class PromocionController extends Controller
{
    protected $promocionService;

    public function __construct(PromocionService $promocionService)
    {
        $this->promocionService = $promocionService;
    }

    public function index()
    {
        return response()->json($this->promocionService->listar());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Id_Administrador' => 'nullable|integer|exists:administrador,Id_Administrador',
            'Id_Producto' => 'required|integer|exists:producto,Id_Producto',
            'Id_Tipo_Promocion' => 'required|integer|exists:tipo_promocion,Id_Tipo_Promocion',
            'Fecha_Inicio' => 'nullable|date',
            'Fecha_Fin' => 'nullable|date',
            'Descuento' => 'required_if:Id_Tipo_Promocion,2|integer',
        ]);

        $promocion = $this->promocionService->crear($data);

        return response()->json($promocion, 201);
    }

    public function storeFromProducto($idProducto, Request $request)
    {
        $producto = Producto::first($idProducto);

        $data = $request->validate([
            'Id_Tipo_Promocion' => 'required|integer|exists:tipo_promocion,Id_Tipo_Promocion',
            'Fecha_Inicio' => 'nullable|date',
            'Fecha_Fin' => 'nullable|date',
            'Descuento' => 'required_if:Id_Tipo_Promocion,2|integer',
        ]);

        $promocion = $this->promocionService->crearDesdeProducto($producto, $data);

        if ($promocion) {
            return response()->json($promocion, 201);
        }

        return response()->json(['message' => 'No se pudo crear la promoción.'], 400);
    }

    public function show($id)
    {
        return response()->json($this->promocionService->mostrar($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'Id_Administrador' => 'nullable|integer|exists:administrador,Id_Administrador',
            'Id_Producto' => 'nullable|integer|exists:producto,Id_Producto',
            'Id_Tipo_Promocion' => 'nullable|integer|exists:tipo_promocion,Id_Tipo_Promocion',
            'Fecha_Inicio' => 'nullable|date',
            'Fecha_Fin' => 'nullable|date',
            'Descuento' => 'required_if:Id_Tipo_Promocion,2|integer',
        ]);

        $promocion = $this->promocionService->actualizar($id, $data);

        return response()->json($promocion);
    }

    public function destroy($id)
    {
        $this->promocionService->eliminar($id);

        return response()->json(null, 204);
    }
}
