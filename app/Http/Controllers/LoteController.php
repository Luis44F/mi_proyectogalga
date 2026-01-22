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

    // 🆕 CREAR LOTE (AJUSTE LIMPIO – SIN ROMPER ROLES)
    public function store(Request $request)
    {
        // 🔐 RESPETA TU VALIDACIÓN DE ROLES
        if (!in_array(auth()->user()->rol, [
            'Administrador General',
            'Supervisor General de Producción'
        ])) {
            abort(403);
        }

        $request->validate([
            'papeleta_id' => 'required|exists:papeletas,id',
            'cantidad'    => 'required|integer|min:1'
        ]);

        $papeleta = Papeleta::findOrFail($request->papeleta_id);

        // ✅ SOLO SI ESTÁ AUTORIZADA
        if ($papeleta->estado !== 'AUTORIZADA') {
            return back()->with('error', 'La papeleta no está autorizada');
        }

        // 🔢 Generar número de lote automático
        $contador = $papeleta->lotes()->count() + 1;

        Lote::create([
            'papeleta_id' => $papeleta->id,
            'numero_lote' => 'L-' . str_pad($contador, 3, '0', STR_PAD_LEFT),
            'cantidad'    => $request->cantidad,
            'estado'      => 'En proceso',
            'area_actual' => 'Tejedora'
        ]);

        // 🔄 Cambia papeleta a producción
        $papeleta->update([
            'estado' => 'EN_PRODUCCION'
        ]);

        return back()->with('success', 'Lote creado correctamente');
    }

    // 🔁 CAMBIAR ESTADO DEL LOTE (NO SE TOCA)
    public function cambiarEstado(Lote $lote, $estado)
    {
        $rol = auth()->user()->rol;

        if (!in_array($estado, ['pendiente', 'proceso', 'terminado'])) {
            abort(400);
        }

        if ($rol === 'Operador de Tejedora' && $estado === 'terminado') {
            abort(403);
        }

        if (!in_array($rol, [
            'Administrador General',
            'Supervisor General de Producción'
        ])) {
            abort(403);
        }

        $lote->update([
            'estado' => $estado
        ]);

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
