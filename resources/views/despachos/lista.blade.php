<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Despachos | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .container-lista {
            max-width: 1400px;
            margin: 30px auto;
            background: rgba(255,255,255,0.95);
            border-radius: 28px;
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #1B5E20;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover td {
            background: #f5f5f5;
        }
        .btn-accion {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin: 0 3px;
        }
        .btn-editar {
            background: #2E7D32;
            color: white;
        }
        .btn-eliminar {
            background: #C62828;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-volver {
            display: inline-block;
            margin-top: 20px;
            background: #0d47a1;
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
        }
        .filtro {
            text-align: right;
            margin-bottom: 20px;
        }
        .filtro input {
            padding: 8px;
            width: 250px;
            border-radius: 20px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div class="container-lista">
    <h2>🚚 Listado de Despachos</h2>
    <p>Total de registros: {{ $despachos->count() }}</p>

    <div class="filtro">
        <input type="text" id="buscar" placeholder="🔍 Buscar por cliente, lote, remisión..." onkeyup="filtrarTabla()">
    </div>

    <div style="overflow-x: auto;">
        <table id="tablaDespachos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Remisión</th>
                    <th>Producto</th>
                    <th>Presentación</th>
                    <th>Cantidad (kg)</th>
                    <th>Lote</th>
                    <th>Despachado por</th>
                    <th>Conductor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($despachos as $item)
                <tr>
                    <td>{{ $item->id_despacho ?? $item->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $item->cliente }}</td>
                    <td>{{ $item->remision ?? '—' }}</td>
                    <td>{{ $item->producto }}</td>
                    <td>{{ $item->presentacion }}</td>
                    <td>{{ number_format($item->cantidad_kg, 2) }} kg</td>
                    <td>{{ $item->lote }}</td>
                    <td>{{ $item->despachado_por }}</td>
                    <td>{{ $item->conductor ?? '—' }}</td>
                    <td>
                        @if(auth()->user()->rol == 'admin')
                            <a href="{{ route('despachos.edit', $item->id_despacho ?? $item->id) }}" class="btn-accion btn-editar">Editar</a>
                            <form action="{{ route('despachos.destroy', $item->id_despacho ?? $item->id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-accion btn-eliminar" onclick="return confirm('¿Eliminar este despacho?')">Eliminar</button>
                            </form>
                        @else
                            <span class="btn-accion" style="background:#ccc;">Solo lectura</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        @if(auth()->user()->rol == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn-volver">← Volver al Dashboard</a>
        @elseif(auth()->user()->rol == 'inventario')
            <a href="{{ route('inventario.dashboard') }}" class="btn-volver">← Panel Inventario</a>
        @endif
    </div>
</div>

<script>
    function filtrarTabla() {
        let input = document.getElementById('buscar');
        let filter = input.value.toLowerCase();
        let table = document.getElementById('tablaDespachos');
        let rows = table.getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName('td');
            let found = false;
            for (let j = 0; j < cells.length - 1; j++) {
                if (cells[j] && cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
            rows[i].style.display = found ? '' : 'none';
        }
    }
</script>
</body>
</html>