<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; 

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener todos los productos
        $productos = Producto::with(['marca', 'estadoProducto'])->get(); 
        return response()
            ->view('dashboard', compact('productos'));
    }
}
