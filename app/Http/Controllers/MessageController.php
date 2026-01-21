<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Papeleta;
use App\Models\Lote;
use App\Models\Role;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();
        $authId   = $authUser->id;

        /* ================= MÉTRICAS DASHBOARD ================= */

        $totalPapeletas = Papeleta::count();

        $lotesPendientes = Lote::where('estado', 'pendiente')->count();
        $lotesProceso    = Lote::where('estado', 'proceso')->count();
        $lotesTerminados = Lote::where('estado', 'terminado')->count();

        /* ================= MENSAJERÍA ================= */

        $users = User::where('id', '!=', $authId)
            ->withCount([
                'receivedMessages as unread_count' => function ($q) use ($authId) {
                    $q->where('receptor_id', $authId)
                      ->where('leido', 0);
                }
            ])
            ->get()
            ->sortByDesc(fn ($u) => optional($u->lastMessage)->created_at);

        $selectedUser = null;
        $conversation = collect();

        if ($request->filled('user')) {
            $selectedUser = User::findOrFail($request->user);

            $conversation = Message::where(function ($q) use ($authId, $selectedUser) {
                    $q->where('emisor_id', $authId)
                      ->where('receptor_id', $selectedUser->id);
                })
                ->orWhere(function ($q) use ($authId, $selectedUser) {
                    $q->where('emisor_id', $selectedUser->id)
                      ->where('receptor_id', $authId);
                })
                ->orderBy('created_at')
                ->get();

            Message::where('emisor_id', $selectedUser->id)
                ->where('receptor_id', $authId)
                ->where('leido', 0)
                ->update(['leido' => 1]);
        }

        $messages = Message::where('receptor_id', $authId)->get();
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

    /* ================= ENVIAR MENSAJE ================= */

    public function store(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required|exists:users,id',
            'mensaje'     => 'required|string',
        ]);

        Message::create([
            'emisor_id'   => auth()->id(),
            'receptor_id' => $request->receptor_id,
            'mensaje'     => $request->mensaje,
            'leido'       => 0,
        ]);

        return back();
    }

    /* ================= TIEMPO REAL (FETCH) ================= */

    public function fetch($userId)
    {
        $authId = auth()->id();

        $messages = Message::where(function ($q) use ($authId, $userId) {
                $q->where('emisor_id', $authId)
                  ->where('receptor_id', $userId);
            })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('emisor_id', $userId)
                  ->where('receptor_id', $authId);
            })
            ->orderBy('created_at')
            ->get();

        // marcar como leídos
        Message::where('emisor_id', $userId)
            ->where('receptor_id', $authId)
            ->where('leido', 0)
            ->update(['leido' => 1]);

        return response()->json($messages);
    }
}
