<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Papeleta;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    // 📄 LISTAR LOTES DE UNA PAPELETA
    public function index($id)
    {
        $papeleta = Papeleta::findOrFail($id);

        $lotes = Lote::where('papeleta_id', $id)->get();

        return view('lotes.index', compact('papeleta', 'lotes'));
    }

    // 🆕 CREAR LOTE (SOLO SI PAPELETA AUTORIZADA)
    public function store(Request $request)
    {
        // 🔐 RESPETA TU VALIDACIÓN ACTUAL DE ROLES
        if (!in_array(auth()->user()->rol, [
            'Administrador General',
            'Supervisor General de Producción'
        ])) {
            abort(403);
        }

        $request->validate([
            'papeleta_id' => 'required|exists:papeletas,id',
            'nombre'      => 'required|string'
        ]);

        $papeleta = Papeleta::findOrFail($request->papeleta_id);

        // 🔒 BLOQUEO REAL GALGA (AJUSTADO A TU FLUJO)
        if ($papeleta->estado !== 'En Tejedora') {
            return back()->with('error', 'La papeleta no está autorizada para producción');
        }

        Lote::create([
            'papeleta_id' => $request->papeleta_id,
            'nombre'      => $request->nombre,
            'estado'      => 'pendiente'
        ]);

        // 🔄 NO CAMBIAMOS ESTADO DE PAPELETA AQUÍ
        // La papeleta YA está en "En Tejedora"

        return back()->with('success', 'Lote creado correctamente');
    }

    // 🔁 CAMBIAR ESTADO DEL LOTE
    public function cambiarEstado(Lote $lote, $estado)
    {
        $rol = auth()->user()->rol;

        // ⛔ Validación de estados permitidos (NO CAMBIA LOS TUYOS)
        if (!in_array($estado, ['pendiente', 'proceso', 'terminado'])) {
            abort(400);
        }

        // ⛔ REGLA EXISTENTE (NO SE TOCA)
        if ($rol === 'Operador de Tejedora' && $estado === 'terminado') {
            abort(403);
        }

        // 🔐 CONTROL ADMIN (NO SE ROMPE)
        if (!in_array($rol, [
            'Administrador General',
            'Supervisor General de Producción'
        ])) {
            abort(403);
        }

        $lote->update([
            'estado' => $estado
        ]);

        // 🔄 SI TODOS LOS LOTES TERMINAN → LISTA PARA ENVÍO
        if ($estado === 'terminado') {
            $papeleta = $lote->papeleta;

            $pendientes = $papeleta->lotes()
                ->where('estado', '!=', 'terminado')
                ->count();

            if ($pendientes === 0) {
                $papeleta->update([
                    'estado' => 'LISTA_ENVIO'
                ]);
            }
        }

        return back()->with('success', 'Estado del lote actualizado');
    }
}
