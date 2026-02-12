<?php

namespace App\Services;

use App\Models\FlujoProduccion;
use App\Models\Lote;
use App\Enums\FasesProduccion;

class CrearFlujoProduccionService
{
    public static function crear(Lote $lote): void
    {
        foreach (FasesProduccion::orden() as $index => $fase) {

            FlujoProduccion::create([
                'lote_id' => $lote->id,
                'fase' => $fase->value,
                'area' => $fase->value,
                'orden' => $index + 1,
                'check_proceso' => false,
            ]);

        }
    }
}
