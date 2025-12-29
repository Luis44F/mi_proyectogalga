<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Papeleta;

class Distribucion extends Model
{
    use HasFactory;

    protected $table = 'distribucion';

    protected $fillable = [
        'papeleta_id',
        'fecha_envio',
        'fecha_entrega',
        'responsable',
        'estado',
        'observaciones'
    ];

    // 📌 Distribución → Papeleta
    public function papeleta()
    {
        return $this->belongsTo(Papeleta::class);
    }
}
