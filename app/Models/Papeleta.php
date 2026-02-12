<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Lote;
use App\Models\FichaTecnica;
use App\Models\Distribucion;

class Papeleta extends Model
{
    use HasFactory;

    protected $table = 'papeletas';

    protected $fillable = [
        'cliente',
        'modelo',
        'talla',
        'marca',
        'color',
        'material',
        'piezas_totales',
        'imagen_diseño',
        'observaciones',
        'fecha_inicio',
        'fecha_entrega',
        'estado',
        'autorizado_por',
        'fecha_autorizacion',

        // ✅ CHECKS ADMIN
        'check_programa',
        'check_cliente',
        'check_modelo',
        'check_cantidad',
        'check_comprador'
    ];

    /**
     * 🔑 CASTS
     * Esto evita errores como:
     * Call to a member function format() on string
     */
    protected $casts = [
        'fecha_autorizacion' => 'datetime',
        'fecha_inicio'       => 'date',
        'fecha_entrega'      => 'date',
        'check_programa'     => 'boolean',
        'check_cliente'      => 'boolean',
        'check_modelo'       => 'boolean',
        'check_cantidad'     => 'boolean',
        'check_comprador'    => 'boolean',
    ];

    /* =========================
     |        RELACIONES
     |=========================*/

    // 📌 Papeleta → Lotes
    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    // 📌 Papeleta → Ficha Técnica
    public function fichaTecnica()
    {
        return $this->hasOne(FichaTecnica::class);
    }

    // 📌 Papeleta → Distribución
    public function distribucion()
    {
        return $this->hasOne(Distribucion::class);
    }

    // 📌 Usuario que autorizó la papeleta
    public function autorizadoPor()
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }
}