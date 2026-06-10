<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Inventario;
use App\Models\InventarioProceso;
use App\Models\Produccion;
use App\Models\Despacho;
use App\Observers\InventarioObserver;
use App\Observers\InventarioProcesoObserver;
use App\Observers\ProduccionObserver;
use App\Observers\DespachoObserver;

class AppServiceProvider extends ServiceProvider
{
   public function boot()
    {
        Inventario::observe(InventarioObserver::class);
        InventarioProceso::observe(InventarioProcesoObserver::class);
        Produccion::observe(ProduccionObserver::class);
        Despacho::observe(DespachoObserver::class);
    }
}
