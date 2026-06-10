<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioProceso extends Model
{
    protected $table = 'inventario_proceso';
    public $timestamps = false; // porque no tiene created_at/updated_at

    protected $fillable = [
    'hora', 'proveedor', 'codigo_proveedor', 'tipo_material',
    'tipo_producto', 'peso', 'codigo_paca', 'lote_proceso', 'puerto', 'fecha_inicio'
    ];
}