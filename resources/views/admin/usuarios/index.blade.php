<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | PlastyPetco</title>
    <link rel="icon" href="{{ asset('images/plas.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #0e7a2c;
            --primary-dark: #0a5c20;
            --primary-light: #e8f5e9;
            --danger: #c62828;
            --warning: #f9a825;
            --info: #0d47a1;
            --gray: #6c757d;
            --white: #ffffff;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            --radius: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: url("../images/fon2.png") center/cover fixed no-repeat;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .container {
            width: 100%;
            max-width: 1300px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-top: 6px solid var(--primary);
            transition: all 0.3s ease;
        }

        /* ===== HEADER ===== */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(14, 122, 44, 0.15);
        }

        .card-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .card-header h2 i {
            color: var(--primary);
            font-size: 2rem;
        }

        .btn-nuevo {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(14, 122, 44, 0.25);
        }

        .btn-nuevo:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(14, 122, 44, 0.35);
        }

        /* ===== ALERTAS ===== */
        .alert {
            padding: 14px 20px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #1e5a2a;
            border-left: 5px solid #4caf50;
        }

        .alert-danger {
            background: #ffebee;
            color: #b71c1c;
            border-left: 5px solid #e53935;
        }
        .table-responsive {
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
            min-width: 800px;
        }

        thead {
            background: var(--primary-dark);
            color: white;
        }

        th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        td {
            padding: 13px 16px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            vertical-align: middle;
            color: #ffffff;
        }

        tbody tr {
            transition: background 0.15s ease;
        }

        tbody tr:nth-child(even) {
            background: rgba(14, 122, 44, 0.03);
        }

        tbody tr:hover {
            background: rgba(14, 122, 44, 0.07);
        }

        /* ===== BADGES DE ESTADO ===== */
        .badge {
            padding: 5px 14px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
        }

        .badge-success {
            background: #4caf50;
            color: white;
        }

        .badge-secondary {
            background: #b0bec5;
            color: #37474f;
        }
        .btn-accion {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.8rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            background: transparent;
        }

        .btn-accion i {
            font-size: 0.9rem;
        }

        .btn-editar {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .btn-editar:hover {
            background: #c8e6c9;
            transform: translateY(-1px);
        }

        .btn-eliminar {
            background: #ffebee;
            color: #c62828;
        }

        .btn-eliminar:hover {
            background: #ffcdd2;
            transform: translateY(-1px);
        }

        .btn-desactivar {
            background: #e3f2fd;
            color: #0d47a1;
        }

        .btn-desactivar:hover {
            background: #bbdefb;
            transform: translateY(-1px);
        }

        .btn-accion + .btn-accion {
            margin-left: 4px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 30px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
            border: 1px solid transparent;
        }

        .pagination a:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .pagination .active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination .disabled span {
            color: #aaa;
            pointer-events: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }
            .card-header h2 {
                justify-content: center;
            }
            .btn-nuevo {
                justify-content: center;
            }
            body {
                padding: 20px 10px;
            }
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card-header">
            <h2><i class="fas fa-users-cog"></i> Usuarios del Sistema</h2>
            <a href="{{ route('admin.usuarios.create') }}" class="btn-nuevo">
                <i class="fas fa-plus-circle"></i> Nuevo Usuario
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td><strong>{{ $u->usuario }}</strong></td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td><span class="badge" style="background: {{ $u->rol == 'admin' ? '#c62828' : ($u->rol == 'inventario' ? '#2e7d32' : '#0d47a1') }}; color:white;">
                            {{ ucfirst($u->rol) }}
                        </span></td>
                        <td>{{ $u->telefono ?? '—' }}</td>
                        <td>
                            @if($u->activo)
                                <span class="badge badge-success"><i class="fas fa-circle" style="font-size: 0.5rem; margin-right: 6px;"></i> Activo</span>
                            @else
                                <span class="badge badge-secondary"><i class="fas fa-circle" style="font-size: 0.5rem; margin-right: 6px;"></i> Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.usuarios.edit', $u->id) }}" class="btn-accion btn-editar">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            @if($u->id != auth()->id())
                                <form action="{{ route('admin.usuarios.destroy', $u->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-accion btn-eliminar" onclick="return confirm('¿Eliminar este usuario?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.usuarios.toggle.activo', $u->id) }}" class="btn-accion btn-desactivar">
                                <i class="fas {{ $u->activo ? 'fa-pause' : 'fa-play' }}"></i>
                                {{ $u->activo ? 'Desactivar' : 'Activar' }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $usuarios->links() }}
        </div>
    </div>
</body>
</html>