<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trazabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class TrazabilidadController extends Controller
{
    public function index(Request $request)
    {
        $query = Trazabilidad::query();

        // Filtros
        if ($request->filled('codigo_paca')) {
            $query->where('codigo_paca', 'like', '%' . $request->codigo_paca . '%');
        }
        if ($request->filled('lote_proceso')) {
            $query->where('lote_proceso', 'like', '%' . $request->lote_proceso . '%');
        }
        if ($request->filled('tipo_evento')) {
            $query->where('tipo_evento', $request->tipo_evento);
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_evento', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_evento', '<=', $request->fecha_hasta);
        }

        $trazabilidad = $query->orderBy('fecha_evento', 'desc')->paginate(30);

        return view('admin.trazabilidad.index', compact('trazabilidad'));
    }

    // Exportar a CSV (mes específico)
    public function exportarCSV(Request $request)
    {
        $request->validate([
            'year'  => 'required|integer|min:2020|max:2100',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $year  = $request->year;
        $month = $request->month;

        $registros = Trazabilidad::whereYear('fecha_evento', $year)
            ->whereMonth('fecha_evento', $month)
            ->orderBy('fecha_evento', 'asc')
            ->get();

        $filename = "trazabilidad_{$year}_{$month}.xls";

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($registros) {
            $file = fopen('php://output', 'w');
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            // Encabezados
            fputcsv($file, [
                'ID', 'Código Paca', 'Lote Proceso', 'Tipo Evento', 'Fecha Evento',
                'Proveedor', 'Cliente', 'Tipo Material', 'Tipo Producto',
                'Peso (kg)', 'Puerto', 'Línea', 'Turno', 'Operador',
                'Usuario Registra', 'Observaciones', 'Creado en'
            ]);

            foreach ($registros as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->codigo_paca,
                    $row->lote_proceso,
                    $row->tipo_evento,
                    $row->fecha_evento,
                    $row->proveedor,
                    $row->cliente,
                    $row->tipo_material,
                    $row->tipo_producto,
                    $row->peso,
                    $row->puerto,
                    $row->linea,
                    $row->turno,
                    $row->operador,
                    $row->usuario_registra,
                    $row->observaciones,
                    $row->created_at,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}