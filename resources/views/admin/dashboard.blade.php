<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Administrativo | Plasty Petco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/admin-dashboard.css') }}" rel="stylesheet">
</head>
<body>

<div class="navbar">
    <div class="nav-brand">
        <span>♻️ PlastyPetco</span>
    </div>
    <div class="nav-links">
        <a href="{{ route('profile.autoedit') }}">Mi Perfil</a>
        @if(auth()->user()->rol == 'admin')
        <a href="{{ route('profile.index') }}">Gestión de Usuarios</a>
        @endif
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Inicio</a>
        @if(in_array(auth()->user()->rol, ['admin','inventario']))
            <a href="{{ route('inventario.create') }}"><i class="fas fa-boxes"></i> Registrar Inventario</a>
            <a href="{{ route('procesos.iniciar') }}"><i class="fas fa-cogs"></i> Iniciar Proceso</a>
        @endif
        @if(in_array(auth()->user()->rol, ['admin','produccion']))
            <a href="{{ route('produccion.registrar') }}"><i class="fas fa-industry"></i> Producción</a>
        @endif
        @if(in_array(auth()->user()->rol, ['admin','inventario']))
            <a href="{{ route('despachos.registrar') }}"><i class="fas fa-truck"></i> Despacho</a>
            <a href="{{ route('admin.proveedores.index') }}"><i class="fas fa-building"></i> Proveedores</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit"><i class="fas fa-sign-out-alt"></i> Salir</button>
        </form>
    </div>
</div>

<div class="container-dash">
    <h1 class="display-5 text-white text-center mb-4">Panel Administrativo</h1>
    <p class="text-center text-white mb-5">Bienvenido, <strong>{{ Auth::user()->usuario }}</strong></p>

    <!-- Tarjetas de estadísticas -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card-stats">
                <div class="card-body">
                    <i class="fas fa-weight-hanging"></i>
                    <h3>{{ number_format($totalInventario, 0) }} kg</h3>
                    <p>Inventario actual</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-stats">
                <div class="card-body">
                    <i class="fas fa-cogs"></i>
                    <h3>{{ number_format($totalEnProceso, 0) }} kg</h3>
                    <p>Material en proceso</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-stats">
                <div class="card-body">
                    <i class="fas fa-industry"></i>
                    <h3>{{ number_format($produccionMes, 0) }} kg</h3>
                    <p>Producción este mes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-stats">
                <div class="card-body">
                    <i class="fas fa-truck"></i>
                    <h3>{{ number_format($despachosMes, 0) }} kg</h3>
                    <p>Despachos este mes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú rápido -->
    <div class="menu-grid">
        <a href="{{ route('inventario.lista') }}" class="menu-card">
            <i class="fas fa-boxes"></i>
            <h4>Gestionar Inventario</h4>
            <p>Ver, editar o eliminar registros</p>
        </a>
        <a href="{{ route('procesos.lista') }}" class="menu-card">
            <i class="fas fa-cogs"></i>
            <h4>Gestionar Procesos</h4>
            <p>Material en proceso</p>
        </a>
        <a href="{{ route('producciones.lista') }}" class="menu-card">
            <i class="fas fa-industry"></i>
            <h4>Gestionar Producción</h4>
            <p>Registros de producción</p>
        </a>
        <a href="{{ route('despachos.lista') }}" class="menu-card">
            <i class="fas fa-truck"></i>
            <h4>Gestionar Despachos</h4>
            <p>Salidas a clientes</p>
        </a>
        <a href="{{ route('admin.trazabilidad.index') }}" class="menu-card">
            <i class="fas fa-chart-line"></i>
            <h4>Trazabilidad NTC 6632</h4>
            <p>Historial completo y exportación</p>
        </a>
    </div>

    <!-- Últimos movimientos de trazabilidad -->
    <div class="mt-5">
        <h3 class="titulo-seccion">Últimos movimientos de trazabilidad</h3>
        <div class="table-movimientos">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>Fecha</th><th>Evento</th><th>Material</th><th>Peso (kg)</th><th>Responsable</th></tr>
                </thead>
                <tbody>
                    @forelse($ultimosMovimientos as $mov)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($mov->fecha_evento)->format('d/m/Y H:i') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($mov->tipo_evento) }}</span></td>
                        <td>{{ $mov->tipo_material ?? $mov->tipo_producto ?? '-' }}</td>
                        <td>{{ number_format($mov->peso, 2) }}</td>
                        <td>{{ $mov->usuario_registra }}</td>
                    </tr>
                    @empty
                        <tr><td colspan="5">Sin movimientos recientes</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>