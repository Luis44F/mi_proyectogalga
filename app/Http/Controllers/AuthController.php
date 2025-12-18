<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar vista login
    public function mostrarLogin() {
        return view('inicio_sesion');
    }

    // Mostrar vista registro
    public function mostrarRegistro() {
        return view('login');
    }

    // Procesar registro
  public function registrar(Request $request)
{
    // Validación
    $request->validate([
        'nombre_completo' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'telefono' => 'nullable',
        'rol' => 'required'
    ]);

    // Crear usuario - USAR LOS NOMBRES DE COLUMNA REALES
    User::create([
        'nombre_completo' => $request->nombre_completo,
        'email'           => $request->email,
        'password'        => Hash::make($request->password),
        'telefono'        => $request->telefono,
        'rol'             => $request->rol,
    ]);

    return redirect()->route('login')->with('success', 'Cuenta creada correctamente, inicia sesión.');
}


    // Procesar login
    public function login(Request $request) {

        $credenciales = $request->only('email', 'password');

        if (Auth::attempt($credenciales)) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Correo o contraseña incorrectos']);
    }
}
