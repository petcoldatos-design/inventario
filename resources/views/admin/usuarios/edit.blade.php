@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h4>Editar Usuario: {{ $usuario->usuario }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Usuario</label>
                        <input type="text" name="usuario" class="form-control" value="{{ old('usuario', $usuario->usuario) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nombre completo</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $usuario->name) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $usuario->telefono) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Rol</label>
                        <select name="rol" class="form-control" required>
                            <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="inventario" {{ $usuario->rol == 'inventario' ? 'selected' : '' }}>Inventario</option>
                            <option value="procesos" {{ $usuario->rol == 'procesos' ? 'selected' : '' }}>Procesos</option>
                            <option value="despachos" {{ $usuario->rol == 'despachos' ? 'selected' : '' }}>Despachos</option>
                            <option value="produccion" {{ $usuario->rol == 'produccion' ? 'selected' : '' }}>Producción</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Estado</label>
                        <select name="activo" class="form-control">
                            <option value="1" {{ $usuario->activo ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$usuario->activo ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nueva contraseña (dejar en blanco para no cambiar)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection