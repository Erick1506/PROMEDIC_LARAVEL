<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Regente;
use App\Models\Administrador;

class VerificarSesion
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('regente_id')) {
            // Cargar el regente desde la base de datos
            $regente = Regente::find(session('regente_id'));
            if ($regente) {
                // Compartirlo con todas las vistas y controladores
                view()->share('usuario_autenticado', $regente);
                view()->share('rol_usuario', 'regente');
                return $next($request);
            }
        }

        if (session()->has('admin_id')) {
            $admin = Administrador::find(session('admin_id'));
            if ($admin) {
                view()->share('usuario_autenticado', $admin);
                view()->share('rol_usuario', 'admin');
                return $next($request);
            }
        }

        return redirect('/login');
    }
}
