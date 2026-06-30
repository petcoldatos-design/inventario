<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Catálogo de Proveedores</h4>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#proveedorModal" onclick="resetForm()">
                + Nuevo Proveedor
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-dark"
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $p)
                    <tr>
                        <td>{{ $p->codigo_proveedor }}</td>
                        <td>{{ $p->proveedor }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editarProveedor({{ $p->id }}, '{{ $p->codigo_proveedor }}', '{{ addslashes($p->proveedor) }}')">
                                Editar
                            </button>
                            <form action="{{ route('admin.proveedores.destroy', $p->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este proveedor?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="proveedorModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabel">Nuevo Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formProveedor" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="id" id="proveedorId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Código de Proveedor</label>
                        <input type="text" name="codigo_proveedor" id="codigo" class="form-control" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label>Nombre del Proveedor</label>
                        <input type="text" name="proveedor" id="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function resetForm() {
        document.getElementById('formProveedor').action = "{{ route('admin.proveedores.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('proveedorId').value = '';
        document.getElementById('codigo').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('modalLabel').innerText = 'Nuevo Proveedor';
    }

    function editarProveedor(id, codigo, nombre) {
        document.getElementById('formProveedor').action = "/admin/proveedores/" + id;
        document.getElementById('methodField').value = 'PUT';
        document.getElementById('proveedorId').value = id;
        document.getElementById('codigo').value = codigo;
        document.getElementById('nombre').value = nombre;
        document.getElementById('modalLabel').innerText = 'Editar Proveedor';
        var modal = new bootstrap.Modal(document.getElementById('proveedorModal'));
        modal.show();
    }
</script>
</body>
</html>