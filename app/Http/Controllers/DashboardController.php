<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        // Usuarios para mensajería (menos el mismo)
        $users = User::where('id', '!=', $authUser->id)->get();

        // Usuario seleccionado en el chat
        $selectedUser = null;
        $conversation = collect();

        if ($request->has('user')) {
            $selectedUser = User::find($request->user);

            if ($selectedUser) {
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
            }
        }

        // Mensajes recibidos
        $messages = Message::where('receptor_id', $authUser->id)->get();

        return view('dashboard', [
            'users'             => $users,
            'selectedUser'      => $selectedUser,
            'conversation'      => $conversation,
            'messages'          => $messages,

            // Métricas (por ahora en 0 para no romper diseño)
            'totalPapeletas'    => 0,
            'lotesPendientes'   => 0,
            'lotesProceso'      => 0,
            'lotesTerminados'   => 0,
        ]);
    }
}
