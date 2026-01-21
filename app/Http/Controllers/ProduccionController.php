<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;

class ProduccionController extends Controller
{
    public function flujo()
    {
        $user = auth()->user();

        // Producción, supervisores y admin
        if (!$user->isProduccion() && !$user->isAdmin()) {
            abort(403);
        }

        $lotes = Lote::with('papeleta')
            ->whereHas('papeleta', function ($q) {
                $q->whereIn('estado', ['AUTORIZADA', 'EN_PRODUCCION']);
            })
            ->get();

        return view('produccion.flujo', compact('lotes'));
    }
}
