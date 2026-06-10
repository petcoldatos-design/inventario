@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">Nuevo Usuario</div>
        <div class="card-body">
            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Usuario</label>
                        <input type="text" name="usuario" class="form-control" value="{{ old('usuario') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nombre completo</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Rol</label>
                        <select name="rol" class="form-control" required>
                            <option value="">Seleccione</option>
                            <option value="admin">Admin</option>
                            <option value="inventario">Inventario</option>
                            <option value="procesos">Procesos</option>
                            <option value="despachos">Despachos</option>
                            <option value="produccion">Producción</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="activo" class="form-check-input" checked>
                    <label class="form-check-label">Activo</label>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection