<?php

namespace App\Observers;

use App\Models\InventarioProceso;
use App\Models\Trazabilidad;


class InventarioProcesoObserver
{
   public function created(InventarioProceso $proceso)
{
    Trazabilidad::create([
        'codigo_paca'     => $proceso->codigo_paca,
        'lote_proceso'    => $proceso->lote_proceso,
        'tipo_evento'     => 'proceso',
        'fecha_evento'    => $proceso->fecha_inicio,
        'proveedor'       => $proceso->proveedor,
        'tipo_material'   => $proceso->tipo_material,
        'tipo_producto'   => $proceso->tipo_producto,
        'peso'            => $proceso->peso,
        'puerto'          => $proceso->puerto,
        'usuario_registra'=> auth()->user()->usuario,
        'observaciones'   => "Inicio de proceso en puerto {$proceso->puerto}"
    ]);
}
}
