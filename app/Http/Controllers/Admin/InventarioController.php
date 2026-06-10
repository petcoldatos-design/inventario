<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function create()
    {
        $proveedores = DB::table('proveedores_base')->orderBy('codigo_proveedor')->get();
        return view('inventario.registrar', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'            => 'required|date',
            'hora'             => 'required',
            'codigo_proveedor' => 'required|string|max:50',
            'proveedor'        => 'required|string|max:100',
            'placa'            => 'nullable|string|max:20',
            'procedencia'      => 'required|string|max:100',
            'tipo_material'    => 'required|string|max:50',
            'tipo_resina'      => 'required|string|max:50',
            'color'            => 'required|string|max:30',
            'presentacion'     => 'required|string|max:30',
            'procedencia_tipo' => 'required|string|max:30',
            'tipo_producto'    => 'required|string|max:50',
            'tipo_residuo'     => 'required|string|max:30',
            'historial'        => 'required|string|max:100',
            'peso'             => 'required|numeric|min:0.01',
            'remision'         => 'nullable|string|max:50',
        ]);

        // Generar código de paca único
        $codigo_paca = $this->generarCodigoPaca($request->codigo_proveedor, $request->fecha);

        Inventario::create([
            'fecha'            => $request->fecha,
            'hora'             => $request->hora,
            'placa'            => $request->placa,
            'proveedor'        => $request->proveedor,
            'codigo_proveedor' => $request->codigo_proveedor,
            'procedencia'      => $request->procedencia,
            'tipo_material'    => $request->tipo_material,
            'tipo_resina'      => $request->tipo_resina,
            'color'            => $request->color,
            'presentacion'     => $request->presentacion,
            'procedencia_tipo' => $request->procedencia_tipo,
            'tipo_producto'    => $request->tipo_producto,
            'tipo_residuo'     => $request->tipo_residuo,
            'historial'        => $request->historial,
            'peso'             => $request->peso,
            'remision'         => $request->remision,
            'codigo_paca'      => $codigo_paca,
        ]);

        return redirect()->route('inventario.create')
            ->with('success', 'Material registrado correctamente. Código de paca: ' . $codigo_paca);
    }

    /**
     * Genera un código de paca único con formato PROVEEDOR-YYYYMMDD-NNNNN
     */
    private function generarCodigoPaca($codigoProveedor, $fecha)
    {
        $fechaCod = date('Ymd', strtotime($fecha));
        $base = $codigoProveedor . '-' . $fechaCod;

        $ultimo = Inventario::where('codigo_paca', 'LIKE', $base . '-%')
            ->orderBy('codigo_paca', 'desc')
            ->first();

        if ($ultimo) {
            $partes = explode('-', $ultimo->codigo_paca);
            $ultimoNumero = (int) end($partes);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return $base . '-' . str_pad($nuevoNumero, 5, '0', STR_PAD_LEFT);
    }

    // Métodos adicionales (buscarProveedores, ajaxProveedor, edit, update, destroy)
    public function buscarProveedores(Request $request)
    {
        $q = $request->input('q');
        if (strlen($q) < 1) return response()->json([]);
        $proveedores = DB::table('proveedores_base')
            ->where('codigo_proveedor', 'LIKE', "%{$q}%")
            ->orWhere('proveedor', 'LIKE', "%{$q}%")
            ->limit(10)
            ->get(['codigo_proveedor', 'proveedor']);
        return response()->json($proveedores);
    }

    public function ajaxProveedor(Request $request)
    {
        $codigo = $request->input('codigo');
        $proveedor = DB::table('proveedores_base')
            ->where('codigo_proveedor', $codigo)
            ->first();
        if ($proveedor) {
            return response()->json(['nombre_proveedor' => $proveedor->proveedor]);
        }
        return response()->json([]);
    }

    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);
        return view('inventario.edit', compact('inventario'));
    }

    public function update(Request $request, $id)
    {
        $inventario = Inventario::findOrFail($id);
        $request->validate([
            'proveedor' => 'required|string|max:100',
            'peso'      => 'required|numeric|min:0',
            'tipo_material' => 'required|string',
            'color'         => 'required|string',
        ]);
        $inventario->update($request->only([
            'proveedor', 'peso', 'tipo_material', 'color', 'presentacion',
            'codigo_proveedor', 'procedencia', 'tipo_resina', 'procedencia_tipo',
            'tipo_producto', 'tipo_residuo', 'historial', 'remision', 'placa', 'fecha', 'hora'
        ]));
        return redirect()->route('inventario.lista')->with('success', 'Inventario actualizado');
    }

    public function destroy($id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();
        return redirect()->route('inventario.lista')->with('success', 'Inventario eliminado');
    }

    public function lista()
    {
        $inventarios = Inventario::orderBy('fecha', 'desc')->orderBy('hora', 'desc')->get();
        return view('inventario.lista', compact('inventarios'));
    }

}