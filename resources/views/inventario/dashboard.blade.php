<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url("{{ asset('images/fondo.jpg') }}") no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            width: 900px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0,0,0,.25);
        }
        h1 {
            text-align: center;
            color: #1B5E20;
            margin-bottom: 10px;
        }
        .bienvenida {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .card {
            background: #f5f5f5;
            border-radius: 14px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: .2s;
            box-shadow: 0 4px 10px rgba(0,0,0,.15);
        }
        .card:hover {
            background: #e0f2f1;
            transform: translateY(-3px);
        }
        .card h2 {
            margin: 0;
            color: #0D47A1;
        }
        .card p {
            margin-top: 8px;
            color: #333;
        }
        .logout {
            margin-top: 30px;
            text-align: center;
        }
        .logout a {
            text-decoration: none;
            background: #c62828;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: bold;
            display: inline-block;
        }
        @media (max-width: 700px) {
            .container { width: 95%; padding: 20px; }
            .menu { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Inventario / Despacho / Proveedores</h1>
    <p class="bienvenida">Bienvenido, <strong>{{ auth()->user()->usuario ?? auth()->user()->name }}</strong></p>

    <div class="menu">
        <div class="card" onclick="location.href='{{ ('/inventario/registrar') }}'">
            <h2>📦 Registrar Entrada</h2>
            <p>Nuevo material en inventario</p>
        </div>

        <div class="card" onclick="location.href='{{ route('inventario.lista') }}'">
            <h2>📋 Lista de Entrada</h2>
            <p>Consultar y gestionar materiales</p>
        </div>

        <div class="card" onclick="location.href='{{ route('despachos.registrar') }}'">
            <h2>🚚 Despachos</h2>
            <p>Registrar salidas de producto</p>
        </div>

        <div class="card" onclick="location.href='{{ route('admin.proveedores.index') }}'">
            <h2>🏭 Proveedores</h2>
            <p>Gestión de catálogo de proveedores</p>
        </div>

        <div class="card" onclick="location.href='{{ route('despachos.lista') }}'">
            <h2>📊 Lista de Despachos</h2>
            <p>Inventario / Proceso / Producción / Despachos</p>
        </div>
    </div>

    <div class="logout">
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:#c62828; color:white; border:none; padding:12px 20px; border-radius:10px; font-weight:bold; cursor:pointer;">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>
</body>
</html>