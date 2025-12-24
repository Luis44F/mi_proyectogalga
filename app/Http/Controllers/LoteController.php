<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Papeleta;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index($papeleta_id)
    {
        $papeleta = Papeleta::findOrFail($papeleta_id);
        $lotes = $papeleta->lotes;

        return view('lotes.index', compact('papeleta', 'lotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'papeleta_id' => 'required|exists:papeletas,id',
            'numero_lote' => 'required',
            'cantidad' => 'required|integer'
        ]);

        Lote::create([
            'papeleta_id' => $request->papeleta_id,
            'numero_lote' => $request->numero_lote,
            'cantidad' => $request->cantidad,
            'estado' => 'En proceso',
            'area_actual' => 'Tejedora'
        ]);

        return back()->with('success', 'Lote creado correctamente');
    }
}
