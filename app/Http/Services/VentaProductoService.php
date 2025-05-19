<?php

namespace App\Http\Services;

use App\Models\Producto;
use App\Models\Comprobante;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class VentaProductoService
{
    protected $transaccionService;

    public function __construct(TransaccionService $transaccionService)
    {
        $this->transaccionService = $transaccionService;
    }

    public function vender(array $data)
    {
        Log::info("Iniciando venta con datos: " . json_encode($data));

        DB::beginTransaction();

        try {
            $producto = Producto::findOrFail($data['idProducto']);
            Log::info("Producto encontrado: {$producto->Nombre_Producto}, stock actual: {$producto->Cantidad_Stock}");

            if ($producto->Cantidad_Stock < $data['cantidad']) {
                Log::warning("Stock insuficiente para producto {$producto->Nombre_Producto}");
                throw ValidationException::withMessages(['cantidad' => 'Stock insuficiente.']);
            }

            $precioUnitario = $producto->Precio;
            $total = $precioUnitario * $data['cantidad'];

            // Aquí puedes ajustar según la promoción activa que tengas
            $descuento = 0;
            if (method_exists($producto, 'promocionActiva') && $producto->promocionActiva) {
                $descuento = $producto->promocionActiva->calcularDescuento($total);
                Log::info("Descuento aplicado: $descuento");
            }

            $producto->Cantidad_Stock -= $data['cantidad'];
            $producto->save();
            Log::info("Stock actualizado: {$producto->Cantidad_Stock}");

            $this->transaccionService->crearTransaccion([
                'Fecha_Transaccion' => Carbon::now(),
                'Cantidad' => $data['cantidad'],
                'Id_Producto' => $producto->Id_Producto,
                'Id_Tipo_Transaccion' => 2, // venta
                'Id_Administrador' => $data['id_regente'] ?? 1,
            ]);
            Log::info("Transacción creada.");

            Comprobante::create([
                'Id_Producto' => $producto->Id_Producto,
                'Cantidad' => $data['cantidad'],
                'Total' => $total - $descuento,
                'Fecha_Venta' => Carbon::now(), // Corregido: Cambié 'Fecha_Venta_' a 'Fecha_Venta'
                'Id_Regente' => $data['id_regente']
            ]);
            Log::info("Comprobante creado.");

            DB::commit();
            Log::info("Venta finalizada exitosamente.");

            return true;

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error en venta: " . $e->getMessage());
            throw $e;
        }
    }
}
