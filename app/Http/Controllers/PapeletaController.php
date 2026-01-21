<?php

namespace App\Http\Controllers;

use App\Models\Papeleta;
use App\Models\Lote;
use Illuminate\Http\Request;

class PapeletaController extends Controller
{
    // 📄 LISTADO DE PAPELETAS
    public function index()
    {
        $papeletas = Papeleta::orderBy('id', 'desc')->get();
        return view('papeletas.index', compact('papeletas'));
    }

    // 🆕 CREAR PAPELETA (ADMINISTRACIÓN)
    public function store(Request $request)
    {
        // ⛔ no tocamos nombres de campos existentes
        $data = $request->validate([
            'cliente'         => 'required|string',
            'modelo'          => 'required|string',
            'piezas_totales'  => 'required|integer|min:1',

            // ⬇️ estos campos pueden existir o no en tu formulario
            'talla'           => 'nullable|string',
            'marca'           => 'nullable|string',
            'color'           => 'nullable|string',
            'material'        => 'nullable|string',
            'observaciones'   => 'nullable|string',
        ]);

        // 🔒 Estado inicial controlado
        $data['estado'] = 'CREADA';

        Papeleta::create($data);

        return redirect()->back()
            ->with('success', 'Papeleta creada correctamente');
    }

    // 🔥 VER DETALLE + LOTES (NO SE ROMPE)
    public function show($id)
    {
        $papeleta = Papeleta::with('lotes.usuario')->findOrFail($id);
        return view('papeletas.show', compact('papeleta'));
    }

    // ✅ AUTORIZAR PAPELETA (ADMIN)
    public function autorizar($id)
    {
        $papeleta = Papeleta::findOrFail($id);

        // ⛔ evita doble autorización
        if ($papeleta->estado !== 'CREADA') {
            return back()->with('error', 'La papeleta no puede autorizarse');
        }

        $papeleta->update([
            'estado'             => 'AUTORIZADA',
            'autorizado_por'     => auth()->id(),
            'fecha_autorizacion' => now(),
        ]);

        return back()->with('success', 'Papeleta autorizada correctamente');
    }

    // ⛔ DETENER PAPELETA (ADMIN)
    public function detener($id)
    {
        $papeleta = Papeleta::findOrFail($id);

        $papeleta->update([
            'estado' => 'DETENIDA'
        ]);

        return back()->with('success', 'Papeleta detenida');
    }

    // ▶️ REACTIVAR PAPELETA
    public function reactivar($id)
    {
        $papeleta = Papeleta::findOrFail($id);

        if ($papeleta->estado !== 'DETENIDA') {
            return back();
        }

        $papeleta->update([
            'estado' => 'EN_PRODUCCION'
        ]);

        return back()->with('success', 'Papeleta reactivada');
    }
}
