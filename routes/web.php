<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\FormulaMedicaController;
use App\Http\Controllers\RegenteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClasificacionController;


// Ruta para mostrar formulario de login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

// Ruta para procesar formulario de login
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Ruta para logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta protegida (dashboard)
Route::get('/dashboard', function () {
    if (!session()->has('regente_id') && !session()->has('admin_id')) {
        return redirect('/login');
    }
    return view('dashboard'); // la vista 
})->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



// Estadísticas
Route::get('/estadisticas', [EstadisticasController::class, 'index'])
    ->name('estadisticas.index');

// Productos (solo las rutas que necesitas)
// Para listado, creación, edición, guardado y borrado usa resource
Route::resource('productos', ProductoController::class)
    ->except(['show']); 

// Promociones (listado y creación/edición)
Route::resource('promociones', PromocionController::class);


// Recetas médicas
Route::resource('recetas', FormulaMedicaController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

// Regente
Route::get('/regente', [RegenteController::class, 'index'])
    ->name('regente.index');

// Proveedores
Route::resource('proveedores', ProveedorController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // Categorías
Route::resource('categorias', CategoriaController::class);
// Clasificaciones
Route::resource('clasificaciones', ClasificacionController::class);

//VENDER PRODCUTO
Route::post('/productos/vender', [ProductoController::class, 'vender'])->name('productos.vender');


