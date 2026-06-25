<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producción | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <style>
        body {
            background: url("../images/fon2.png") center/cover fixed no-repeat;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }
        .container-lista {
            width: 90%;
            background: rgba(0, 0, 0, 0);
            border-radius: 40px;
            box-shadow: #000000 0px 0px 20px 0px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(2, 86, 10, 0.92);
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #1B5E20;
            background: rgba(255, 255, 255, 0.7);
            padding: 10px;
            border-radius: 12px;
        }
        p{
            text-align: center;
            color: #1B5E20;
            background: rgb(255, 255, 255);
            padding: 10px;
            border-radius: 12px;
            width: 12%;
            margin: 20px auto; 
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
    <h2>🏭 Producción</h2>
    

    <div class="filtro">
        <input type="text" id="buscar" placeholder="🔍 Buscar " onkeyup="filtrarTabla()">
    </div>

    <div style="overflow-x: auto;">
        <table id="tablaProduccion">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lote</th>
                    <th>Fecha Producción</th>
                    <th>Hora</th>
                    <th>Línea</th>
                    <th>Producto</th>
                    <th>Presentación</th>
                    <th>Turno</th>
                    <th>Peso (kg)</th>
                    <th>Operador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($producciones as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->lote }}</td>
                    <td>{{ $item->fecha_produccion }}</td>
                    <td>{{ $item->hora }}</td>
                    <td>{{ $item->linea }}?</td>
                    <td>{{ $item->tipo_producto }}?</td>
                    <td>{{ $item->presentacion }}?</td>
                    <td>{{ $item->turno }}?</td>
                    <td>{{ number_format($item->peso, 2) }} kg?</td>
                    <td>{{ $item->operador }}?</td>
                    <td>
                        @if(auth()->user()->rol == 'admin')
                            <a href="{{ route('produccion.edit', $item->id) }}" class="btn-accion btn-editar">Editar</a>
                            <form action="{{ route('produccion.destroy', $item->id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-accion btn-eliminar" onclick="return confirm('¿Eliminar esta producción?')">Eliminar</button>
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
        <p>Total de registros: {{ $producciones->count() }}</p>
        <a href="{{ route('admin.dashboard') }}" class="btn-volver">← Volver al Dashboard</a>
        @if(auth()->user()->rol == 'produccion')
            <a href="{{ route('produccion.dashboard') }}" class="btn-volver">← Panel Producción</a>
        @endif
    </div>
</div>

<script>
    function filtrarTabla() {
        let input = document.getElementById('buscar');
        let filter = input.value.toLowerCase();
        let table = document.getElementById('tablaProduccion');
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