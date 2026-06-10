<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use App\Models\InventarioProceso;
use App\Models\Produccion;
use App\Models\Despacho; 
use App\Models\Trazabilidad;

class DashboardController extends Controller
{
    public function adminDashboard()
{
    // Estadísticas para el dashboard
    $totalInventario = Inventario::sum('peso');
    $totalEnProceso = InventarioProceso::sum('peso');
    $produccionMes = Produccion::whereMonth('fecha_produccion', now()->month)
        ->whereYear('fecha_produccion', now()->year)
        ->sum('peso');
    $despachosMes = Despacho::whereMonth('fecha', now()->month)
        ->whereYear('fecha', now()->year)
        ->sum('cantidad_kg');
    $ultimosMovimientos = Trazabilidad::orderBy('fecha_evento', 'desc')->take(10)->get();
    
    return view('admin.dashboard', compact(
        'totalInventario', 'totalEnProceso', 'produccionMes', 'despachosMes', 'ultimosMovimientos'
    ));
}

    public function inventarioDashboard()
    {
        $inventarios = Inventario::orderBy('fecha', 'desc')->get();
        return view('inventario.dashboard', compact('inventarios'));
    }
    
}