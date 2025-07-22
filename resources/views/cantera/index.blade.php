@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    .table td { vertical-align:middle !important; }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Canteras</h1>
<p class="mb-4">Gestión de canteras registradas</p>

<div class="card shadow mb-4">
    @can('crear cantera')
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevaCantera"><i class="fa fa-plus"></i> Nueva Cantera</a>
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

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="canteraTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab">Activos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="eliminados-tab" data-toggle="tab" href="#eliminados" role="tab">Eliminados</a>
            </li>
        </ul>

        <div class="tab-content" id="canteraTabContent">
            <!-- TAB ACTIVOS -->
            <div class="tab-pane fade show active" id="activos" role="tabpanel">
                @include('cantera.partials._tabla', ['canteras' => $canteras, 'tipo' => 'activo', 'tabla' => '1'])
            </div>

            <!-- TAB ELIMINADOS -->
            <div class="tab-pane fade" id="eliminados" role="tabpanel">
                @include('cantera.partials._tabla', ['canteras' => $canterasEliminadas, 'tipo' => 'eliminado', 'tabla' => '2'])
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVA CANTERA -->
<div class="modal fade" id="nuevaCantera" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('canteras.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nueva Cantera</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre de la cantera: <span class="red">*</span></label>
                    <input type="text" name="nombre_cantera" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDITAR CANTERA -->
@foreach ($canteras as $cantera)
<div class="modal fade" id="editarCantera-{{ $cantera->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('canteras.update', $cantera->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Cantera</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre de la cantera: <span class="red">*</span></label>
                    <input type="text" name="nombre_cantera" class="form-control" value="{{ $cantera->nombre_cantera }}" required>
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
                title: "Eliminar Cantera",
                text: "Esta acción eliminará el registro.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí, eliminar!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "get",
                    url: "/canteras-delete/" + id,
                    success: function (data) {
                        swal("Eliminado", data.message, "success");
                        location.reload();
                    }
                });
            });
        });
    });

    $('.restore').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
            title: "Restaurar Cantera",
            text: "¿Deseas restaurar esta cantera?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Sí, restaurar!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "get",
                url: "/canteras-restore/" + id,
                success: function (data) {
                    if (data.success) {
                        swal("Restaurado", data.message, "success");
                        location.reload();
                    } else {
                        swal("No se pudo restaurar", data.message, "error");
                    }
                }
            });
        });
    });
</script>
@endsection

