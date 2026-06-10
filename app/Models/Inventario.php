<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    public $timestamps = false;
    
    protected $fillable = [
        'fecha', 'hora', 'placa', 'proveedor', 'codigo_proveedor',
        'procedencia', 'tipo_material', 'tipo_resina', 'color',
        'presentacion', 'procedencia_tipo', 'tipo_producto',
        'tipo_residuo', 'historial', 'peso', 'remision', 'codigo_paca'
    ];
}