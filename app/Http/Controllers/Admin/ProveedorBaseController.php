<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProveedorBase;
use Illuminate\Http\Request;

class ProveedorBaseController extends Controller
{
    // No uses __construct() con $this->middleware

    public function index()
    {
        $proveedores = ProveedorBase::orderBy('codigo_proveedor')->get();
        return view('admin.proveedores.index', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_proveedor' => 'required|string|max:10|unique:proveedores_base',
            'proveedor' => 'required|string|max:255',
        ]);

        ProveedorBase::create($request->only('codigo_proveedor', 'proveedor'));

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $proveedor = ProveedorBase::findOrFail($id);
        $request->validate([
            'codigo_proveedor' => 'required|string|max:10|unique:proveedores_base,codigo_proveedor,' . $id,
            'proveedor' => 'required|string|max:255',
        ]);

        $proveedor->update($request->only('codigo_proveedor', 'proveedor'));

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor actualizado.');
    }

    public function destroy($id)
    {
        $proveedor = ProveedorBase::findOrFail($id);
        // Verificar si tiene material asociado en inventario
        $tieneInventario = \App\Models\Inventario::where('codigo_proveedor', $proveedor->codigo_proveedor)->exists();
        if ($tieneInventario) {
            return back()->with('error', 'No se puede eliminar el proveedor porque tiene material asociado en inventario.');
        }
        $proveedor->delete();
        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor eliminado.');
    }
    public function todos()
    {
        $proveedores = \App\Models\ProveedorBase::orderBy('codigo_proveedor')->get();
        return response()->json($proveedores);
    }

        public function json()
    {
        $proveedores = ProveedorBase::select('codigo_proveedor', 'proveedor')->get();
        return response()->json($proveedores);
    }

}