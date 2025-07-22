@extends('layouts.app')

@section('title', 'Gestión de Roles y Permisos')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Roles y Permisos</h1>
<p class="mb-4">Gestión de roles y permisos</p>
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRoleModal"><i class="fa fa-plus"></i> Crear nuevo rol</button>
    </div>

    <div class="card-body">

        {{-- Alertas --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif



        {{-- Tabla de roles --}}
        <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-1">
            <thead  class="header-modal">
                <tr>
                    <th>#</th>
                    <th>Rol</th>
                    <th>Permisos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @if ($role->permissions->count() === $totalPermissions)
                                <span class="badge bg-success" style="color: white">Todos los permisos</span>
                            @else
                                @foreach ($role->permissions as $permission)
                                    <span class="badge bg-primary" style="color: white">{{ $permission->name }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            {{-- Botón para abrir modal de edición --}}
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editRoleModal_{{ $role->id }}"><i class="fa fa-edit"></i> </button>

                            {{-- Modal de edición --}}
                            <div class="modal fade" id="editRoleModal_{{ $role->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <form method="POST" action="{{ route('roles.assignPermissions', $role->id) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header header-modal">
                                                <h5 class="modal-title">Editar permisos para {{ $role->name }}</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                @foreach ($permissions as $category => $perms)
                                                    <h6 class="text-primary" style="color: #091e5d !important;background-color: #dbdbdb;padding: 5px;border-radius: 10px;font-weight: 700;">{{ ucfirst($category) }}</h6>
                                                    <div class="row mb-2">
                                                        @foreach ($perms as $permission)
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input"
                                                                           type="checkbox"
                                                                           name="permissions[]"
                                                                           value="{{ $permission->name }}"
                                                                           id="edit_perm_{{ $role->id }}_{{ $permission->id }}"
                                                                           {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edit_perm_{{ $role->id }}_{{ $permission->id }}">
                                                                        {{ $permission->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success">Guardar cambios</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Eliminar --}}
                            <form method="POST" action="{{ route('roles.destroy', $role->id) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este rol?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    {{-- Modal para crear rol --}}
    <div class="modal fade" id="createRoleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header header-modal">
                        <h5 class="modal-title">Crear nuevo rol</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Nombre del rol</label>
                            <input type="text" name="name" id="roleName" class="form-control" required>
                        </div>

                        @foreach ($permissions as $category => $perms)
                            <h6 class="text-primary" style="color: #091e5d !important;background-color: #dbdbdb;padding: 5px;border-radius: 10px;font-weight: 700;">{{ ucfirst($category) }}</h6>
                            <div class="row mb-2">
                                @foreach ($perms as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permission->name }}"
                                                   id="create_perm_{{ $permission->id }}">
                                            <label class="form-check-label" for="create_perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Crear Rol</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
