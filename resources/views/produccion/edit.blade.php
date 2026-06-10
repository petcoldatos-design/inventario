<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producción | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .form-box {
            max-width: 560px;
            margin: 30px auto;
        }
        .btn-update {
            background: #0D47A1;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: none;
            margin-top: 10px;
        }
        .btn-cancel {
            background: #6c757d;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Editar Producción</h2>
    <form method="POST" action="{{ route('produccion.update', $produccion->id) }}">
        @csrf
        @method('PUT')

        <label>Peso (kg)</label>
        <input type="number" step="0.01" name="peso" value="{{ old('peso', $produccion->peso) }}" required>

        <label>Operador</label>
        <input type="text" name="operador" value="{{ old('operador', $produccion->operador) }}" required>

        <label>Observaciones</label>
        <textarea name="observaciones" rows="3">{{ old('observaciones', $produccion->observaciones) }}</textarea>

        <button type="submit" class="btn-update">💾 Guardar cambios</button>
        <a href="{{ route('produccion.lista') }}" class="btn-cancel">← Cancelar</a>
    </form>
</div>
</body>
</html>