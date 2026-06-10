<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Despacho Producto Terminado | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <style>
        body{
            background: url("{{ asset('images/fondo.jpg') }}") center/cover fixed no-repeat;
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        .form-box{
            background: #ffffffef;
            width: 540px;
            margin: auto;
            padding: 32px;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0,0,0,.18);
        }
        h2{
            text-align: center;
            color: #1B5E20;
            margin-bottom: 26px;
        }
        label{
            display: block;
            font-weight: bold;
            color: #1B5E20;
            margin-bottom: 6px;
        }
        input, textarea{
            width: 100%;
            height: 46px;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid #999;
            font-size: 15px;
            margin-bottom: 14px;
            box-sizing: border-box;
        }
        textarea{
            height: 90px;
            resize: none;
        }
        input[readonly]{
            background: #f1f8e9;
        }
        .grid-2{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        button{
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-guardar{
            background: #0D47A1;
            color: white;
        }
        .btn-volver{
            background: #1B5E20;
            color: white;
            margin-top: 10px;
        }
        .btn-buscar{
            background: #0D47A1;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
        }
        .buscar-form{
            text-align: center;
            margin-bottom: 20px;
        }
        .buscar-input{
            width: 200px;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #999;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="form-box">
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
        <input type="text" name="conductor" value="{{ old('conductor') }}">

        <label>Observaciones</label>
        <textarea name="observaciones">{{ old('observaciones') }}</textarea>

        <button class="btn-guardar" type="submit">Guardar Despacho</button>

        @if (auth()->user()->rol == 'inventario')
        <button class="btn-volver" type="button" onclick="location.href='{{ route('inventario.dashboard') }}'">Volver</button>
        @endif

        @if(auth()->user()->rol == 'admin')
            <button type="button" class="btn-volver" onclick="location.href='{{ route('admin.dashboard') }}'">Dashboard Admin</button>
        @endif
    </form>
</div>
</body>
</html>