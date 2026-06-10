<?php

namespace App\Observers;

use App\Models\Inventario;
use App\Models\Trazabilidad;

class InventarioObserver
{
    public function created(Inventario $inventario)
    {
        Trazabilidad::create([
            'codigo_paca'     => $inventario->codigo_paca,
            'lote_proceso'    => null,
            'tipo_evento'     => 'ingreso',
            'fecha_evento'    => $inventario->fecha . ' ' . ($inventario->hora ?? '00:00:00'),
            'proveedor'       => $inventario->proveedor,
            'cliente'         => null,
            'tipo_material'   => $inventario->tipo_material,
            'tipo_producto'   => $inventario->tipo_producto,
            'peso'            => $inventario->peso,
            'puerto'          => null,
            'linea'           => null,
            'turno'           => null,
            'operador'        => null,
            'usuario_registra'=> auth()->check() ? auth()->user()->usuario : 'sistema',
            'observaciones'   => 'Ingreso a inventario'
        ]);
    }
}