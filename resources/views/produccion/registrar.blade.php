<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producción | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/produccion-registrar.css') }}">
</head>
<body>
<div class="container">
    <div class="form-box">
        <h2>Registro de Producción</h2>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('produccion.guardar') }}">
            @csrf

            <label>Fecha y hora</label>
            <input type="datetime-local" name="fecha_hora" value="{{ old('fecha_hora', date('Y-m-d\TH:i')) }}" required>

            <label>Línea</label>
            <select name="linea" required>
                <option value="">Seleccione</option>
                <option value="Línea de lavado 1" {{ old('linea') == 'Línea de lavado 1' ? 'selected' : '' }}>Línea 1</option>
                <option value="Línea de lavado 2" {{ old('linea') == 'Línea de lavado 2' ? 'selected' : '' }}>Línea 2</option>
            </select>

            <label>Producto</label>
            <select name="producto" required>
                <option value="">Seleccione</option>
                <option>Hojuela de PET Transparente tipo A</option>
                <option>Hojuela de PET Transparente Beneficiado</option>
                <option>Hojuela de PET Verde</option>
                <option>Hojuela de PET Ámbar</option>
                <option>Hojuela de PET Aceite</option>
            </select>

            <label>Presentación</label>
            <input type="text" name="presentacion" value="{{ old('presentacion') }}" required>

            <div class="grid-2">
                <div>
                    <label>Turno</label>
                    <select name="turno" required>
                        <option value="">Seleccione</option>
                        <option value="1" {{ old('turno') == '1' ? 'selected' : '' }}>Día</option>
                        <option value="2" {{ old('turno') == '2' ? 'selected' : '' }}>Noche</option>
                    </select>
                </div>
                <div>
                    <label>Número / Globo</label>
                    <input type="text" name="numero_globo" value="{{ old('numero_globo') }}">
                </div>
            </div>

            <div class="grid-2">
                <div>
                    <label>Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" value="{{ old('peso') }}" required>
                </div>
                <div>
                    <label>Lote (automático)</label>
                    <input type="text" id="lote_preview" readonly font-weight:bold;">
                </div>
            </div>

            <label>Observaciones</label>
            <textarea name="observaciones">{{ old('observaciones') }}</textarea>

            <label>Operador</label>
            <input type="text" name="operador" value="{{ old('operador') }}" required>

            <button class="btn-guardar">Guardar Registro</button>

  
        </form>

            <div style="margin-top: 20px;">
            @if(auth()->user()->rol == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn-volver">Volver al inicio</a>
            @elseif(auth()->user()->rol == 'produccion')
                <a href="{{ route('logout') }}" class="btn-volver">Cerrar sesión</a>
            @endif
            </div>
    </div>
    </div>
</div>

<script>
    // Previsualización del lote en tiempo real (opcional)
    const fechaInput = document.querySelector('input[name="fecha_hora"]');
    const lineaSelect = document.querySelector('select[name="linea"]');
    const turnoSelect = document.querySelector('select[name="turno"]');
    const lotePreview = document.getElementById('lote_preview');

    function actualizarPreviewLote() {
        if (!fechaInput.value || !lineaSelect.value || !turnoSelect.value) {
            lotePreview.value = '';
            return;
        }
        const letra = lineaSelect.value === 'Línea de lavado 1' ? 'A' : 'B';
        const fecha = new Date(fechaInput.value);
        if (isNaN(fecha.getTime())) return;
        const yy = String(fecha.getFullYear()).slice(-2);
        const mm = String(fecha.getMonth() + 1).padStart(2, '0');
        const dd = String(fecha.getDate()).padStart(2, '0');
        const base = letra + yy + mm + dd + turnoSelect.value;
        lotePreview.value = base; // el consecutivo lo asigna el backend
    }

    fechaInput.addEventListener('change', actualizarPreviewLote);
    lineaSelect.addEventListener('change', actualizarPreviewLote);
    turnoSelect.addEventListener('change', actualizarPreviewLote);
</script>
</body>
</html>