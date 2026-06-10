<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produccion;
use App\Models\Trazabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduccionController extends Controller
{
    public function lista()
    {
        $producciones = Produccion::orderBy('fecha_produccion', 'desc')->orderBy('hora', 'desc')->get();
        return view('produccion.lista', compact('producciones'));
    }
    /**
     * Muestra el formulario de registro de producción.
     */
    public function create()
    {
        return view('produccion.registrar');
    }

    /**
     * Guarda una nueva producción (registro principal).
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_hora'    => 'required|date',
            'linea'         => 'required|in:Línea de lavado 1,Línea de lavado 2',
            'producto'      => 'required|string|max:100',
            'presentacion'  => 'required|string|max:100',
            'turno'         => 'required|in:1,2',
            'numero_globo'  => 'nullable|string|max:50',
            'peso'          => 'required|numeric|min:0.01',
            'observaciones' => 'nullable|string',
            'operador'      => 'required|string|max:100',
        ]);

        $dt               = new \DateTime($request->fecha_hora);
        $fecha_produccion = $dt->format('Y-m-d');
        $hora             = $dt->format('H:i');
        $linea            = $request->linea;
        $puerto           = ($linea === 'Línea de lavado 1') ? '1' : '2';
        $letra            = ($linea === 'Línea de lavado 1') ? 'A' : 'B';
        $turno            = $request->turno;
        $usuario          = auth()->user()->usuario ?? auth()->user()->name;

        DB::beginTransaction();

        try {
            // Generar lote consecutivo (formato: A2403181-1)
            $base_lote = $letra . $dt->format('ymd') . $turno;
            $ultimo = Produccion::where('lote', 'LIKE', $base_lote . '-%')
                ->orderBy('lote', 'desc')
                ->lockForUpdate()
                ->first();
            $consecutivo = $ultimo ? ((int) explode('-', $ultimo->lote)[1] + 1) : 1;
            $lote = $base_lote . '-' . $consecutivo;

            // Insertar producción
            $produccion = Produccion::create([
                'fecha_produccion' => $fecha_produccion,
                'linea'            => $linea,
                'puerto'           => $puerto,
                'usuario'          => $usuario,
                'hora'             => $hora,
                'presentacion'     => $request->presentacion,
                'turno'            => $turno,
                'lote'             => $lote,
                'numero'           => $request->numero_globo,
                'operador'         => $request->operador,
                'tipo_producto'    => $request->producto,
                'peso'             => $request->peso,
                'observaciones'    => $request->observaciones,
            ]);

            // Registrar en trazabilidad
            Trazabilidad::create([
                'lote_proceso'     => $lote,
                'tipo_evento'      => 'produccion',
                'fecha_evento'     => $dt->format('Y-m-d H:i:s'),
                'tipo_producto'    => $request->producto,
                'peso'             => $request->peso,
                'linea'            => $linea,
                'puerto'           => $puerto,
                'turno'            => $turno,
                'operador'         => $request->operador,
                'usuario_registra' => $usuario,
                'observaciones'    => $request->observaciones,
            ]);

            DB::commit();

            return redirect()->route('produccion.registrar')
                ->with('success', "Producción registrada correctamente. Lote generado: $lote");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Muestra el formulario de edición o devuelve JSON.
     */
    public function edit($id)
    {
        $produccion = Produccion::findOrFail($id);
        if (request()->wantsJson()) {
            return response()->json($produccion);
        }
        return view('admin.producciones.edit', compact('produccion'));
    }

    /**
     * Actualiza producción.
     */
    public function update(Request $request, $id)
    {
        $produccion = Produccion::findOrFail($id);
        $request->validate([
            'peso'         => 'required|numeric|min:0',
            'operador'     => 'required|string|max:100',
            'observaciones'=> 'nullable|string',
        ]);
        $produccion->update($request->only(['peso', 'operador', 'observaciones']));

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Producción actualizada');
    }

    /**
     * Elimina producción.
     */
    public function destroy(Request $request, $id)
    {
        $produccion = Produccion::findOrFail($id);
        $produccion->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Producción eliminada');
    }
}