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
     * Fillable: Combinación de campos originales + Motor de flujo
     */
    protected $fillable = [
        'lote_id',
        'fase',              // 🆕 Motor de flujo
        'orden',             // 🆕 Motor de flujo
        'area',
        'fecha_inicio',
        'fecha_fin',
        'conteo_inicial',
        'conteo_final',
        'operador_id',
        'evidencia_foto',    // 🆕 Motor de flujo
        'fallas_json',
        'observaciones',
        'autorizado_por',
        'fecha_autorizacion',

        // Campos de compatibilidad (por si se usan en el frontend/scripts)
        'datos',             
        'completado',        // Equivale a check_proceso
        'check_proceso',     // 🆕 Motor de flujo
        'check_supervisor',
        'supervisor_id',
        'fecha_check',
    ];

    /**
     * Casts: Aseguramos la integridad de los datos
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
        'orden'              => 'integer',
        'completado'         => 'boolean',
        'check_proceso'      => 'boolean',
        'check_supervisor'   => 'boolean',
    ];

    /**
     * RELACIONES
     */

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }

    public function autorizadoPor()
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * SCOPES (Tu lógica operativa se mantiene intacta)
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

    // Adaptado para funcionar con el campo real de la DB (check_proceso)
    public function scopeCompletados($query)
    {
        return $query->where('check_proceso', true);
    }

    // 🆕 Útil para el motor de flujo: obtener la fase actual del lote
    public function scopeDeLote($query, $loteId)
    {
        return $query->where('lote_id', $loteId)->orderBy('orden');
    }
}