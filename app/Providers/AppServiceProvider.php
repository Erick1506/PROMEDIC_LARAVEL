<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Categoria;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('layouts.menu', function ($view) {
                logger('Se está ejecutando el View Composer del menú');

        $view->with('categorias', Categoria::with('clasificaciones')->get());
    });
    }

    
}

