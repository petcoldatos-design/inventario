<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trazabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportarTrazabilidadController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2100',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $year = $request->year;
        $month = $request->month;

        $registros = Trazabilidad::whereYear('fecha_evento', $year)
            ->whereMonth('fecha_evento', $month)
            ->orderBy('fecha_evento', 'asc')
            ->get();

        $filename = "trazabilidad_{$year}_{$month}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($registros) {
            $file = fopen('php://output', 'w');
            // Encabezados UTF-8 BOM para que Excel lea bien las tildes
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            // Cabeceras
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