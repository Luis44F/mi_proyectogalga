<?php

namespace App\Http\Controllers;

use App\Models\Papeleta;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'cliente'        => 'required|string',
            'modelo'         => 'required|string',
            'talla'          => 'required|string',
            'marca'          => 'nullable|string',
            'color'          => 'nullable|string',
            'material'       => 'nullable|string',
            'piezas_totales' => 'required|integer|min:1',
            'observaciones'  => 'nullable|string',
        ]);

        Papeleta::create([
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
            'autorizado_por'     => Auth::id(),
            'fecha_autorizacion' => now(),
        ]);

        return back()->with('success', 'Papeleta autorizada');
    }

    // 🚀 INICIAR PRODUCCIÓN (CREA LOTES AUTOMÁTICOS)
    public function iniciarProduccion($id)
    {
        // 🔐 SOLO ADMIN O SUPERVISOR
        if (!in_array(Auth::user()->rol, ['Administrador', 'Supervisor'])) {
            abort(403, 'No autorizado');
        }

        $papeleta = Papeleta::findOrFail($id);

        // ⛔ VALIDACIONES
        if ($papeleta->estado !== 'AUTORIZADA') {
            return back()->with('error', 'La papeleta no está autorizada');
        }

        if ($papeleta->lotes()->count() > 0) {
            return back()->with('error', 'Esta papeleta ya tiene lotes creados');
        }

        // 🔢 DIVISIÓN EN LOTES DE 50
        $total = $papeleta->piezas_totales;
        $tamanoLote = 50;
        $numeroLote = 1;

        while ($total > 0) {
            $cantidad = $total >= $tamanoLote ? $tamanoLote : $total;

            Lote::create([
                'papeleta_id' => $papeleta->id,
                'numero_lote' => 'L-' . str_pad($numeroLote, 3, '0', STR_PAD_LEFT),
                'cantidad'    => $cantidad,
                'estado'      => 'EN_PRODUCCION',
                'area_actual' => 'Tejedora',
            ]);

            $total -= $cantidad;
            $numeroLote++;
        }

        // 🔄 ACTUALIZAR ESTADO DE PAPELETA
        $papeleta->update([
            'estado' => 'EN_PRODUCCION',
        ]);

        return back()->with('success', 'Flujo de producción iniciado y lotes generados automáticamente');
    }

    // ⛔ DETENER PAPELETA
    public function detener(Papeleta $papeleta)
    {
        $papeleta->update([
            'estado' => 'DETENIDA'
        ]);

        return back()->with('success', 'Papeleta detenida');
    }

    // ▶️ REACTIVAR PAPELETA
    public function reactivar(Papeleta $papeleta)
    {
        $papeleta->update([
            'estado' => 'AUTORIZADA'
        ]);

        return back()->with('success', 'Papeleta reactivada');
    }
}