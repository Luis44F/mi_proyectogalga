<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    // -----------------------------
    // REGISTRO USANDO ENUM `rol`
    // -----------------------------
    public function registrar(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6',
            'telefono'        => 'required',
            'rol'             => 'required|in:Administrador,Supervisor,Operario',
        ]);

        $user = User::create([
            'nombre_completo' => $request->nombre_completo,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'telefono'        => $request->telefono,
            'rol'             => $request->rol,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
