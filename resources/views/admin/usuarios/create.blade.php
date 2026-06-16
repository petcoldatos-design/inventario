@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Nuevo Usuario</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Usuario (nombre único)</label>
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
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Rol</label>
                        <select name="rol" class="form-control" required>
                            <option value="">Seleccione</option>
                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="inventario" {{ old('rol') == 'inventario' ? 'selected' : '' }}>Inventario</option>
                            <option value="procesos" {{ old('rol') == 'procesos' ? 'selected' : '' }}>Procesos</option>
                            <option value="despachos" {{ old('rol') == 'despachos' ? 'selected' : '' }}>Despachos</option>
                            <option value="produccion" {{ old('rol') == 'produccion' ? 'selected' : '' }}>Producción</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Estado</label>
                        <select name="activo" class="form-control">
                            <option value="1" {{ old('activo') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>Inactivo</option>
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

                <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection