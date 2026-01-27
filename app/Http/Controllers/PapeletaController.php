<?php

namespace App\Http\Controllers;

use App\Models\Papeleta;
use Illuminate\Http\Request;

class PapeletaController extends Controller
{
    // 📄 VER ÚLTIMA PAPELETA (CON LOTES)
    public function ver()
    {
        $papeleta = Papeleta::with('lotes')
            ->latest()
            ->first();

        return view('papeletas.papeleta', [
            'papeleta' => $papeleta
        ]);
    }

    // ➕ FORMULARIO CREAR PAPELETA
    public function create()
    {
        return view('papeletas.create');
    }

    // 💾 GUARDAR PAPELETA
    public function store(Request $request)
    {
        $request->validate([
            'cliente'          => 'required|string',
            'modelo'           => 'required|string',
            'talla'            => 'required|string',
            'marca'            => 'nullable|string',
            'color'            => 'nullable|string',
            'material'         => 'nullable|string',
            'piezas_totales'   => 'required|integer|min:1',
            'observaciones'    => 'nullable|string',
        ]);

        $papeleta = Papeleta::create([
            'cliente'        => $request->cliente,
            'modelo'         => $request->modelo,
            'talla'          => $request->talla,
            'marca'          => $request->marca,
            'color'          => $request->color,
            'material'       => $request->material,
            'piezas_totales' => $request->piezas_totales,
            'observaciones'  => $request->observaciones,
            'estado'         => 'CREADA',
        ]);

        return redirect()
            ->route('papeleta.ver')
            ->with('success', 'Papeleta creada correctamente');
    }

    // ✅ AUTORIZAR PAPELETA
    public function autorizar(Papeleta $papeleta)
    {
        $papeleta->update([
            'estado'             => 'AUTORIZADA',
            'autorizado_por'     => auth()->id(),
            'fecha_autorizacion' => now(),
        ]);

        return back()->with('success', 'Papeleta autorizada');
    }

    // ⛔ DETENER
    public function detener(Papeleta $papeleta)
    {
        $papeleta->update([
            'estado' => 'DETENIDA'
        ]);

        return back()->with('success', 'Papeleta detenida');
    }

    // ▶️ REACTIVAR
    public function reactivar(Papeleta $papeleta)
    {
        $papeleta->update([
            'estado' => 'AUTORIZADA'
        ]);

        return back()->with('success', 'Papeleta reactivada');
    }
}

