@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    .table td { vertical-align:middle !important; }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Tipos de Concreto</h1>
<p class="mb-4">Gestión de tipos de concreto registrados en el sistema</p>

<div class="card shadow mb-4">
    @can('crear tipo concreto')
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoTipoConcreto"><i class="fa fa-plus"></i> Nuevo Registro</a>
    </div>
    @endcan
    <div class="card-body">
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

        @if (session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('mensaje') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered" id="tabla-traducida" width="100%" cellspacing="0">
                <thead class="header-modal">
                    <tr>
                        <th>#</th>
                        <th>Nombre del Tipo</th>
                        <th>Estado</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipo_concretos as $key => $tipo_concreto)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $tipo_concreto->nombre_tipo }}</td>
                        <td>{{ $tipo_concreto->estado ? 'Activo' : 'Inactivo' }}</td>
                        <td class="text-center">
                            @can('editar tipo concreto')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarTipoConcreto-{{ $tipo_concreto->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar tipo concreto')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $tipo_concreto->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL NUEVO -->
<div class="modal fade" id="nuevoTipoConcreto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tipo_concretos.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Tipo de Concreto</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del Tipo: <span class="red">*</span></label>
                    <input type="text" name="nombre_tipo" class="form-control" required>
                    <label class="mt-2">Estado:</label>
                    <select name="estado" class="form-control">
                        <option value="1" selected>Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDITAR -->
@foreach ($tipo_concretos as $tipo_concreto)
<div class="modal fade" id="editarTipoConcreto-{{ $tipo_concreto->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tipo_concretos.update', $tipo_concreto->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Tipo de Concreto</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del Tipo: <span class="red">*</span></label>
                    <input type="text" name="nombre_tipo" class="form-control" value="{{ $tipo_concreto->nombre_tipo }}" required>
                    <label class="mt-2">Estado:</label>
                    <select name="estado" class="form-control">
                        <option value="1" {{ $tipo_concreto->estado ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$tipo_concreto->estado ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
    $(document).ready(function () {
        $('.delete').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Eliminar Tipo de Concreto",
                text: "Esta acción eliminará el registro.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí, eliminar!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "get",
                    url: "/tipo_concretos-delete/" + id,
                    success: function (data) {
                        swal("Eliminado", data.message, "success");
                        location.reload();
                    }
                });
            });
        });
    });
</script>
@endsection
