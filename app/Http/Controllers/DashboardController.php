<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Clasificacion;

class DashboardController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['marca', 'estadoProducto', 'categoria', 'clasificacion'])->get();
        $categorias = Categoria::all();
        $clasificaciones = Clasificacion::all();

        return view('dashboard', compact('productos', 'categorias', 'clasificaciones'));
    }


}
