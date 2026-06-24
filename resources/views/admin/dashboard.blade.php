<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel Administrativo | Plasty Petco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/admin-dashboard.css') }}" rel="stylesheet">
</head>
<body>

<div class="wrapper">
    <!-- SIDEBAR IZQUIERDO -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <span><img src="{{ asset('images/plas.jpg') }}" alt="Logo" style="height: 50px;"> PlastyPetco</span>
        </div>
        <ul class="nav flex-column">
            <!-- Acciones principales -->
            @if(in_array(auth()->user()->rol, ['admin','inventario']))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inventario.create') }}">
                        <i class="fas fa-boxes"></i> Registrar Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('procesos.iniciar') }}">
                        <i class="fas fa-cogs"></i> Iniciar Proceso
                    </a>
                </li>
            @endif
            @if(in_array(auth()->user()->rol, ['admin','produccion']))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('produccion.registrar') }}">
                        <i class="fas fa-industry"></i> Producción
                    </a>
                </li>
            @endif
            @if(in_array(auth()->user()->rol, ['admin','inventario']))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('despachos.registrar') }}">
                        <i class="fas fa-truck"></i> Despacho
                    </a>
                </li>
            @endif
            <!-- Trazabilidad -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.trazabilidad.index') }}">
                    <i class="fas fa-chart-line"></i> Trazabilidad
                </a>
            </li>
            <!-- Proveedores -->
            @if(in_array(auth()->user()->rol, ['admin','inventario']))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.proveedores.index') }}">
                        <i class="fas fa-building"></i> Proveedores
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content">
        <!-- NAVBAR SUPERIOR -->
        <div class="navbar-top">
            <div class="navbar-brand">
                <span>Panel Administrativo</span>
            </div>
            <div class="navbar-links">
                @if(auth()->user()->rol == 'admin')
                    <a href="{{ route('admin.usuarios.index') }}" class="nav-link-top">
                        <i class="fas fa-users"></i> Gestión de Usuarios
                    </a>
                @endif
                <a href="{{ route('profile.autoedit') }}" class="nav-link-top">
                    <i class="fas fa-user-edit"></i> Mi Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link-top btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </button>
                </form>
            </div>
        </div>

        <!-- CONTENIDO DEL DASHBOARD (estadísticas, menús, tabla) -->
        <div class="container-dash">
            <h1 class="display-5 text-white text-center mb-4"></h1>
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

            <!-- Menú rápido de gestión (acceso a listados) -->
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
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

    document.getElementById('sidebarCollapse').addEventListener('click', function() {
   document.querySelector('.sidebar').classList.toggle('active');
   document.querySelector('.main-content').classList.toggle('active');});
</script>
</body>
</html>