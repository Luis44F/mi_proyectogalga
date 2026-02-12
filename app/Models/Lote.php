<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'papeleta_id',
        'numero_lote',
        'cantidad',
        'estado',
        'area_actual'
    ];

    /**
     * RELACIONES EXISTENTES (Mantenidas)
     */

    public function papeleta()
    {
        return $this->belongsTo(Papeleta::class);
    }

    // Cambié 'flujo' por 'flujos' (plural) que es el estándar para hasMany
    public function flujos()
    {
        return $this->hasMany(FlujoProduccion::class)->orderBy('orden');
    }

    /**
     * LÓGICA DE FLUJO (Mejorada para el Motor MES)
     */

    // Obtiene la fase que se está trabajando actualmente
    public function faseActual()
    {
        return $this->hasOne(FlujoProduccion::class)
            ->where('check_proceso', false)
            ->orderBy('orden', 'asc');
    }

    // Tu relación original corregida para usar el nuevo campo check_proceso
    public function flujoActual()
    {
        return $this->hasOne(FlujoProduccion::class)
            ->where('check_proceso', false); 
    }

    /**
     * HELPER ÚTIL
     * Retorna el porcentaje de avance basado en fases terminadas
     */
    public function getProgresoAttribute()
    {
        $total = $this->flujos()->count();
        if ($total == 0) return 0;
        
        $completados = $this->flujos()->where('check_proceso', true)->count();
        return round(($completados / $total) * 100);
    }
}