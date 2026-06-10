<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'usuario',
        'name',
        'email',
        'password',
        'rol',
        'activo',
        'telefono',
        'direccion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'activo' => 'boolean',
    ];

    // Verificar roles
    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    public function isInventario()
    {
        return $this->rol === 'inventario';
    }

    public function isProcesos()
    {
        return $this->rol === 'procesos';
    }

    public function isDespachos()
    {
        return $this->rol === 'despachos';
    }

    // Verificar si el usuario puede acceder a cierto módulo
    public function puedeAccederA($modulo)
    {
        $permisos = [
            'admin' => ['inventario', 'procesos', 'despachos', 'reportes', 'usuarios', 'configuracion'],
            'inventario' => ['inventario'],
            'procesos' => ['procesos'],
            'despachos' => ['despachos'],
        ];

        return in_array($modulo, $permisos[$this->rol] ?? []);
    }
    public function username()
    {
    return 'usuario';
    }
}