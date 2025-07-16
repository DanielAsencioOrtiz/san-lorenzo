@extends('layouts.app')

@section('css')
    {{-- SweetAlert + Select2 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .table td { vertical-align: middle !important; }
        .red { color: red; }
    </style>
@endsection

@section('content')
    <!-- Encabezado -->
    <h1 class="h3 mb-2 text-gray-800">Listado de usuarios</h1>
    <p class="mb-4">Administración de Usuarios y Roles</p>

    <!-- Card principal -->
    <div class="card shadow mb-4">
        {{-- Botón crear --}}
        @can('crear usuarios')
        <div class="card-header py-3">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoUsuario">
                <i class="fa fa-plus"></i> Nuevo Usuario
            </a>
        </div>
        @endcan
        <div class="card-body">
            @if (session('mensaje'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('mensaje') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" id="tabla-traducida">
                    <thead class="header-modal">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $key => $u)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @foreach ($u->roles as $r)
                                        <span class="badge badge-info">{{ $r->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @can('editar usuarios')
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                       data-target="#editarUsuario-{{ $u->id }}"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('eliminar usuarios')
                                    <a href="#" class="btn btn-danger btn-sm delete-user" data-id="{{ $u->id }}">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ======= Modal Nuevo Usuario ======= -->
    <div class="modal fade" id="nuevoUsuario" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Usuario</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre <span class="red">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email <span class="red">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña <span class="red">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="form-group">
                            <label>Roles</label>
                            <select name="roles[]" class="form-control select2" multiple>
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ======= Modales Editar Usuario ======= -->
    @foreach ($usuarios as $u)
        <div class="modal fade" id="editarUsuario-{{ $u->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header header-modal">
                        <h5 class="modal-title">Editar Usuario</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form action="{{ route('usuarios.update', $u->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nombre <span class="red">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Email <span class="red">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
                            </div>
                            <div class="form-group">
                                <label>Contraseña (dejar vacío para no cambiar)</label>
                                <input type="password" name="password" class="form-control" minlength="6">
                            </div>
                            <div class="form-group">
                                <label>Roles</label>
                                <select name="roles[]" class="form-control select2" multiple>
                                    @foreach($roles as $r)
                                        <option value="{{ $r->name }}"
                                            {{ $u->roles->contains('name', $r->name) ? 'selected' : '' }}>
                                            {{ $r->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    {{-- SweetAlert + Select2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function () {
            $('.select2').select2({ width: '100%' });

            // Eliminar usuario
            $('.delete-user').on('click', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                const url = '/usuarios-delete/' + id;

                swal({
                    title: "Eliminar usuario",
                    text: "¡Esta acción no se puede deshacer!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sí, eliminar",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function () {
                            swal("¡Eliminado!", "El usuario ha sido eliminado.", "success");
                            location.reload();
                        },
                        error: function () {
                            swal("Error", "No se pudo eliminar el usuario.", "error");
                        }
                    });
                });
            });
        });
    </script>
@endsection
