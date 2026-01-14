<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Message;

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

    /* =========================
       VALIDACIONES POR ROL
    ========================= */

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

    /* =========================
       MENSAJERÍA (RELACIONES BÁSICAS)
    ========================= */

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'emisor_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receptor_id');
    }

    /* =========================
       ACCESSOR: ÚLTIMO MENSAJE
       (FORMA CORRECTA)
    ========================= */

    public function getLastMessageAttribute()
    {
        $authId = auth()->id();

        return Message::where(function ($q) use ($authId) {
                $q->where('emisor_id', $this->id)
                  ->where('receptor_id', $authId);
            })
            ->orWhere(function ($q) use ($authId) {
                $q->where('emisor_id', $authId)
                  ->where('receptor_id', $this->id);
            })
            ->latest('created_at')
            ->first();
    }
}
