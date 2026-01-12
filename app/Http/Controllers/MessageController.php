<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Papeleta;
use App\Models\Lote;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
{
    $authUser = auth()->user();

    /* ================= MÉTRICAS DASHBOARD ================= */

    $totalPapeletas = Papeleta::count();

    // 🔥 EXACTAMENTE LOS NOMBRES QUE LA VISTA USA
    $lotesPendientes = Lote::where('estado', 'pendiente')->count();
    $lotesProceso    = Lote::where('estado', 'proceso')->count();
    $lotesTerminados = Lote::where('estado', 'terminado')->count();

    /* ================= MENSAJERÍA ================= */

    // 🔥 LA VISTA USA $users (NO $usuarios)
    $users = User::where('id', '!=', $authUser->id)->get();

    $selectedUser = null;
    $conversation = collect();

    if ($request->filled('user')) {
        $selectedUser = User::findOrFail($request->user);

        $conversation = Message::where(function ($q) use ($authUser, $selectedUser) {
                $q->where('emisor_id', $authUser->id)
                  ->where('receptor_id', $selectedUser->id);
            })
            ->orWhere(function ($q) use ($authUser, $selectedUser) {
                $q->where('emisor_id', $selectedUser->id)
                  ->where('receptor_id', $authUser->id);
            })
            ->orderBy('created_at')
            ->get();

        Message::where('emisor_id', $selectedUser->id)
            ->where('receptor_id', $authUser->id)
            ->where('leido', 0)
            ->update(['leido' => 1]);
    }

    $messages = Message::where('receptor_id', $authUser->id)->get();

    // Roles (panel admin)
    $roles = Role::all();

    return view('dashboard', compact(
        'users',
        'selectedUser',
        'conversation',
        'messages',
        'roles',
        'totalPapeletas',
        'lotesPendientes',
        'lotesProceso',
        'lotesTerminados'
    ));
}

}
