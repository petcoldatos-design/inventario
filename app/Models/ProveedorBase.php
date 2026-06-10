<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProveedorBase extends Model
{
    protected $table = 'proveedores_base';
    public $timestamps = false;
    protected $fillable = ['codigo_proveedor', 'proveedor'];
}