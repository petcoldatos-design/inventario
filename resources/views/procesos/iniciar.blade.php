<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Proceso | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <!-- CSS global (debe contener todos los estilos comunes y específicos) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <div class="header">
        <h2>🚀 Iniciar Proceso Productivo</h2>
    </div>
    <div class="content">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        @if($mensaje)
            <div class="alert alert-error">{{ $mensaje }}</div>
        @endif

        @if(empty($codigo))
            <div class="search-box">
                <form method="GET" action="{{ route('procesos.iniciar') }}">
                    <div class="form-group">
                        <label>🔍 Ingrese Código de Paca</label>
                        <input type="text" name="codigo" placeholder="Ej: PROV-20250525-1" required autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
             
            @if(auth()->user()->rol == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">🏠 Dashboard Admin</a>
                @endif

        @elseif($resultado)
            <div class="card-info">
                <div class="info-row">
                    <div class="info-label">📦 Código Paca:</div>
                    <div class="info-value"><strong>{{ $resultado['codigo_paca'] }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">🏢 Proveedor:</div>
                    <div class="info-value">{{ $resultado['proveedor'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">📅 Fecha:</div>
                    <div class="info-value">{{ $resultado['fecha'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">⚖️ Peso disponible (kg):</div>
                    <div class="info-value"><strong>{{ number_format($resultado['peso'], 2) }}</strong> kg</div>
                </div>
                <div class="info-row">
                    <div class="info-label">🧱 Tipo material:</div>
                    <div class="info-value">{{ $resultado['tipo_material'] ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">📦 Tipo producto:</div>
                    <div class="info-value">{{ $resultado['tipo_producto'] ?? '—' }}</div>
                </div>
            </div>

            @if($resultado['peso'] > 0)
                <form method="POST" action="{{ route('procesos.iniciar.guardar') }}">
                    @csrf
                    <input type="hidden" name="codigo" value="{{ $codigo }}">

                    <div class="form-group">
                        <label>🔌 Línea (Puerto)</label>
                        <select name="puerto" required>
                            <option value="">-- Seleccione --</option>
                            <option value="1">Puerto 1 (Línea 1)</option>
                            <option value="2">Puerto 2 (Línea 2)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>⚖️ Cantidad a procesar (kg)</label>
                        <input type="number" step="0.01" name="cantidad" value="{{ $resultado['peso'] }}" required>
                        <small>Máximo disponible: {{ number_format($resultado['peso'], 2) }} kg</small>
                    </div>

                    <button type="submit" class="btn btn-success">🚀 Iniciar proceso</button>
                </form>
            @else
                <div class="alert alert-error">⚠️ Este lote ya no tiene peso disponible en inventario.</div>
            @endif
        @elseif(!empty($codigo) && !$resultado)
            <div class="alert alert-error">❌ Código no encontrado: <strong>{{ $codigo }}</strong></div>
        @endif

        @if(!empty($codigo))
            <div class="button-group">
                <a href="{{ route('procesos.iniciar') }}" class="btn btn-secondary">🔍 Nueva Búsqueda</a>
            </div>
        @endif
    </div>

    <!-- Botones de navegación inferiores -->
    @if(!empty($codigo))
        <div class="button-group bottom-buttons">
            @if(auth()->user()->rol == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">🏠 Volver al Dashboard Admin</a>
            @elseif(auth()->user()->rol == 'procesos')
                <form method="POST" action="{{ route('logout') }}" style="display: inline; width: 100%;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="width: 100%;">🚪 Cerrar sesión y volver al login</button>
                </form>
            @endif
        </div>
    @endif
</div>
</body>
</html>