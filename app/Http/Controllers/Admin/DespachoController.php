<?php
// app/Http/Controllers/Admin/DespachoController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Despacho;
use App\Models\Produccion;
use App\Models\PaqueteItem;

class DespachoController extends Controller
{
    public function lista()
    {
        $despachos = Despacho::orderBy('fecha', 'desc')->get();
        return view('despachos.lista', compact('despachos'));
    }
    // Muestra el formulario con búsqueda
    public function create(Request $request)
    {
        $buscar = $request->input('buscar', '');
        $lote = '';
        $producto = '';
        $presentacion = '';
        $mensaje = '';
        $origen = ''; // 'produccion' o 'paquete'

        if (!empty($buscar)) {
            $buscar = strtoupper(preg_replace('/\s+/', '', $buscar));
            $encontrado = false;

            // Buscar en produccion
            $prod = Produccion::whereRaw("REPLACE(REPLACE(REPLACE(TRIM(lote),' ',''),'\t',''),'\r','') = ?", [$buscar])
                ->select('lote', 'tipo_producto as producto', 'presentacion')
                ->first();

            if ($prod) {
                $lote = $buscar;
                $producto = $prod->producto;
                $presentacion = $prod->presentacion;
                $origen = 'produccion';
                $encontrado = true;
            }

            if (!$encontrado) {
                // Buscar en paquete_items (datos JSON)
                $paq = PaqueteItem::whereRaw("REPLACE(REPLACE(REPLACE(JSON_UNQUOTE(JSON_EXTRACT(datos, '$.lote')),' ',''),'\t',''),'\r','') = ?", [$buscar])
                    ->first();

                if ($paq) {
                    $datos = is_array($paq->datos) ? $paq->datos : json_decode($paq->datos, true);
                    $lote = $buscar;
                    $producto = $datos['tipo_producto'] ?? '';
                    $presentacion = $datos['presentacion'] ?? '';
                    $origen = 'paquete';
                    $encontrado = true;
                }
            }

            if (!$encontrado) {
                $mensaje = "❌ No se encontró el lote en producción ni en paquetes.";
            }
        }

        return view('despachos.registrar', compact('buscar', 'lote', 'producto', 'presentacion', 'mensaje', 'origen'));
    }

    // Guardar despacho
    public function store(Request $request)
    {
        $request->validate([
            'fecha'          => 'required|date',
            'cliente'        => 'required|string|max:150',
            'remision'       => 'nullable|string|max:100',
            'producto'       => 'required|string|max:150',
            'presentacion'   => 'required|string|max:150',
            'cantidad'       => 'required|numeric|min:0.01',
            'lote'           => 'required|string',
            'despachado_por' => 'nullable|string|max:100',
            'conductor'      => 'nullable|string|max:100',
            'observaciones'  => 'nullable|string',
            'origen'         => 'nullable|string', // 'produccion' o 'paquete' (viene del hidden)
        ]);

        DB::beginTransaction();
        try {
            // Insertar despacho
            $despacho = Despacho::create([
                'fecha'          => $request->fecha,
                'cliente'        => $request->cliente,
                'remision'       => $request->remision,
                'producto'       => $request->producto,
                'presentacion'   => $request->presentacion,
                'cantidad_kg'    => $request->cantidad,
                'lote'           => $request->lote,
                'despachado_por' => $request->despachado_por ?? auth()->user()->usuario,
                'conductor'      => $request->conductor,
                'observaciones'  => $request->observaciones,
            ]);

            // Eliminar el lote de su origen (si se especificó)
            $origen = $request->origen;
            if ($origen === 'produccion') {
                Produccion::where('lote', $request->lote)->delete();
            } elseif ($origen === 'paquete') {
                PaqueteItem::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(datos, '$.lote')) = ?", [$request->lote])->delete();
            }

            DB::commit();
            return redirect()->route('despachos.registrar')
                ->with('success', '✅ Despacho registrado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => '❌ Error al despachar: ' . $e->getMessage()])->withInput();
        }
    }
    // En edit()
    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);
        if (request()->wantsJson()) {
            return response()->json($inventario);
        }
        return view('admin.inventarios.edit', compact('inventario'));
    }

    // En update()
    public function update(Request $request, $id)
    {
        // ... validaciones
        $inventario->update($request->all());
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Actualizado');
    }

    // En destroy()
    public function destroy(Request $request, $id)
    {
        // ... eliminar
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Eliminado');
    }
}