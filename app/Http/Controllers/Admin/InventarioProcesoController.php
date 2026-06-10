<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventarioProceso;
use Illuminate\Http\Request;

class InventarioProcesoController extends Controller
{

    /**
     * Muestra el formulario de edición (vista normal) O devuelve JSON si es AJAX.
     */
    public function edit($id)
    {
        $proceso = InventarioProceso::findOrFail($id);
        
        // Si la petición espera JSON (por ejemplo, desde el modal)
        if (request()->wantsJson()) {
            return response()->json($proceso);
        }
        
        return view('procesos.edit', compact('proceso'));
    }

    /**
     * Actualiza el registro. Responde con JSON si es AJAX, o redirige si es normal.
     */
    public function update(Request $request, $id)
    {
        $proceso = InventarioProceso::findOrFail($id);
        
        $request->validate([
            'peso'   => 'required|numeric|min:0',
            'puerto' => 'required|in:1,2',
            'fecha_inicio' => 'required|date',
        ]);
        
        $proceso->update($request->all());
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Proceso actualizado']);
        }
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Proceso actualizado correctamente.');
    }

    /**
     * Elimina el registro. Responde con JSON si es AJAX, o redirige si es normal.
     */
    public function destroy(Request $request, $id)
    {
        $proceso = InventarioProceso::findOrFail($id);
        $proceso->delete();
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Proceso eliminado']);
        }
        
        return back()->with('success', 'Proceso eliminado.');
    }

    /**
     * Función obsoleta (guardar paquete) – se conserva por compatibilidad.
     */
    public function guardarPaquete(Request $request)
    {
        return back()->with('success', 'Función "Guardar Proceso" en desarrollo.');
    }

    public function lista()
    {
        $procesos = InventarioProceso::orderBy('fecha_inicio', 'desc')->get();
        return view('procesos.lista', compact('procesos'));
    }
}