<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lote;
use App\Models\User;

class FlujoProduccion extends Model
{
    use HasFactory;

    protected $table = 'flujo_produccion';

    /**
     * Campos permitidos (NO se rompe nada existente)
     */
    protected $fillable = [
        'lote_id',
        'area',
        'fecha_inicio',
        'fecha_fin',
        'conteo_inicial',
        'conteo_final',
        'operador_id',
        'fallas_json',
        'observaciones',
        'autorizado_por',
        'fecha_autorizacion',

        // 🆕 NUEVOS CAMPOS (compatibles)
        'datos',
        'completado',
        'check_supervisor',
        'supervisor_id',
        'fecha_check',
    ];

    /**
     * Casts seguros (solo interpretación)
     */
    protected $casts = [
        'fallas_json'        => 'array',
        'datos'              => 'array',
        'fecha_inicio'       => 'datetime',
        'fecha_fin'          => 'datetime',
        'fecha_autorizacion' => 'datetime',
        'fecha_check'        => 'datetime',
        'conteo_inicial'     => 'integer',
        'conteo_final'       => 'integer',
        'completado'         => 'boolean',
        'check_supervisor'   => 'boolean',
    ];

    /**
     * RELACIONES
     */

    // 🔗 Flujo pertenece a un lote
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    // 👷 Operador que ejecuta el proceso
    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }

    // 🔐 Usuario que autoriza el cierre del flujo
    public function autorizadoPor()
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }

    // 👨‍💼 Supervisor que valida el proceso
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * 🔒 SCOPES ÚTILES (siguen funcionando igual)
     */

    public function scopeAbiertos($query)
    {
        return $query->whereNull('fecha_fin');
    }

    public function scopeCerrados($query)
    {
        return $query->whereNotNull('fecha_fin');
    }

    public function scopeAutorizados($query)
    {
        return $query->whereNotNull('fecha_autorizacion');
    }

    // 🆕 Flujos completados
    public function scopeCompletados($query)
    {
        return $query->where('completado', true);
    }
}
