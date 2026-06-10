<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trazabilidad extends Model
{
    protected $table = 'trazabilidad_material';
    protected $fillable = [
        'codigo_paca', 'lote_proceso', 'tipo_evento', 'fecha_evento',
        'proveedor', 'cliente', 'tipo_material', 'tipo_producto',
        'peso', 'puerto', 'linea', 'turno', 'operador',
        'usuario_registra', 'observaciones'
    ];

    // Scope para filtrar por mes
    public function scopeMes($query, $year, $month)
    {
        return $query->whereYear('fecha_evento', $year)->whereMonth('fecha_evento', $month);
    }
}