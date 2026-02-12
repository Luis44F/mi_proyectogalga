<?php

namespace App\Observers;

use App\Models\Lote;
use App\Models\FlujoProduccion;
// Asumiendo que crearás este servicio o usarás lógica directa
// use App\Services\CrearFlujoProduccionService; 

class LoteObserver
{
    /**
     * Se ejecuta automáticamente tras crear un Lote.
     */
    public function created(Lote $lote): void
    {
        // Opción con Servicio (Limpio y escalable)
        // CrearFlujoProduccionService::crear($lote);

        // O lógica directa rápida si aún no tienes el servicio:
        $fases = ['Corte', 'Preparación', 'Costura', 'Terminado', 'Empaque'];
        
        foreach ($fases as $index => $fase) {
            $lote->flujos()->create([
                'fase'  => $fase,
                'area'  => $fase, // O el área correspondiente
                'orden' => $index + 1,
                'check_proceso' => false,
            ]);
        }
    }

    public function updated(Lote $lote): void
    {
        // Si el estado del lote cambia a "Anulado", podrías cancelar flujos aquí
    }

    public function deleted(Lote $lote): void
    {
        // El flujo se borra solo por el 'cascade' de la migración,
        // pero aquí podrías registrar logs si fuera necesario.
    }
}