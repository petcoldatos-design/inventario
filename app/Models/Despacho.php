<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Despacho extends Model
{
    protected $table = 'despachos_produccion';
    protected $primaryKey = 'id_despacho'; // si la llave se llama así, si no usa 'id'
    public $timestamps = false; // si no tiene created_at/updated_at

    protected $fillable = [
        'fecha', 'cliente', 'remision', 'producto', 'presentacion',
        'cantidad_kg', 'lote', 'despachado_por', 'conductor', 'observaciones'
    ];
}