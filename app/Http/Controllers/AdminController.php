<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function cambiarRol(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'rol' => 'required|in:Administrador,Supervisor,Operario'
        ]);

        $user->update([
            'rol' => $request->rol
        ]);

        return back()->with('success', 'Rol actualizado correctamente');
    }
}
