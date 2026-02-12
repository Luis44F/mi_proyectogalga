<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lote;
use App\Models\Papeleta;
use App\Models\User;

class RegistroFase extends Model
{
    use HasFactory;

    protected $table = 'registro_fases';

    protected $fillable = [
        'lote_id',
        'papeleta_id',
        'fase',
        'estado_fase',
        'fecha_inicio',
        'fecha_fin',
        'datos',
        'check_supervisor',
        'supervisor_id',
        'fecha_check',
        'cancelado',
        'cancelado_por',
        'fecha_cancelacion',
        'motivo_cancelacion'
    ];

    protected $casts = [
        'datos' => 'array',
        'check_supervisor' => 'boolean',
        'cancelado' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'fecha_check' => 'datetime',
        'fecha_cancelacion' => 'datetime'
    ];

    // 🔗 RELACIONES
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function papeleta()
    {
        return $this->belongsTo(Papeleta::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function cancelador()
    {
        return $this->belongsTo(User::class, 'cancelado_por');
    }
}
