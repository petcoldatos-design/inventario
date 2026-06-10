<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trazabilidad | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <!-- CSS global -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- CSS específico de trazabilidad -->
    <link rel="stylesheet" href="{{ asset('css/trazabilidad.css') }}">
</head>
<body>
<div class="container-trazabilidad">
    <h1 class="titulo">📋 Trazabilidad de Material (NTC 6632)</h1>

    <!-- Botón exportar (abre modal) -->
    <div style="text-align: right; margin-bottom: 15px;">
        <button class="btn-exportar" onclick="document.getElementById('modalExportar').style.display='flex'">📊 Exportar por mes (CSV)</button>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('admin.trazabilidad.index') }}" class="filtros">
        <div class="grupo">
            <label>Código Paca</label>
            <input type="text" name="codigo_paca" value="{{ request('codigo_paca') }}">
        </div>
        <div class="grupo">
            <label>Lote Proceso</label>
            <input type="text" name="lote_proceso" value="{{ request('lote_proceso') }}">
        </div>
        <div class="grupo">
            <label>Tipo Evento</label>
            <select name="tipo_evento">
                <option value="">Todos</option>
                <option value="ingreso" {{ request('tipo_evento') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                <option value="proceso" {{ request('tipo_evento') == 'proceso' ? 'selected' : '' }}>Proceso</option>
                <option value="produccion" {{ request('tipo_evento') == 'produccion' ? 'selected' : '' }}>Producción</option>
                <option value="despacho" {{ request('tipo_evento') == 'despacho' ? 'selected' : '' }}>Despacho</option>
            </select>
        </div>
        <div class="grupo">
            <label>Fecha Desde</label>
            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
        </div>
        <div class="grupo">
            <label>Fecha Hasta</label>
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
        </div>
        <div class="grupo">
            <button type="submit" class="btn-filtrar">Filtrar</button>
            <a href="{{ route('admin.trazabilidad.index') }}" class="btn-limpiar">Limpiar</a>
        </div>
    </form>

    <!-- Tabla de resultados -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código Paca</th>
                    <th>Lote Proceso</th>
                    <th>Tipo Evento</th>
                    <th>Fecha Evento</th>
                    <th>Proveedor</th>
                    <th>Cliente</th>
                    <th>Tipo Material</th>
                    <th>Tipo Producto</th>
                    <th>Peso (kg)</th>
                    <th>Puerto</th>
                    <th>Línea</th>
                    <th>Turno</th>
                    <th>Operador</th>
                    <th>Usuario Registra</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trazabilidad as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->codigo_paca ?? '-' }}</td>
                    <td>{{ $item->lote_proceso ?? '-' }}</td>
                    <td>
                        @switch($item->tipo_evento)
                            @case('ingreso')
                                <span class="badge badge-ingreso">Ingreso</span>
                                @break
                            @case('proceso')
                                <span class="badge badge-proceso">Proceso</span>
                                @break
                            @case('produccion')
                                <span class="badge badge-produccion">Producción</span>
                                @break
                            @case('despacho')
                                <span class="badge badge-despacho">Despacho</span>
                                @break
                        @endswitch
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->fecha_evento)->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->proveedor ?? '-' }}</td>
                    <td>{{ $item->cliente ?? '-' }}</td>
                    <td>{{ $item->tipo_material ?? '-' }}</td>
                    <td>{{ $item->tipo_producto ?? '-' }}</td>
                    <td>{{ number_format($item->peso, 2) }} kg</td>
                    <td>{{ $item->puerto ?? '-' }}</td>
                    <td>{{ $item->linea ?? '-' }}</td>
                    <td>{{ $item->turno ?? '-' }}</td>
                    <td>{{ $item->operador ?? '-' }}</td>
                    <td>{{ $item->usuario_registra ?? '-' }}</td>
                    <td>{{ $item->observaciones ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="16" style="text-align:center">No hay registros de trazabilidad</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="paginacion">
        {{ $trazabilidad->appends(request()->query())->links() }}
    </div>

    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn-volver">← Volver al Dashboard</a>
    </div>
</div>

<!-- Modal para exportar -->
<div id="modalExportar" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000;">
    <div style="background:white; border-radius:20px; padding:25px; width:350px;">
        <h3>Exportar trazabilidad</h3>
        <form action="{{ route('admin.trazabilidad.exportar') }}" method="GET">
            <div class="form-group">
                <label>Año</label>
                <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
            </div>
            <div class="form-group">
                <label>Mes</label>
                <select name="month" class="form-control" required>
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div style="display:flex; gap:10px; margin-top:15px;">
                <button type="submit" class="btn-filtrar">Exportar CSV</button>
                <button type="button" class="btn-limpiar" onclick="document.getElementById('modalExportar').style.display='none'">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        let modal = document.getElementById('modalExportar');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>