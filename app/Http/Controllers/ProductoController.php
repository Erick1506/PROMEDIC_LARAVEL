<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Services\TransaccionService;
use App\Http\Services\PromocionService;
use App\Http\Controllers\CategoriaController;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Clasificacion;
use App\Models\EstadoProducto;
use App\Models\Proveedor;
use App\Http\services\VentaProductoService;
use App\Models\TipoPromocion;

class ProductoController extends Controller
{
    protected $transaccionService;
    protected $promocionService;

    public function __construct(TransaccionService $transaccionService, PromocionService $promocionService, VentaProductoService $ventaProductoService)
    {
        $this->transaccionService = $transaccionService;
        $this->promocionService = $promocionService;
        $this->ventaProductoService = $ventaProductoService;
    }

    public function index()
    {

        $productos = Producto::all();
        return view('dashboard', compact('productos')); // Pasa los productos a la vista del dashboard
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Nombre_Producto' => 'nullable|string|max:45',
            'Descripcion_Producto' => 'nullable|string|max:2000',
            'Costo_Adquisicion' => 'nullable|numeric',
            'Codigo_Barras' => 'required|integer|unique:producto,Codigo_Barras',
            'Peso' => 'nullable|string|max:55',
            'Precio' => 'nullable|numeric',
            'Cantidad_Stock' => 'required|integer|min:1',
            'Cantidad_Minima' => 'required|integer|min:1',
            'Cantidad_Maxima' => 'nullable|integer',
            'Id_Clasificacion' => 'nullable|integer|exists:clasificacion,Id_Clasificacion',
            'Id_Categoria' => 'nullable|integer|exists:categoria,Id_Categoria',
            'Id_Estado_Producto' => 'nullable|integer|exists:estado_producto,Id_Estado_Producto',
            'Id_Marca' => 'nullable|integer|exists:marca,Id_Marca',
            'Id_Proveedor' => 'nullable|integer|exists:proveedor,Id_Proveedor',
            'Fecha_Vencimiento' => 'nullable|date',
            'Id_Tipo_Promocion' => 'nullable|integer|in:1,2',
            'Fecha_Inicio' => 'nullable|date',
            'Fecha_Fin' => 'nullable|date',
            'Descuento' => 'nullable|integer',
        ]);

        if ($data['Cantidad_Stock'] < $data['Cantidad_Minima']) {
            return response()->json([
                'message' => 'La cantidad en stock está por debajo de la cantidad mínima permitida.',
                'recomendacion' => 'Aumenta el stock para cumplir con la cantidad mínima de ' . $data['Cantidad_Minima']
            ], 400);
        }

        $producto = Producto::create($data);

        try {
            $this->transaccionService->registrarDesdeProducto($producto, $data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        if ($producto->Id_Estado_Producto == 3) {
            try {
                $this->promocionService->crearDesdeProducto($producto, $data);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Producto creado exitosamente.');
    }

    public function show($id)
    {
        return Producto::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $data = $request->validate([
            'Nombre_Producto' => 'nullable|string|max:45',
            'Descripcion_Producto' => 'nullable|string|max:2000',
            'Costo_Adquisicion' => 'nullable|numeric',
            'Codigo_Barras' => [
                'required',
                'integer',
                Rule::unique('producto', 'Codigo_Barras')->ignore($producto->Id_Producto, 'Id_Producto')
            ],
            'Peso' => 'nullable|string|max:55',
            'Precio' => 'nullable|numeric',
            'Cantidad_Stock' => 'required|integer|min:1',
            'Cantidad_Minima' => 'required|integer|min:1',
            'Cantidad_Maxima' => 'nullable|integer',
            'Id_Clasificacion' => 'nullable|integer|exists:clasificacion,Id_Clasificacion',
            'Id_Categoria' => 'nullable|integer|exists:categoria,Id_Categoria',
            'Id_Estado_Producto' => 'nullable|integer|exists:estado_producto,Id_Estado_Producto',
            'Id_Marca' => 'nullable|integer|exists:marca,Id_Marca',
            'Id_Proveedor' => 'nullable|integer|exists:proveedor,Id_Proveedor',
            'Fecha_Vencimiento' => 'nullable|date',
            'Id_Tipo_Promocion' => 'nullable|integer|in:1,2',
            'Fecha_Inicio' => 'nullable|date',
            'Fecha_Fin' => 'nullable|date',
            'Descuento' => 'nullable|integer',
        ]);

        if ($data['Cantidad_Stock'] < $data['Cantidad_Minima']) {
            return response()->json([
                'message' => 'La cantidad en stock está por debajo de la cantidad mínima permitida.',
                'recomendacion' => 'Aumenta el stock para cumplir con la cantidad mínima de ' . $data['Cantidad_Minima']
            ], 400);
        }

        $producto->update($data);


        return response()->json($producto);
    }

    public function destroy($id)
    {
        Producto::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function create()
    {
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $clasificaciones = Clasificacion::all();
        $estados = EstadoProducto::all();
        $proveedores = Proveedor::all();
        $tiposPromociones = TipoPromocion::all();

        return view('productos.create', compact('marcas', 'categorias', 'clasificaciones', 'estados', 'proveedores', 'tiposPromociones'));
    }

    public function vender(Request $request, VentaProductoService $ventaProductoService)
{
    $validated = $request->validate([
        'idProducto' => 'required|exists:producto,Id_Producto',
        'cantidad' => 'required|integer|min:1',
        'id_regente' => 'required|exists:regente,Id_Regente',
    ]);

    // Enviar mensaje a la sesión para mostrar en la vista
    session()->flash('venta_data', $validated);

    try {
        $ventaProductoService->vender($validated);
        session()->flash('venta_success', 'Venta realizada correctamente.');
    } catch (\Throwable $e) {
        session()->flash('venta_error', 'Error al vender producto: ' . $e->getMessage());
    }

    return back();
}

}
