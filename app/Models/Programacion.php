<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Papeleta;

class Programacion extends Model
{
    use HasFactory;

    protected $table = 'programacion';

    protected $fillable = [
        'papeleta_id',
        'archivo_programa',
        'especificaciones_json',
        'historial_archivos_json',
        'fecha'
    ];

    protected $casts = [
        'especificaciones_json' => 'array',
        'historial_archivos_json' => 'array',
        'fecha' => 'datetime'
    ];

    public function papeleta()
    {
        return $this->belongsTo(Papeleta::class);
    }
}
