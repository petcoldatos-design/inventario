<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DespachoProduccion extends Model
{
    protected $table = 'despachos_produccion';
    protected $primaryKey = 'id_despacho';
    protected $fillable = [
        'fecha', 'cliente', 'remision', 'producto', 'presentacion',
        'cantidad_kg', 'lote', 'despachado_por', 'conductor', 'observaciones'
    ];
}