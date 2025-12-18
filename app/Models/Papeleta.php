<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
