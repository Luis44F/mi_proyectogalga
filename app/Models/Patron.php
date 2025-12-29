<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FichaTecnica;

class Patron extends Model
{
    use HasFactory;

    protected $table = 'patrones';

    protected $fillable = [
        'ficha_id',
        'archivo_pdf',
        'estado'
    ];

    // 📌 Patrón → Ficha Técnica
    public function fichaTecnica()
    {
        return $this->belongsTo(FichaTecnica::class, 'ficha_id');
    }
}
