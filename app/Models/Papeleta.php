<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lote;
use App\Models\FichaTecnica;

class Papeleta extends Model
{
    use HasFactory;

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
        'estado'
    ];

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

}
