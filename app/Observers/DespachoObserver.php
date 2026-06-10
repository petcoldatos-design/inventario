<?php

namespace App\Observers;

use App\Models\Despacho;
use App\Models\Trazabilidad;


class DespachoObserver
{
    // app/Observers/DespachoObserver.php
    public function created(Despacho $despacho)
    {
        Trazabilidad::create([
            'codigo_paca'     => null,
            'lote_proceso'    => $despacho->lote,
            'tipo_evento'     => 'despacho',
            'fecha_evento'    => $despacho->fecha,
            'cliente'         => $despacho->cliente,
            'tipo_producto'   => $despacho->producto,
            'peso'            => $despacho->cantidad_kg,
            'usuario_registra'=> auth()->user()->usuario,
            'observaciones'   => 'Despacho a cliente'
        ]);
    }
}
