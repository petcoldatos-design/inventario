<?php

namespace App\Observers;

use App\Models\Produccion;
use App\Models\Trazabilidad;


class ProduccionObserver
{
    // app/Observers/ProduccionObserver.php
    public function created(Produccion $produccion)
    {
        Trazabilidad::create([
            'codigo_paca'     => null, // podrías buscar el codigo_paca original si es necesario
            'lote_proceso'    => $produccion->lote,
            'tipo_evento'     => 'produccion',
            'fecha_evento'    => $produccion->fecha_produccion . ' ' . ($produccion->hora ?? '00:00:00'),
            'proveedor'       => null,
            'cliente'         => null,
            'tipo_material'   => null,
            'tipo_producto'   => $produccion->tipo_producto,
            'peso'            => $produccion->peso,
            'puerto'          => $produccion->puerto,
            'linea'           => $produccion->linea,
            'turno'           => $produccion->turno,
            'operador'        => $produccion->operador,
            'usuario_registra'=> auth()->user()->usuario,
            'observaciones'   => 'Producción registrada'
        ]);
    }
}
