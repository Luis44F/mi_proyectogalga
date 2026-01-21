<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Papeleta;
use App\Models\FlujoProduccion;

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

    // 🔗 Lote pertenece a una papeleta
    public function papeleta()
    {
        return $this->belongsTo(Papeleta::class);
    }

    // 🔁 Lote tiene muchos flujos de producción
    public function flujos()
    {
        return $this->hasMany(FlujoProduccion::class);
    }

    // 🟢 Flujo actual (pendiente de validación de supervisor)
    public function flujoActual()
    {
        return $this->hasOne(FlujoProduccion::class)
            ->where('check_supervisor', false);
    }
}
