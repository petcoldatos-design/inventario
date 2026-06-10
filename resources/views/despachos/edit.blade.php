<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Despacho | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .form-box { max-width: 560px; margin: 30px auto; }
        .btn-update { background: #0D47A1; color: white; width: 100%; padding: 12px; border-radius: 12px; border: none; margin-top: 10px; }
        .btn-cancel { background: #6c757d; color: white; width: 100%; padding: 12px; border-radius: 12px; text-align: center; display: inline-block; text-decoration: none; margin-top: 10px; }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Editar Despacho</h2>
    <form method="POST" action="{{ route('despachos.update', $despacho->id_despacho ?? $despacho->id) }}">
        @csrf
        @method('PUT')

        <label>Fecha</label>
        <input type="date" name="fecha" value="{{ old('fecha', $despacho->fecha) }}" required>

        <label>Cliente</label>
        <input type="text" name="cliente" value="{{ old('cliente', $despacho->cliente) }}" required>

        <label>Remisión</label>
        <input type="text" name="remision" value="{{ old('remision', $despacho->remision) }}">

        <label>Producto</label>
        <input type="text" name="producto" value="{{ old('producto', $despacho->producto) }}" required>

        <label>Presentación</label>
        <input type="text" name="presentacion" value="{{ old('presentacion', $despacho->presentacion) }}" required>

        <div class="grid-2">
            <div>
                <label>Cantidad (kg)</label>
                <input type="number" step="0.01" name="cantidad_kg" value="{{ old('cantidad_kg', $despacho->cantidad_kg) }}" required>
            </div>
            <div>
                <label>Lote</label>
                <input type="text" name="lote" value="{{ old('lote', $despacho->lote) }}" required>
            </div>
        </div>

        <label>Despachado por</label>
        <input type="text" name="despachado_por" value="{{ old('despachado_por', $despacho->despachado_por) }}" required>

        <label>Conductor</label>
        <input type="text" name="conductor" value="{{ old('conductor', $despacho->conductor) }}">

        <label>Observaciones</label>
        <textarea name="observaciones">{{ old('observaciones', $despacho->observaciones) }}</textarea>

        <button type="submit" class="btn-update">💾 Guardar cambios</button>
        <a href="{{ route('despachos.lista') }}" class="btn-cancel">← Cancelar</a>
    </form>
</div>
</body>
</html>