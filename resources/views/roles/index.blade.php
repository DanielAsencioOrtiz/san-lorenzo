@extends('layouts.app')

@section('title', 'Gestión de Roles y Permisos')

@section('content')
    <h2 class="mb-4">Gestión de Roles</h2>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    {{-- Crear nuevo rol --}}
    <form method="POST" action="{{ route('roles.store') }}" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="Nombre del rol" required>
            <button class="btn btn-primary">Crear Rol</button>
        </div>
    </form>

    {{-- Mostrar roles y checkboxes de permisos --}}
<div class="row g-3">
    @foreach ($roles as $role)
        <div class="col-sm-6 mb-4">
            <div class="card shadow-sm h-100 p-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Rol: {{ $role->name }}</strong>
                    <form method="POST" action="{{ route('roles.destroy', $role->id) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este rol?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.assignPermissions', $role->id) }}">
                        @csrf
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            id="perm_{{ $role->id }}_{{ $permission->id }}"
                                            {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $role->id }}_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-success btn-sm mt-3">Guardar permisos</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
