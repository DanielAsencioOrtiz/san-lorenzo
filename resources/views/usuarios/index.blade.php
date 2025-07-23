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
    <h1 class="h3 mb-2 text-gray-800">Listado de usuarios</h1>
    <p class="mb-4">Administración de Usuarios y Roles</p>

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
            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Mensajes --}}
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

            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab">Activos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="eliminados-tab" data-toggle="tab" href="#eliminados" role="tab">Eliminados</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="activos" role="tabpanel">
                    @include('usuarios.partials._tabla', ['usuarios' => $usuarios, 'tipo' => 'activo', 'tabla' => '1'])
                </div>
                <div class="tab-pane fade" id="eliminados" role="tabpanel">
                    @include('usuarios.partials._tabla', ['usuarios' => $usuariosEliminados, 'tipo' => 'eliminado', 'tabla' => '2'])
                </div>
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
                        <label>DNI <span class="red">*</span></label>
                        <input type="text" name="dni" class="form-control" minlength="8" maxlength="8" required>
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
                        <label>Roles <span class="red">*</span></label>
                        <select name="roles[]" class="form-control select2" multiple required>
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sede <span class="red">*</span></label>
                        <select name="id_sede" class="form-control" required>
                            @foreach($sedes as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre_sede }}</option>
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
                            <label>DNI <span class="red">*</span></label>
                            <input type="text" name="dni" class="form-control" minlength="8" maxlength="8" value="{{ $u->dni }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email <span class="red">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña (dejar vacío para no cambiar)</label>
                            <input type="password" name="password" class="form-control" minlength="6">
                        </div>
                        @if(!$u->hasRole('SUPERADMINISTRADOR'))
                        <div class="form-group">
                            <label>Roles <span class="red">*</span></label>
                            <select name="roles[]" class="form-control select2" multiple required>
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}"
                                        {{ $u->roles->contains('name', $r->name) ? 'selected' : '' }}>
                                        {{ $r->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
          
                        @if(!$u->hasRole('SUPERADMINISTRADOR'))
                        <div class="form-group">
                            <label>Sede <span class="red">*</span></label>
                            <select name="id_sede" class="form-control" required>
                                @foreach($sedes as $s)
                                    <option value="{{ $s->id }}"
                                        {{ $u->id_sede == $s->id ? 'selected' : '' }}>
                                        {{ $s->nombre_sede }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                       
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

            $('.delete-user').on('click', function (e) {
                e.preventDefault();
                const id = $(this).data('id');

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
                        url: "/usuarios-delete/" + id,
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
    <script>
        $('.restore-user').on('click', function (e) {
            e.preventDefault();
            const id = $(this).data('id');

            swal({
                title: "¿Restaurar usuario?",
                text: "El usuario será reactivado.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                confirmButtonText: "Sí, restaurar",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type: "GET",
                    url: "/usuarios-restore/" + id,
                    success: function (data) {
                        if (data.success) {
                            swal("Restaurado", data.message, "success");
                            location.reload();
                        } else {
                            swal("Error", data.message, "error");
                        }
                    },
                    error: function () {
                        swal("Error", "No se pudo restaurar el usuario.", "error");
                    }
                });
            });
        });

    </script>
@endsection
