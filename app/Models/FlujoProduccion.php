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
        'fecha_autorizacion'
    ];

    protected $casts = [
        'fallas_json' => 'array',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'fecha_autorizacion' => 'datetime',
    ];

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
}
