<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar campos
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar autenticar con campo 'usuario'
        $credentials = [
            'usuario' => $request->usuario,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            switch ($user->rol) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'inventario':
                    return redirect()->route('inventario.dashboard');
                case 'procesos':
                    return redirect()->intended(route('procesos.iniciar'));
                case 'produccion':
                    return redirect()->route('produccion.registrar');
                case 'despachos':
                    return redirect()->route('despachos.registrar');
                default:
                    Auth::logout();
                    return back()->withErrors(['usuario' => 'Rol no autorizado']);
            }
        }

        return back()->withErrors([
            'usuario' => 'Usuario o contraseña incorrectos',
        ])->onlyInput('usuario');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}