<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre_completo',
        'email',
        'password',
        'telefono',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // -------------------------
    // VALIDACIONES POR ROL
    // -------------------------
    public function isAdmin(): bool
    {
        return $this->rol === 'Administrador';
    }

    public function isSupervisor(): bool
    {
        return $this->rol === 'Supervisor';
    }

    public function isOperario(): bool
    {
        return $this->rol === 'Operario';
    }

    public function isTejedora(): bool
    {
    return $this->rol === 'Operario';
    }

    public function isProduccion(): bool
    {
    return $this->rol === 'Operario';
    }

}
