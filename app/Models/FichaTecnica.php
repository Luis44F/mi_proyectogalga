<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Papeleta;
use App\Models\Patron;

class FichaTecnica extends Model
{
    use HasFactory;

    protected $table = 'fichas_tecnicas';

    protected $fillable = [
        'papeleta_id',
        'imagen',
        'medidas_json',
        'pantones_json',
        'colores_json',
        'especificaciones',
        'descripcion',
        'tipo_fibras',
        'estructura'
    ];

    protected $casts = [
        'medidas_json' => 'array',
        'pantones_json' => 'array',
        'colores_json' => 'array',
    ];

    // 📌 Ficha Técnica → Papeleta
    public function papeleta()
    {
        return $this->belongsTo(Papeleta::class);
    }

    // 📌 Ficha Técnica → Patrones
    public function patrones()
    {
        return $this->hasMany(Patron::class, 'ficha_id');
    }
}
