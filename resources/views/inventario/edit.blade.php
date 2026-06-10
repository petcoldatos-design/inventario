<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Inventario | PlastyPetco</title>
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
    <h2>Editar Inventario</h2>
    <form method="POST" action="{{ route('inventario.update', $inventario->id) }}">
        @csrf
        @method('PUT')

        <div class="grid-2">
            <div>
                <label>Fecha</label>
                <input type="date" name="fecha" value="{{ old('fecha', $inventario->fecha) }}" required>
            </div>
            <div>
                <label>Hora</label>
                <input type="time" name="hora" value="{{ old('hora', $inventario->hora) }}" required>
            </div>
        </div>

        <label>Código Proveedor</label>
        <input type="text" name="codigo_proveedor" value="{{ old('codigo_proveedor', $inventario->codigo_proveedor) }}" required>

        <label>Proveedor</label>
        <input type="text" name="proveedor" value="{{ old('proveedor', $inventario->proveedor) }}" required>

        <label>Placa</label>
        <input type="text" name="placa" value="{{ old('placa', $inventario->placa) }}">

        <label>Ciudad / Municipio</label>
        <input type="text" name="procedencia" value="{{ old('procedencia', $inventario->procedencia) }}">

        <div class="grid-2">
            <div>
                <label>Tipo Material</label>
                <input type="text" name="tipo_material" value="{{ old('tipo_material', $inventario->tipo_material) }}" required>
            </div>
            <div>
                <label>Tipo Resina</label>
                <input type="text" name="tipo_resina" value="{{ old('tipo_resina', $inventario->tipo_resina) }}">
            </div>
        </div>

        <div class="grid-2">
            <div>
                <label>Color</label>
                <input type="text" name="color" value="{{ old('color', $inventario->color) }}" required>
            </div>
            <div>
                <label>Presentación</label>
                <input type="text" name="presentacion" value="{{ old('presentacion', $inventario->presentacion) }}">
            </div>
        </div>

        <div class="grid-2">
            <div>
                <label>Procedencia Tipo</label>
                <input type="text" name="procedencia_tipo" value="{{ old('procedencia_tipo', $inventario->procedencia_tipo) }}">
            </div>
            <div>
                <label>Tipo Producto</label>
                <input type="text" name="tipo_producto" value="{{ old('tipo_producto', $inventario->tipo_producto) }}">
            </div>
        </div>

        <div class="grid-2">
            <div>
                <label>Tipo Residuo</label>
                <input type="text" name="tipo_residuo" value="{{ old('tipo_residuo', $inventario->tipo_residuo) }}">
            </div>
            <div>
                <label>Historial</label>
                <input type="text" name="historial" value="{{ old('historial', $inventario->historial) }}">
            </div>
        </div>

        <div class="grid-2">
            <div>
                <label>Peso (kg)</label>
                <input type="number" step="0.01" name="peso" value="{{ old('peso', $inventario->peso) }}" required>
            </div>
            <div>
                <label>Remisión</label>
                <input type="text" name="remision" value="{{ old('remision', $inventario->remision) }}">
            </div>
        </div>

        <label>Código de Paca (no editable)</label>
        <input type="text" value="{{ $inventario->codigo_paca }}" disabled>

        <button type="submit" class="btn-update">💾 Guardar cambios</button>
        <a href="{{ route('inventario.lista') }}" class="btn-cancel">← Cancelar</a>
    </form>
</div>
</body>
</html>