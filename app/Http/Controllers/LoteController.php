<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Papeleta;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index($id)
    {
        $papeleta = Papeleta::findOrFail($id);

        $lotes = Lote::where('papeleta_id', $id)->get();

        return view('lotes.index', compact('papeleta', 'lotes'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->rol, [
            'Administrador General',
            'Supervisor General de Producción'
        ])) {
            abort(403);
        }

        $request->validate([
            'papeleta_id' => 'required',
            'nombre'      => 'required'
        ]);

        Lote::create([
            'papeleta_id' => $request->papeleta_id,
            'nombre'      => $request->nombre,
            'estado'      => 'pendiente'
        ]);

        return back();
    }

    public function cambiarEstado(Lote $lote, $estado)
    {
        $rol = auth()->user()->rol;

        // Reglas por rol
        if ($rol === 'Operador de Tejedora' && $estado === 'terminado') {
            abort(403);
        }

        if (!in_array($estado, ['pendiente', 'proceso', 'terminado'])) {
            abort(400);
        }

        if ($rol !== 'Administrador General' && $rol !== 'Supervisor General de Producción') {
            abort(403);
        }

        $lote->update([
            'estado' => $estado
        ]);

        return back();
    }
}
