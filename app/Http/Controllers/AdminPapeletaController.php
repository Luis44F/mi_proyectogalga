<?php

namespace App\Http\Controllers;

use App\Models\Papeleta;
use Illuminate\Http\Request;

class AdminPapeletaController extends Controller
{
    public function revisar($id)
    {
        if (auth()->user()->rol !== 'Administrador General') {
            abort(403);
        }

        $papeleta = Papeleta::findOrFail($id);

        return view('admin.papeletas.checks', compact('papeleta'));
    }

    public function actualizarChecks(Request $request, $id)
    {
        if (auth()->user()->rol !== 'Administrador General') {
            abort(403);
        }

        $papeleta = Papeleta::findOrFail($id);

        $papeleta->update([
            'check_programa'  => $request->has('check_programa'),
            'check_cliente'   => $request->has('check_cliente'),
            'check_modelo'    => $request->has('check_modelo'),
            'check_cantidad'  => $request->has('check_cantidad'),
            'check_comprador' => $request->has('check_comprador'),
        ]);

        return back()->with('success', 'Checks actualizados');
    }

    public function autorizar($id)
    {
        if (auth()->user()->rol !== 'Administrador General') {
            abort(403);
        }

        $papeleta = Papeleta::findOrFail($id);

        if (
            !$papeleta->check_programa ||
            !$papeleta->check_cliente ||
            !$papeleta->check_modelo ||
            !$papeleta->check_cantidad ||
            !$papeleta->check_comprador
        ) {
            return back()->with('error', 'Faltan validaciones por completar');
        }

        // 🚦 PASO CLAVE
        $papeleta->update([
            'estado' => 'En Tejedora'
        ]);

        return back()->with('success', 'Papeleta AUTORIZADA y enviada a Tejedora');
    }
}