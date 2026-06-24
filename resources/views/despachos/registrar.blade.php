<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Despacho Producto Terminado | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}" stylesheet:>
    <link rel="stylesheet" href="{{ asset('css/despachos-registrar.css') }}">
</head>
<body>
<div class="form-box">
    <h1><img src="{{ asset('images/plas.jpg') }}" alt="Logo" style="height: 40px;"> PlastyPetco</h1>
    <h2>Despacho Producto Terminado</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="buscar-form">
        <form method="GET" action="{{ route('despachos.registrar') }}">
            <input type="text" name="buscar" class="buscar-input" placeholder="Buscar Lote" value="{{ old('buscar', $buscar) }}" required>
            <button class="btn-buscar">Buscar</button>
        </form>
    </div>

    @if(!empty($mensaje))
        <div style="color:red; text-align:center; margin-bottom:10px;">{{ $mensaje }}</div>
    @endif

    <form method="POST" action="{{ route('despachos.guardar') }}">
        @csrf
        <input type="hidden" name="origen" value="{{ $origen ?? '' }}">

        <label>Fecha</label>
        <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>

        <label>Cliente</label>
        <input type="text" name="cliente" value="{{ old('cliente', auth()->user()->usuario) }}" required>

        <label>Remisión</label>
        <input type="text" name="remision" value="{{ old('remision') }}">

        <label>Producto</label>
        <input type="text" name="producto" readonly value="{{ $producto }}">

        <label>Presentación</label>
        <input type="text" name="presentacion" readonly value="{{ $presentacion }}">

        <div class="grid-2">
            <div>
                <label>Cantidad (KG)</label>
                <input type="number" step="0.01" name="cantidad" value="{{ old('cantidad') }}" required>
            </div>
            <div>
                <label>Lote</label>
                <input type="text" name="lote" readonly value="{{ $lote }}">
            </div>
        </div>

        <label>Despachado por</label>
        <input type="text" name="despachado_por" value="{{ old('despachado_por', auth()->user()->usuario) }}">

        <label>Conductor</label>
        <input type="text" name="conductor" value=x"{{ old('conductor') }}">

        <label>Observaciones</label>
        <textarea name="observaciones">{{ old('observaciones') }}</textarea>

        <button class="btn-guardar" type="submit">Guardar Despacho</button>

        @if (auth()->user()->rol == 'inventario')
        <button class="btn-volver" type="button" onclick="location.href='{{ route('inventario.dashboard') }}'">Volver</button>
        @endif

        @if(auth()->user()->rol == 'admin')
            <button type="button" class="btn-volver" onclick="location.href='{{ route('admin.dashboard') }}'">Volver al inicio</button>
        @endif
    </form>
</div>
</body>
</html>