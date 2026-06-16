@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Mi Perfil</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Usuario (no editable)</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->usuario }}" disabled>
                </div>

                <div class="mb-3">
                    <label>Nombre completo</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                </div>

                <div class="mb-3">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                </div>

                <div class="mb-3">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', auth()->user()->telefono) }}">
                </div>

                <div class="mb-3">
                    <label>Nueva contraseña (dejar en blanco para no cambiar)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection