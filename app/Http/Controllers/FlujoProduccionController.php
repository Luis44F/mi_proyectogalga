<?php

namespace App\Http\Controllers;

use App\Models\FlujoProduccion;
use App\Models\Lote;
use Illuminate\Http\Request;

class FlujoProduccionController extends Controller
{
    /**
     * 🧠 ORDEN OFICIAL DEL FLUJO (NO rompe nada)
     */
    private array $areas = [
        'Hilvanado',
        'Planchado Lienzos',
        'Corte',
        'Confección',
        'Deshilado',
        'Plancha Final',
        'Calidad',
        'Embalaje',
        'Conteo Final',
        'Distribución'
    ];

    // =========================================================
    // 📄 VISTA DEL FLUJO COMPLETO POR LOTE (NUEVO)
    // =========================================================
    public function index(Lote $lote)
    {
        $flujos = $lote->flujos()
            ->orderBy('id')
            ->get();

        return view('flujo.index', compact('lote', 'flujos'));
    }

    // =========================================================
    // ➕ CREAR SIGUIENTE ETAPA (NUEVO – CONTROLADO)
    // =========================================================
    public function crearSiguiente(Lote $lote)
    {
        $ultimo = $lote->flujos()
            ->orderByDesc('id')
            ->first();

        // 🔒 No permite avanzar sin check de supervisor
        if ($ultimo && !$ultimo->check_supervisor) {
            return back()->with('error', 'El supervisor debe validar el área actual');
        }

        // Determina el índice del siguiente proceso
        $indice = $ultimo
            ? array_search($ultimo->area, $this->areas) + 1
            : 0;

        // 🚫 Ya no hay más áreas
        if (!isset($this->areas[$indice])) {
            return back()->with('info', 'El lote ya completó todo el flujo de producción');
        }

        // Crear siguiente flujo
        FlujoProduccion::create([
            'lote_id' => $lote->id,
            'area'    => $this->areas[$indice]
        ]);

        // Actualiza área actual del lote (NO rompe nada)
        $lote->update([
            'area_actual' => $this->areas[$indice]
        ]);

        return back()->with('success', 'Nueva etapa habilitada correctamente');
    }

    // =========================================================
    // ▶ INICIAR ETAPA (YA EXISTENTE – NO TOCADO)
    // =========================================================
    public function iniciar(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'area'    => 'required'
        ]);

        $lote = Lote::findOrFail($request->lote_id);

        $existe = FlujoProduccion::where('lote_id', $lote->id)
            ->where('area', $request->area)
            ->whereNull('fecha_fin')
            ->exists();

        if ($existe) {
            return back()->with('error', 'Este lote ya tiene una etapa activa en esta área');
        }

        FlujoProduccion::create([
            'lote_id'        => $lote->id,
            'area'           => $request->area,
            'fecha_inicio'   => now(),
            'conteo_inicial' => $request->conteo_inicial,
            'operador_id'    => auth()->id(),
        ]);

        $lote->update([
            'area_actual' => $request->area
        ]);

        return back()->with('success', 'Etapa iniciada correctamente');
    }

    // =========================================================
    // ⏹ FINALIZAR ETAPA (YA EXISTENTE)
    // =========================================================
    public function finalizar(Request $request, $id)
    {
        $flujo = FlujoProduccion::findOrFail($id);

        if ($flujo->fecha_fin) {
            abort(400);
        }

        $flujo->update([
            'fecha_fin'     => now(),
            'conteo_final'  => $request->conteo_final,
            'observaciones' => $request->observaciones
        ]);

        return back()->with('success', 'Etapa finalizada');
    }

    // =========================================================
    // 🔐 AUTORIZACIÓN ADMIN (YA EXISTENTE)
    // =========================================================
    public function autorizar($id)
    {
        if (auth()->user()->rol !== 'Administrador General') {
            abort(403);
        }

        $flujo = FlujoProduccion::findOrFail($id);

        $flujo->update([
            'autorizado_por'     => auth()->id(),
            'fecha_autorizacion' => now()
        ]);

        return back()->with('success', 'Proceso autorizado');
    }

    // =========================================================
    // ✅ CHECK SUPERVISOR (AJUSTADO A RUTA NUEVA)
    // =========================================================
    public function checkSupervisor(FlujoProduccion $flujo)
    {
        if (!in_array(auth()->user()->rol, [
            'Supervisor de Área',
            'Supervisor General de Producción'
        ])) {
            abort(403);
        }

        $flujo->update([
            'check_supervisor' => true,
            'completado'       => true,
            'supervisor_id'    => auth()->id(),
            'fecha_check'      => now()
        ]);

        return back()->with('success', 'Área validada correctamente');
    }
}
