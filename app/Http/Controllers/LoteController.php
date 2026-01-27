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

        $lotes = $papeleta->lotes()
            ->orderBy('id')
            ->get();

        return view('lotes.index', compact('papeleta', 'lotes'));
    }

    // 🆕 CREAR LOTE
    public function store(Request $request)
    {
        // 🔐 CONTROL DE ROLES (COINCIDE CON ENUM users.rol)
        if (!in_array(auth()->user()->rol, [
            'Administrador',
            'Supervisor'
        ])) {
            abort(403, 'No autorizado');
        }

        // ✅ VALIDACIÓN
        $request->validate([
            'papeleta_id' => 'required|exists:papeletas,id',
            'cantidad'    => 'required|integer|min:1'
        ]);

        $papeleta = Papeleta::findOrFail($request->papeleta_id);

        // ⛔ SOLO SI ESTÁ AUTORIZADA
        if ($papeleta->estado !== 'AUTORIZADA') {
            return back()->with('error', 'La papeleta no está autorizada');
        }

        // 🔢 NÚMERO DE LOTE AUTOMÁTICO
        $contador = $papeleta->lotes()->count() + 1;

        Lote::create([
            'papeleta_id' => $papeleta->id,
            'numero_lote' => 'L-' . str_pad($contador, 3, '0', STR_PAD_LEFT),
            'cantidad'    => $request->cantidad,
            'estado'      => 'EN_PRODUCCION',
            'area_actual' => 'Tejedora'
        ]);

        // 🔄 CAMBIAR ESTADO DE PAPELETA
        $papeleta->update([
            'estado' => 'EN_PRODUCCION'
        ]);

        return back()->with('success', 'Lote creado correctamente');
    }

    // 🔁 CAMBIAR ESTADO DEL LOTE
    public function cambiarEstado(Lote $lote, $estado)
    {
        $rol = auth()->user()->rol;

        $estadosPermitidos = ['pendiente', 'proceso', 'terminado'];

        if (!in_array($estado, $estadosPermitidos)) {
            abort(400, 'Estado inválido');
        }

        // ⛔ REGLA ESPECÍFICA DE OPERADOR
        if ($rol === 'Operador' && $estado === 'terminado') {
            abort(403);
        }

        // 🔐 SOLO ADMINISTRADOR Y SUPERVISOR
        if (!in_array($rol, [
            'Administrador',
            'Supervisor'
        ])) {
            abort(403);
        }

        $lote->update([
            'estado' => $estado
        ]);

        // ✅ SI TODOS LOS LOTES TERMINARON → LISTA PARA ENVÍO
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
