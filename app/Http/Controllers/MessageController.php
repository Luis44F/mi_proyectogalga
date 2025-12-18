<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Mensajes recibidos (métricas)
        $messages = Message::where('receptor_id', $userId)
            ->with('emisor')
            ->orderBy('created_at', 'desc')
            ->get();

        // Usuarios
        $users = User::where('id', '!=', $userId)->get();

        $selectedUser = null;
        $conversation = collect();

        if ($request->filled('user')) {

            $selectedUser = User::find($request->user);

            if ($selectedUser) {

                $conversation = Message::where(function ($q) use ($userId, $request) {
                        $q->where('emisor_id', $userId)
                          ->where('receptor_id', $request->user);
                    })
                    ->orWhere(function ($q) use ($userId, $request) {
                        $q->where('emisor_id', $request->user)
                          ->where('receptor_id', $userId);
                    })
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Marcar como leídos
                Message::where('emisor_id', $request->user)
                    ->where('receptor_id', $userId)
                    ->where('leido', 0)
                    ->update(['leido' => 1]);
            }
        }

        return view('dashboard', compact(
            'messages',
            'users',
            'selectedUser',
            'conversation'
        ));
    }

    // --------------------------------------------------

    public function store(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required|exists:users,id',
            'mensaje'     => 'required|string',
            'archivo_adj' => 'nullable|file|max:10240' // 10MB
        ]);

        $archivoPath = null;
        $archivoNombreOriginal = null;

        // ✅ PROCESAR ARCHIVO
        if ($request->hasFile('archivo_adj')) {

            $archivo = $request->file('archivo_adj');

            $archivoNombreOriginal = $archivo->getClientOriginalName();

            $archivoPath = $archivo->store('chat_archivos', 'public');
        }

        Message::create([
            'emisor_id'               => Auth::id(),
            'receptor_id'             => $request->receptor_id,
            'mensaje'                 => $request->mensaje,
            'archivo_adj'             => $archivoPath,
            'archivo_nombre_original' => $archivoNombreOriginal,
            'leido'                   => 0
        ]);

        return redirect()
            ->route('dashboard', ['user' => $request->receptor_id]);
    }

    // --------------------------------------------------

    public function markAsRead($id)
    {
        $message = Message::where('id', $id)
            ->where('receptor_id', Auth::id())
            ->firstOrFail();

        $message->update(['leido' => 1]);

        return back();
    }
}
