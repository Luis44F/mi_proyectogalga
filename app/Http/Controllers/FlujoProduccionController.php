<?php

namespace App\Http\Controllers;

use App\Models\FlujoProduccion;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // 📸 Necesario para guardar evidencias

class FlujoProduccionController extends Controller
{
    /**
     * 🧠 ORDEN OFICIAL DEL FLUJO (Legacy / Manual)
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
    // 📄 VISTA DEL FLUJO COMPLETO POR LOTE
    // =========================================================
    public function index(Lote $lote)
    {
        $flujos = $lote->flujos()
            ->orderBy('orden') // ⚡ Ajustado a 'orden' para el nuevo sistema, fallback a id
            ->get();

        return view('flujo.index', compact('lote', 'flujos'));
    }

    // =========================================================
    // ➕ CREAR SIGUIENTE ETAPA (MANUAL - Legacy)
    // =========================================================
    public function crearSiguiente(Lote $lote)
    {
        $ultimo = $lote->flujos()->orderByDesc('id')->first();

        if ($ultimo && !$ultimo->check_supervisor) {
            return back()->with('error', 'El supervisor debe validar el área actual');
        }

        $indice = $ultimo ? array_search($ultimo->area, $this->areas) + 1 : 0;

        if (!isset($this->areas[$indice])) {
            return back()->with('info', 'El lote ya completó todo el flujo de producción');
        }

        FlujoProduccion::create([
            'lote_id' => $lote->id,
            'area'    => $this->areas[$indice],
            // Asignamos orden manual si se usa este método antiguo
            'orden'   => $indice + 1 
        ]);

        $lote->update(['area_actual' => $this->areas[$indice]]);

        return back()->with('success', 'Nueva etapa habilitada correctamente');
    }

    // =========================================================
    // ▶ INICIAR ETAPA (MANUAL)
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

        // Si ya existe el registro por el Observer, lo actualizamos en vez de crear
        $flujoExistente = FlujoProduccion::where('lote_id', $lote->id)
            ->where('area', $request->area)
            ->first();

        if ($flujoExistente) {
            $flujoExistente->update([
                'fecha_inicio'   => now(),
                'conteo_inicial' => $request->conteo_inicial,
                'operador_id'    => auth()->id(),
            ]);
        } else {
            FlujoProduccion::create([
                'lote_id'        => $lote->id,
                'area'           => $request->area,
                'fecha_inicio'   => now(),
                'conteo_inicial' => $request->conteo_inicial,
                'operador_id'    => auth()->id(),
            ]);
        }

        $lote->update(['area_actual' => $request->area]);

        return back()->with('success', 'Etapa iniciada correctamente');
    }

    // =========================================================
    // ⏹ FINALIZAR ETAPA (SIMPLE)
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
    // 🔐 AUTORIZACIÓN ADMIN
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
    // ✅ CHECK SUPERVISOR
    // =========================================================
    public function checkSupervisor(FlujoProduccion $flujo)
    {
        if (!in_array(auth()->user()->rol, ['Supervisor de Área', 'Supervisor General de Producción'])) {
            abort(403);
        }

        $flujo->update([
            'check_supervisor' => true,
            'completado'       => true,
            'check_proceso'    => true, // Sincronizamos ambos campos
            'supervisor_id'    => auth()->id(),
            'fecha_check'      => now()
        ]);

        return back()->with('success', 'Área validada correctamente');
    }

    // =========================================================
    // 🚀 NUEVO MOTOR DE VALIDACIÓN (MES)
    // =========================================================

    public function validar(Request $request, FlujoProduccion $flujo)
    {
        /*
        |-----------------------------------------
        | 1. Validación estricta
        |-----------------------------------------
        */
        $request->validate([
            'foto' => 'required|image|max:5048', // Aumenté un poco el límite a 5MB
            'observaciones' => 'nullable|string',
        ]);

        /*
        |-----------------------------------------
        | 2. Bloquear doble validación
        |-----------------------------------------
        */
        if ($flujo->check_proceso) {
            return back()->with('error', 'Esta fase ya fue validada anteriormente.');
        }

        /*
        |-----------------------------------------
        | 3. Bloquear salto de fases (Secuencialidad)
        |-----------------------------------------
        */
        $faseAnterior = FlujoProduccion::where('lote_id', $flujo->lote_id)
            ->where('orden', $flujo->orden - 1)
            ->first();

        // Si existe una fase anterior y NO está terminada, bloqueamos.
        if ($faseAnterior && !$faseAnterior->check_proceso) {
            return back()->with('error', 'No puedes validar esta fase sin terminar la fase anterior: ' . $faseAnterior->area);
        }

        /*
        |-----------------------------------------
        | 4. Guardar evidencia fotográfica
        |-----------------------------------------
        */
        $path = null;
        if ($request->hasFile('foto')) {
            $nombre = 'lote_'.$flujo->lote_id.'_fase'.$flujo->orden.'_'.time().'.jpg';
            $path = $request->file('foto')->storeAs(
                'evidencias_flujo',
                $nombre,
                'public'
            );
        }

        /*
        |-----------------------------------------
        | 5. Cerrar fase (Actualiza Motor y Legacy)
        |-----------------------------------------
        */
        $flujo->update([
            // Campos del Motor MES
            'check_proceso'  => true,
            'evidencia_foto' => $path,
            
            // Campos Legacy (compatibilidad)
            'completado'     => true, 
            'fecha_fin'      => now(),
            
            // Datos generales
            'operador_id'    => auth()->id(),
            'observaciones'  => $request->observaciones,
        ]);

        /*
        |-----------------------------------------
        | 6. Avanzar lote automáticamente
        |-----------------------------------------
        */
        $this->avanzarLote($flujo);

        return back()->with('success', 'Fase validada y evidencia guardada correctamente.');
    }

    /**
     * Mueve el estado del lote a la siguiente fase disponible
     */
    private function avanzarLote(FlujoProduccion $flujo)
    {
        $lote = $flujo->lote;

        // Buscar siguiente fase basada en el orden numérico
        $siguiente = FlujoProduccion::where('lote_id', $lote->id)
            ->where('orden', $flujo->orden + 1)
            ->first();

        if ($siguiente) {
            // Avanza área actual
            $lote->update([
                'area_actual' => $siguiente->area, // Usamos el nombre real guardado en DB
            ]);
        } else {
            // Última fase → cerrar lote
            $lote->update([
                'estado' => 'TERMINADO',
                'area_actual' => 'Distribución / Finalizado',
            ]);
        }
    }
}