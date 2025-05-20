<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PromocionService;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\TipoPromocion;
use App\Models\clasificacion;


class PromocionController extends Controller
{
    protected $promocionService;

    public function __construct(PromocionService $promocionService)
    {
        $this->promocionService = $promocionService;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $promociones = $this->promocionService->listar();
        // Filtrar las promociones si hay un término de búsqueda
        if ($searchTerm) {
            $promociones = $promociones->filter(function ($promocion) use ($searchTerm) {
                return stripos($promocion->producto->Nombre_Producto, $searchTerm) !== false ||
                    stripos($promocion->Id_Promocion, $searchTerm) !== false;
            });
        }
        return view('promociones.index', compact('promociones', 'searchTerm'));
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

        if (!empty($data['Fecha_Inicio']) && !empty($data['Fecha_Fin'])) {
            if ($data['Fecha_Fin'] < $data['Fecha_Inicio']) {
                return redirect()->back()->withInput()->withErrors([
                    'Fecha_Fin' => 'La fecha de fin no puede ser anterior a la fecha de inicio.',
                ]);
            }
        }

        $resultado = $this->promocionService->crear($data);

        if ($resultado['status'] === 'error') {
            return redirect()->back()->withInput()->withErrors(['msg' => $resultado['message']]);
        }

        return redirect()->route('promociones.index')->with('msg', 'Promoción creada exitosamente.');
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

    public function create()
    {
        $categorias = Categoria::all(); // Obtener todas las categorías
        $clasificaciones = Clasificacion::all(); // Obtener todas las clasificaciones
        $tipos = TipoPromocion::all(); // Obtener todos los tipos de promoción
        $productos = Producto::all(); // Obtener todos los productos

        return view('promociones.create', compact('categorias', 'tipos', 'clasificaciones', 'productos'));
    }

}
