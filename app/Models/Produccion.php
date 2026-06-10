<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    protected $table = 'produccion';  // nombre de la tabla en español
    public $timestamps = true;

    protected $fillable = [
        'fecha_produccion', 'linea', 'puerto', 'usuario', 'hora',
        'presentacion', 'turno', 'lote', 'numero', 'operador',
        'tipo_producto', 'peso', 'observaciones'
    ];
}