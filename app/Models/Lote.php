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

    public function papeleta()
    {
        return $this->belongsTo(Papeleta::class);
    }

    public function flujos()
    {
        return $this->hasMany(FlujoProduccion::class);
    }
}
