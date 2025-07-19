@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>.table td { vertical-align:middle !important; }</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Tipo de Personal</h1>
<p class="mb-4">Gestión de tipos de personal</p>

<div class="card shadow mb-4">
    @can('crear tipo personal')
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoTipoPersonal"><i class="fa fa-plus"></i> Nuevo Registro</a>
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

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#activos">Activos</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eliminados">Eliminados</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="activos">
                @include('tipo_personal.partials._tabla', ['tipos' => $tipos, 'tipo' => 'activo', 'tabla' => '1'])
            </div>
            <div class="tab-pane fade" id="eliminados">
                @include('tipo_personal.partials._tabla', ['tipos' => $tiposEliminados, 'tipo' => 'eliminado', 'tabla' => '2'])
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="nuevoTipoPersonal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tipo-personal.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Tipo de Personal</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del tipo de personal: <span class="text-danger">*</span></label>
                    <input type="text" name="nombre_tipo" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modales Editar -->
@foreach ($tipos as $tipo)
<div class="modal fade" id="editarTipoPersonal-{{ $tipo->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tipo-personal.update', $tipo->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Tipo de Personal</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del tipo de personal: <span class="text-danger">*</span></label>
                    <input type="text" name="nombre_tipo" class="form-control" value="{{ $tipo->nombre_tipo }}" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
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
    $('.delete').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        swal({
            title: "Eliminar Tipo de Personal",
            text: "Esta acción desactivará el registro.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí, eliminar!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "GET",
                url: "/tipo-personal-delete/" + id,
                success: function (data) {
                    swal("Eliminado", data.message, "success");
                    location.reload();
                }
            });
        });
    });

    $('.restore').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        swal({
            title: "Restaurar Tipo de Personal",
            text: "¿Deseas restaurar este registro?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Sí, restaurar!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "GET",
                url: "/tipo-personal-restore/" + id,
                success: function (data) {
                    if (data.success) {
                        swal("Restaurado", data.message, "success");
                        location.reload();
                    } else {
                        swal("Error", data.message, "error");
                    }
                }
            });
        });
    });
</script>
@endsection
