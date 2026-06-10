<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Material extends Model
{
    use SoftDeletes;

    protected $table = 'materiales';

    protected $fillable = [
        'identificador_unico',
        'proveedor_id',
        'municipio',
        'ciudad',
        'tipo_material',
        'tipo_resina',
        'color',
        'presentacion',
        'procedencia',
        'tipo_producto',
        'tipo_residuo',
        'peso_bruto',
        'peso_neto',
        'fecha_recepcion',
        'hora_recepcion',
        'lote_proveedor',
        'certificado_origen',
        'destino',
        'estado',
        'approved_at',
        'approved_by',
        'created_by',
    ];

    protected $casts = [
        'peso_bruto' => 'decimal:2',
        'peso_neto' => 'decimal:2',
        'fecha_recepcion' => 'date',
        'hora_recepcion' => 'datetime:H:i:s',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function lineasProcesos()
    {
        return $this->hasMany(MaterialLineaProceso::class, 'material_id');
    }

    public function despachos()
    {
        return $this->hasMany(Despacho::class);
    }

    // Métodos de estado
    public function isEditable(): bool
    {
        return in_array($this->estado, ['pending', 'rejected']);
    }

    public function isApproved(): bool
    {
        return $this->estado === 'approved';
    }

    public function isPending(): bool
    {
        return $this->estado === 'pending';
    }

    // Scope para solo aprobados
    public function scopeApproved($query)
    {
        return $query->where('estado', 'approved');
    }

    // Scope para pendientes
    public function scopePending($query)
    {
        return $query->where('estado', 'pending');
    }

    // Boot para bloquear edición de aprobados
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($material) {
            if ($material->isApproved() && Auth::check() && !Auth::user()->isAdmin()) {
                throw new \Exception('No se puede editar un registro aprobado. Solo el administrador puede crear una corrección.');
            }
        });

        // Generar identificador automático antes de crear
        static::creating(function ($material) {
            if (empty($material->identificador_unico)) {
                $material->identificador_unico = self::generarIdentificador();
            }
        });
    }

    // Generar identificador único estilo MAT-20251205-00042
    public static function generarIdentificador()
    {
        $fecha = date('Ymd');
        $ultimo = self::where('identificador_unico', 'LIKE', "MAT-{$fecha}-%")
            ->orderBy('identificador_unico', 'desc')
            ->first();

        if ($ultimo) {
            $numero = intval(substr($ultimo->identificador_unico, -5)) + 1;
        } else {
            $numero = 1;
        }

        return "MAT-{$fecha}-" . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }
}