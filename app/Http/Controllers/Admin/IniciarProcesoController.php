<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventario;
use App\Models\InventarioProceso;
use App\Models\Trazabilidad;

class IniciarProcesoController extends Controller
{
    public function index(Request $request)
    {
        $codigo = trim($request->input('codigo', ''));
        $resultado = null;
        $mensaje = null;

        if ($codigo !== '') {
            $inventario = Inventario::where('codigo_paca', $codigo)->first();
            if ($inventario) {
                $resultado = [
                    'codigo_paca'   => $inventario->codigo_paca,
                    'proveedor'     => $inventario->proveedor,
                    'fecha'         => $inventario->fecha,
                    'peso'          => $inventario->peso,
                    'tipo_material' => $inventario->tipo_material,
                    'tipo_producto' => $inventario->tipo_producto,
                    'en_proceso'    => false,
                    'puerto'        => null,
                ];
            } else {
                $mensaje = "Código no encontrado en inventario (puede estar agotado).";
            }
        }

        return view('procesos.iniciar', compact('codigo', 'resultado', 'mensaje'));
    }

    public function iniciarProceso(Request $request)
    {
        $request->validate([
            'codigo'   => 'required|string',
            'puerto'   => 'required|in:1,2',
            'cantidad' => 'required|numeric|min:0.01'
        ]);

        $codigo   = $request->codigo;
        $puerto   = $request->puerto;
        $cantidad = $request->cantidad;

        DB::beginTransaction();

        try {
            $inventario = Inventario::where('codigo_paca', $codigo)->lockForUpdate()->first();

            if (!$inventario) {
                throw new \Exception("El código no existe en inventario o ya está agotado.");
            }

            if ($cantidad > $inventario->peso) {
                throw new \Exception("La cantidad a procesar ($cantidad kg) supera el peso disponible ({$inventario->peso} kg).");
            }

            // Generar lote de proceso único por puerto y fecha
            $loteProceso = $this->generarLoteProceso($puerto);

            // 1. Guardar en inventario_proceso (incluir iniciado_por)
            $proceso = InventarioProceso::create([
                'hora'            => $inventario->hora,
                'proveedor'       => $inventario->proveedor,
                'codigo_proveedor'=> $inventario->codigo_proveedor,
                'tipo_material'   => $inventario->tipo_material,
                'tipo_producto'   => $inventario->tipo_producto,
                'peso'            => $cantidad,
                'codigo_paca'     => $inventario->codigo_paca,
                'lote_proceso'    => $loteProceso,
                'puerto'          => $puerto,
                'fecha_inicio'    => now(),
                'iniciado_por'    => auth()->user()->usuario ?? auth()->user()->name,
            ]);

            // 2. Registrar en trazabilidad
            Trazabilidad::create([
                'codigo_paca'     => $inventario->codigo_paca,
                'lote_proceso'    => $loteProceso,
                'tipo_evento'     => 'proceso',
                'fecha_evento'    => now(),
                'proveedor'       => $inventario->proveedor,
                'tipo_material'   => $inventario->tipo_material,
                'tipo_producto'   => $inventario->tipo_producto,
                'peso'            => $cantidad,
                'puerto'          => $puerto,
                'usuario_registra'=> auth()->user()->usuario ?? auth()->user()->name,
                'observaciones'   => "Inicio de proceso - Puerto $puerto - Cantidad $cantidad kg",
            ]);

            // Actualizar inventario
            $nuevoPeso = $inventario->peso - $cantidad;
            if ($nuevoPeso <= 0) {
                $inventario->delete();
                $mensajeExito = "Se inició proceso de $cantidad kg del código $codigo (Puerto $puerto). Lote generado: $loteProceso. El lote original se ha agotado completamente.";
            } else {
                $inventario->peso = $nuevoPeso;
                $inventario->save();
                $mensajeExito = "Se inició proceso de $cantidad kg del código $codigo (Puerto $puerto). Lote generado: $loteProceso. Restante en inventario: $nuevoPeso kg.";
            }

            DB::commit();

            return redirect()->route('procesos.iniciar')
                ->with('success', $mensajeExito);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Genera lote de proceso único con formato: PROC-{puerto}-{YYYYMMDD}-{secuencial}
     */
    private function generarLoteProceso($puerto)
    {
        $fecha = date('Ymd');
        $prefijo = "PROC-{$puerto}-{$fecha}";
        
        $ultimo = InventarioProceso::where('lote_proceso', 'LIKE', $prefijo . '-%')
            ->orderBy('lote_proceso', 'desc')
            ->first();

        if ($ultimo) {
            $partes = explode('-', $ultimo->lote_proceso);
            $numero = (int) end($partes) + 1;
        } else {
            $numero = 1;
        }

        return $prefijo . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }

    // Los siguientes métodos son para la edición desde el dashboard (si se usan)
    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);
        if (request()->wantsJson()) {
            return response()->json($inventario);
        }
        return view('admin.inventarios.edit', compact('inventario'));
    }

    public function update(Request $request, $id)
    {
        $inventario = Inventario::findOrFail($id);
        // validaciones (adaptar según necesidad)
        $inventario->update($request->all());
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Actualizado');
    }

    public function destroy(Request $request, $id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Eliminado');
    }
}