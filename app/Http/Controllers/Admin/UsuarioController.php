<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{

    public function index()
    {
        $usuarios = User::orderBy('name')->paginate(15);
        return view('profile.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:50|unique:users',
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|email|max:255|unique:users',
            'password'=> 'required|string|min:6|confirmed',
            'rol'     => 'required|in:admin,inventario,procesos,despachos,produccion',
            'telefono'=> 'nullable|string|max:20',
        ]);

        User::create([
            'usuario' => $request->usuario,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'telefono' => $request->telefono,
            'activo' => true,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'usuario' => 'required|string|max:50|unique:users,usuario,' . $usuario->id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'rol' => 'required|in:admin,inventario,procesos,despachos,produccion',
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'usuario' => $request->usuario,
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'telefono' => $request->telefono,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado');
    }

    public function destroy(User $usuario)
    {
        // Evitar que se elimine a sí mismo
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo');
        }

        $usuario->delete();
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado');
    }

    public function toggleActivo(User $usuario)
    {
        $usuario->update(['activo' => !$usuario->activo]);
        return back()->with('success', 'Estado actualizado');
    }
}