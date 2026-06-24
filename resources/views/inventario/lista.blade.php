<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Inventario | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/lista-inventario.css') }}">
    <style>
        body {
            background: url("../images/fon2.png") center/cover fixed no-repeat;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            max-width: 650px;
            width: 100%;
            background: rgba(0, 0, 0, 0);
            border-radius: var(--border-radius-card);
            box-shadow: #000000 0px 0px 20px 0px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(2, 86, 10, 0.92);
        }
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        h2 {
            text-align: center;
            color: #1B5E20;
            background: rgba(255, 255, 255, 0.8);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 16px;
            overflow: hidden;
        }
        th {
            background: #1B5E20;
            color: white;
            padding: 12px;
            white-space: nowrap;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            white-space: nowrap;
        }
        tr:hover td {
            background: #f5f5f5;
        }
        .btn-accion {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            margin: 0 4px;
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
            margin-bottom: 20px;
            text-align: right;
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
<div class="container" style="max-width: 1400px; margin: 30px auto; border-radius: 28px; padding: 30px;">
    <h2>📦 Listado de Inventario</h2>


    <div class="filtro">
        <input type="text" id="buscar" placeholder="🔍 Buscar" onkeyup="filtrarTabla()">
    </div>

    <div class="table-container">
        <table id="tablaInventario">
            <thead>
                <tr>
                    <th>ID</th><th>Código Paca</th><th>Fecha</th><th>Hora</th><th>Proveedor</th>
                    <th>Material</th><th>Color</th><th>Presentación</th><th>Peso (kg)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventarios as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->codigo_paca }}</td>
                    <td>{{ $item->fecha }}</td>
                    <td>{{ $item->hora }}</td>
                    <td>{{ $item->proveedor }}</td>
                    <td>{{ $item->tipo_material }}</td>
                    <td>{{ $item->color }}</td>
                    <td>{{ $item->presentacion }}</td>
                    <td>{{ number_format($item->peso, 2) }}</td>
                    <td>
                        @if(auth()->user()->rol == 'admin')
                            <a href="{{ route('inventario.edit', $item->id) }}" class="btn-accion btn-editar">Editar</a>
                            <form action="{{ route('inventario.destroy', $item->id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-accion btn-eliminar" onclick="return confirm('¿Eliminar este registro?')">Eliminar</button>
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
    <p>Total de registros: {{ $inventarios->count() }}</p>
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
        let table = document.getElementById('tablaInventario');
        let rows = table.getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName('td');
            let found = false;
            for (let j = 0; j < cells.length - 1; j++) { // -1 para excluir columna acciones
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