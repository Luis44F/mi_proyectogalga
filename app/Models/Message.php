<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'emisor_id',
        'receptor_id',
        'mensaje',
        'archivo_adj',
        'archivo_nombre_original',
        'leido',
    ];

    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }
}
