<?php

namespace App\Http\Controllers;

use App\Models\Papeleta;
use Illuminate\Http\Request;

class PapeletaController extends Controller
{
    /* =========================
     |   LISTADO DE PAPELETAS
     |=========================*/
    public function index()
    {
        $papeletas = Papeleta::orderBy('id', 'desc')->get();

        return view('papeletas.papeleta', [
            'papeletas' => $papeletas,
            'papeleta'  => null
        ]);
    }

    /* =========================
     |   VER ÚLTIMA PAPELETA
     |=========================*/
    public function ver()
    {
        $papeleta = Papeleta::latest()->first();

        if (!$papeleta) {
            abort(404, 'No hay papeletas registradas');
        }

        return view('papeletas.papeleta', [
            'papeletas' => null,
            'papeleta'  => $papeleta
        ]);
    }

    /* =========================
     |   VER PAPELETA ESPECÍFICA
     |=========================*/
    public function show(Papeleta $papeleta)
    {
        $papeleta->load('lotes');

        return view('papeletas.papeleta', [
            'papeletas' => null,
            'papeleta'  => $papeleta
        ]);
    }

    /* =========================
     |   CREAR PAPELETA (ADMIN)
     |=========================*/
    public function create()
    {
        if (auth()->user()->rol !== 'Administrador') {
            abort(403);
        }

        return view('papeletas.create');
    }

    /* =========================
     |   GUARDAR PAPELETA
     |=========================*/
    public function store(Request $request)
    {
        if (auth()->user()->rol !== 'Administrador') {
            abort(403);
        }

        $data = $request->validate([
            'cliente'        => 'required|string',
            'modelo'         => 'required|string',
            'talla'          => 'required|string',
            'piezas_totales' => 'required|integer|min:1',
            'marca'          => 'nullable|string',
            'color'          => 'nullable|string',
            'material'       => 'nullable|string',
            'observaciones'  => 'nullable|string',
        ]);

        $data['estado'] = 'CREADA';

        Papeleta::create($data);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Papeleta creada correctamente');
    }

    /* =========================
     |   AUTORIZAR PAPELETA
     |=========================*/
    public function autorizar(Papeleta $papeleta)
    {
        if (auth()->user()->rol !== 'Administrador') {
            abort(403);
        }

        // 🔒 Validación de estado
        if ($papeleta->estado !== 'CREADA') {
            return back()->with('error', 'La papeleta ya fue procesada.');
        }

        $papeleta->update([
            'estado'              => 'AUTORIZADA',
            'autorizado_por'      => auth()->id(),
            'fecha_autorizacion'  => now(),
        ]);

        return redirect()
            ->route('papeleta.ver')
            ->with('success', 'Papeleta autorizada correctamente.');
    }

    /* =========================
     |   DETENER PAPELETA
     |=========================*/
    public function detener(Papeleta $papeleta)
    {
        if (auth()->user()->rol !== 'Administrador') {
            abort(403);
        }

        $papeleta->update([
            'estado' => 'DETENIDA'
        ]);

        return back()->with('success', 'Papeleta detenida');
    }

    /* =========================
     |   REACTIVAR PAPELETA
     |=========================*/
    public function reactivar(Papeleta $papeleta)
    {
        if (auth()->user()->rol !== 'Administrador') {
            abort(403);
        }

        if ($papeleta->estado !== 'DETENIDA') {
            return back();
        }

        $papeleta->update([
            'estado' => 'AUTORIZADA'
        ]);

        return back()->with('success', 'Papeleta reactivada');
    }
}
