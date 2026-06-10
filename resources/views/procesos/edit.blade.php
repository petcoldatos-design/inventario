<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Proceso | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="form-box">
    <h2>Editar Proceso</h2>
    <form method="POST" action="{{ route('procesos.update', $proceso->id) }}">
        @csrf
        @method('PUT')

        <label>Peso (kg)</label>
        <input type="number" step="0.01" name="peso" value="{{ old('peso', $proceso->peso) }}" required>

        <label>Puerto</label>
        <select name="puerto" required>
            <option value="1" {{ $proceso->puerto == 1 ? 'selected' : '' }}>Puerto 1</option>
            <option value="2" {{ $proceso->puerto == 2 ? 'selected' : '' }}>Puerto 2</option>
        </select>

        <label>Fecha Inicio</label>
        <input type="datetime-local" name="fecha_inicio" value="{{ date('Y-m-d\TH:i', strtotime($proceso->fecha_inicio)) }}" required>

        <button type="submit" class="btn-update">Guardar cambios</button>
        <a href="{{ route('procesos.lista') }}" class="btn-cancel">Cancelar</a>
    </form>
</div>
</body>
</html>