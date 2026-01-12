<?php

namespace App\Http\Controllers;

use App\Models\Papeleta;
use App\Models\Lote;
use Illuminate\Http\Request;

class PapeletaController extends Controller
{
    public function index()
    {
        $papeletas = Papeleta::orderBy('id', 'desc')->get();
        return view('papeletas.index', compact('papeletas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required',
            'modelo' => 'required',
            'piezas_totales' => 'required|integer'
        ]);

        Papeleta::create($request->all());

        return redirect()->back();
    }

    // 🔥 VER LOTES DE UNA PAPELETA
    public function show($id)
    {
        $papeleta = Papeleta::with('lotes.usuario')->findOrFail($id);

        return view('papeletas.show', compact('papeleta'));
    }
}
