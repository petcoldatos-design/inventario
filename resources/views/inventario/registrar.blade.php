<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Residuo | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link href="{{ asset('css/inventario-registrar.css') }}" rel="stylesheet">
</head>
<body>
    
<div class="form-box">
    <h1><img src="{{ asset('images/plas.jpg') }}" alt="Logo" style="height: 40px;"> PlastyPetco</h1>
    <h2>Registrar Nuevo Residuo</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('inventario.store') }}" id="formInventario">
        @csrf
        <div style="display: flex; gap: 20px;">
        <!-- Fecha -->
        <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
        </div>

        <!-- Hora -->
        <div class="form-group">
            <label>Hora</label>
            <input class="form-control" type="time" name="hora" id="hora" value="{{ old('hora') }}" required>
        </div>

        </div>
        <!-- Selector de proveedores -->
        <div class="form-group">
            <label>Proveedor</label>
            <select name="codigo_proveedor" id="select_proveedor" required>
                <option value="">Seleccione un proveedor</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->codigo_proveedor }}" {{ old('codigo_proveedor') == $prov->codigo_proveedor ? 'selected' : '' }}>
                        {{ $prov->codigo_proveedor }} - {{ $prov->proveedor }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nombre Proveedor -->
        <div class="form-group">
            <label>Nombre Del Proveedor</label>
            <input type="text" name="proveedor" id="proveedor" value="{{ old('proveedor') }}" required readonly>
        </div>

        <!-- Placa -->
        <div class="form-group">
            <label>Placa - Vehículo</label>
            <input name="placa" value="{{ old('placa') }}" required>
        </div>

        <!-- Ciudad / Municipio -->
        <div class="form-group">
            <label>Ciudad / Municipio</label>
            <input name="procedencia" value="{{ old('procedencia') }}" required>
        </div>

        <!-- Tipo Material (hamburguesa) -->
        <div class="form-group hamburger-select">
            <label>Tipo De Material</label>
            <input type="hidden" name="tipo_material" id="tipo_material" value="{{ old('tipo_material') }}" required>
            <div class="hamburger-btn">Seleccione</div>
            <div class="hamburger-options">
                <!-- Opciones -->
                <div data-value="ACEITE">Aceite</div>
                <div data-value="AMBAR">Ambar</div>
                <div data-value="BOLSA DE AZUCAR">Bolsa De Azucar</div>
                <div data-value="CARTÓN">Cartón</div>
                <div data-value="CRISTAL BENEFICIADO">Cristal Beneficiado</div>
                <div data-value="CRISTAL ETIQUETA">Cristal Etiqueta</div>
                <div data-value="CRISTAL POSINDUSTRIAL">Cristal Posindustrial</div>
                <div data-value="ESTIBAS">Estibas</div>
                <div data-value="GLOBOS">Globos</div>
                <div data-value="HIT">Hit</div>
                <div data-value="LAMINA DE FLORES">Lamina De Flores</div>
                <div data-value="LONAS">Lonas</div>
                <div data-value="MATERIAL DE COLORES">Material De Colores</div>
                <div data-value="PET ASEO">Pet Aseo</div>
                <div data-value="PET BLANCO">Pet Blanco</div>
                <div data-value="PET ETIQUETA PVC">Pet Etiqueta Pvc</div>
                <div data-value="PET MOLIDO AMBAR">Pet Molido Ambar</div>
                <div data-value="PET MOLIDO COLORES">Pet Molido Colores</div>
                <div data-value="PET MOLIDO NARANJA">Pet Molido Naranja</div>
                <div data-value="PET MOLIDO TRANSPARENTE">Pet Molido Transparente</div>
                <div data-value="PET MOLIDO VERDE">Pet Molido Verde</div>
                <div data-value="PET NARANJA MOLIDO">Pet Naranja Molido</div>
                <div data-value="PET ROSADO">Pet Rosado</div>
                <div data-value="PLASTICO POLICOLOR">Plastico Policolor</div>
                <div data-value="PLASTICO TRANSPARENTE">Plastico Transparente</div>
                <div data-value="POLIPROPILENO (FRITURA)">Polipropileno (Fritura)</div>
                <div data-value="POLVILLO">Polvillo</div>
                <div data-value="POLVILLO LIMPIO">Polvillo Limpio</div>
                <div data-value="POLVILLO SUCIO">Polvillo Sucio</div>
                <div data-value="PP LIMPIO">Pp Limpio</div>
                <div data-value="PREFORMA CRISTAL">Preforma Cristal</div>
                <div data-value="PREFORMA ROSADA">Preforma Rosada</div>
                <div data-value="PREFORMA VERDE">Preforma Verde</div>
                <div data-value="R PET AMBAR">R Pet Ambar</div>
                <div data-value="REVUELTO">Revuelto</div>
                <div data-value="SCREEN">Screen</div>
                <div data-value="SOPLADO">Soplado</div>
                <div data-value="SOPLADO MOLIDO BLANCO">Soplado Molido Blanco</div>
                <div data-value="TAPA PLASTICA">Tapa Plastica</div>
                <div data-value="TAPA PLÁSTICA">Tapa Plástica</div>
                <div data-value="TORTA">Torta</div>
                <div data-value="VERDE">Verde</div>
                <div data-value="VERDE-AMBAR">Verde-Ambar</div>
                <div data-value="ZUNCHO">Zuncho</div>
                <div data-value="ZUNCHO PLASTICO VERDE">Zuncho Plastico Verde</div>
            </div>
        </div>

        <!-- Tipo Resina -->
        <div class="form-group hamburger-select">
            <label>Tipo De Resina</label>
            <input type="hidden" name="tipo_resina" id="tipo_resina" value="{{ old('tipo_resina') }}" required>
            <div class="hamburger-btn">Seleccione</div>
            <div class="hamburger-options">
                <div data-value="PET">PET</div>
                <div data-value="HDPE">HDPE</div>
                <div data-value="LDPE">LDPE</div>
                <div data-value="PP">PP</div>
                <div data-value="Otro">Otro</div>
            </div>
        </div>

        <!-- Color -->
        <div class="form-group hamburger-select">
            <label>Color</label>
            <input type="hidden" name="color" id="color" value="{{ old('color') }}" required>
            <div class="hamburger-btn">Seleccione</div>
            <div class="hamburger-options">
                <div data-value="Transparente">Transparente</div>
                <div data-value="Verde">Verde</div>
                <div data-value="Ámbar">Ámbar</div>
                <div data-value="Azul">Azul</div>
                <div data-value="Policolor">Policolor</div>
            </div>
        </div>

        <!-- Presentación -->
        <div class="form-group hamburger-select">
            <label>Presentación</label>
            <input type="hidden" name="presentacion" id="presentacion" value="{{ old('presentacion') }}" required>
            <div class="hamburger-btn">Seleccione</div>
            <div class="hamburger-options">
                <div data-value="Compactado">Compactado</div>
                <div data-value="Suelto">Suelto</div>
                <div data-value="Globo">Globo</div>
                <div data-value="Otro">Otro</div>
            </div>
        </div>

        <!-- Procedencia Tipo -->
        <div class="form-group hamburger-select">
            <label>Procedencia</label>
            <input type="hidden" name="procedencia_tipo" id="procedencia_tipo" value="{{ old('procedencia_tipo') }}" required>
            <div class="hamburger-btn">Seleccione</div>
            <div class="hamburger-options">
                <div data-value="Posconsumo">Posconsumo</div>
                <div data-value="Preconsumo">Preconsumo</div>
                <div data-value="Industrial">Industrial</div>
            </div>
        </div>

        <!-- Tipo Producto -->
        <div class="form-group hamburger-select">
            <label>Tipo De Producto</label>
            <input type="hidden" name="tipo_producto" id="tipo_producto" value="{{ old('tipo_producto') }}" required>
            <div class="hamburger-btn">Seleccione</div>
            <div class="hamburger-options">
                <div data-value="Botellas">Botellas</div>
                <div data-value="Empaques Flexibles">Empaques Flexibles</div>
                <div data-value="Envases">Envases</div>
                <div data-value="Embalaje Alimentos">Embalaje Alimentos</div>
                <div data-value="Otros">Otros</div>
            </div>
        </div>

        <!-- Tipo Residuo -->
        <div class="form-group hamburger-select">
            <label>Tipo De Residuo</label>
            <input type="hidden" name="tipo_residuo" id="tipo_residuo" value="{{ old('tipo_residuo') }}" required>
            <div class="hamburger-btn">Seleccione</div>
            <div class="hamburger-options">
                <div data-value="Hogar">Hogar</div>
                <div data-value="Industria">Industria</div>
                <div data-value="Comercio">Comercio</div>
            </div>
        </div>

        <!-- Historial -->
        <div class="form-group hamburger-select">
            <label>Historial Del Residuo</label>
            <input type="hidden" name="historial" id="historial" value="{{ old('historial') }}" required>
            <div class="hamburger-btn">Seleccione</div>
            <div class="hamburger-options">
                <div data-value="Bebidas y refrescos">De Bebidas Y Refrescos</div>
                <div data-value="Empaque alimentos">Empaque De Alimentos</div>
                <div data-value="Empaque / Embalaje">Empaque De Productos De Aseo</div>
                <div data-value="Empacado / Embalaje">Empacado / Embalaje De Mercancias</div>
                <div data-value="Sustancias peligrosas">Sustancias Peligrosas</div>
                <div data-value="Otros">Otros</div>
            </div>
        </div>

        <!-- Peso -->
        <div class="form-group">
            <label>Peso (Kg)</label>
            <input type="number" step="0.01" name="peso" value="{{ old('peso') }}" required>
        </div>
<<<<<<
        <!-- Código de Paca (preview) -->
        <div class="form-group">
            <label>Código De Paca (Automático)</label>
            <input type="text" id="codigoPreview" readonly">
        </div>

        <div class="form-actions">
            <button class="btn-guardar">Guardar</button>
        </div>
    </form>



    <div style="margin-top: 20px;">
        @if(auth()->user()->rol == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn-volver">Volver al inicio</a>
        @elseif(auth()->user()->rol == 'inventario')
            <a href="{{ route('inventario.dashboard') }}" class="btn-volver">Volver</a>
        @endif
        </div>
    </div>

</div>

<script>
    const selectProveedor = document.getElementById('select_proveedor');
    const nombreProveedor = document.getElementById('proveedor');
    const fecha = document.getElementById('fecha');
    const codigoPreview = document.getElementById('codigoPreview');

    function actualizarNombreProveedor() {
        const selectedOption = selectProveedor.options[selectProveedor.selectedIndex];
        if (selectProveedor.value) {
            const textoCompleto = selectedOption.textContent;
            const partes = textoCompleto.split(' - ');
            nombreProveedor.value = partes[1] || '';
        } else {
            nombreProveedor.value = '';
        }
        generarCodigoPreview();
    }

    function generarCodigoPreview() {
        const codigo = selectProveedor.value;
        const fechaVal = fecha.value;
        if (codigo && fechaVal) {
            const fechaCod = fechaVal.replace(/-/g, "");
            codigoPreview.value = codigo + "-" + fechaCod + "-1";
        } else {
            codigoPreview.value = "";
        }
    }

    selectProveedor.addEventListener('change', actualizarNombreProveedor);
    fecha.addEventListener('change', generarCodigoPreview);
    actualizarNombreProveedor();
    generarCodigoPreview();

    document.querySelectorAll(".hamburger-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            const box = btn.nextElementSibling;
            document.querySelectorAll(".hamburger-options").forEach(o => {
                if (o !== box) o.style.display = "none";
            });
            box.style.display = box.style.display === "block" ? "none" : "block";
        });
    });

    document.querySelectorAll(".hamburger-options div").forEach(opt => {
        opt.addEventListener("click", (e) => {
            e.stopPropagation();
            const wrap = opt.closest(".hamburger-select");
            wrap.querySelector(".hamburger-btn").textContent = opt.textContent;
            wrap.querySelector("input").value = opt.dataset.value;
            wrap.querySelector(".hamburger-options").style.display = "none";
        });
    });

    document.addEventListener("click", () => {
        document.querySelectorAll(".hamburger-options").forEach(o => o.style.display = "none");
    });
</script>
</body>
</html>