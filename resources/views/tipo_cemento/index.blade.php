@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    .table td { vertical-align:middle !important; }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Tipos de Cemento</h1>
<p class="mb-4">Gestión de tipos de cemento</p>

<div class="card shadow mb-4">
    @can('crear tipo cemento')
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoTipoCemento"><i class="fa fa-plus"></i> Nuevo Registro</a>
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
        <ul class="nav nav-tabs mb-3" id="cementoTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab">Activos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="eliminados-tab" data-toggle="tab" href="#eliminados" role="tab">Eliminados</a>
            </li>
        </ul>

        <div class="tab-content" id="cementoTabContent">
            <!-- TAB ACTIVOS -->
            <div class="tab-pane fade show active" id="activos" role="tabpanel">
                @include('tipo_cemento.partials._tabla', ['tipo_cementos' => $tipo_cementos, 'tipo' => 'activo', 'tabla' => '1'])
            </div>

            <!-- TAB ELIMINADOS -->
            <div class="tab-pane fade" id="eliminados" role="tabpanel">
                @include('tipo_cemento.partials._tabla', ['tipo_cementos' => $tipo_cementosEliminados, 'tipo' => 'eliminado', 'tabla' => '2'])
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVO -->
<div class="modal fade" id="nuevoTipoCemento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tipo_cementos.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Tipo de Cemento</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del Tipo: <span class="red">*</span></label>
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

<!-- MODAL EDITAR -->
@foreach ($tipo_cementos as $tipo_cemento)
<div class="modal fade" id="editarTipoCemento-{{ $tipo_cemento->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tipo_cementos.update', $tipo_cemento->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Tipo de Cemento</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del Tipo: <span class="red">*</span></label>
                    <input type="text" name="nombre_tipo" class="form-control" value="{{ $tipo_cemento->nombre_tipo }}" required>
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
                title: "Eliminar Tipo de Cemento",
                text: "Esta acción eliminará el registro.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí, eliminar!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "get",
                    url: "/tipo_cementos-delete/" + id,
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
            title: "Restaurar Tipo de Cemento",
            text: "¿Deseas restaurar este tipo de cemento?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Sí, restaurar!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "get",
                url: "/tipo_cementos-restore/" + id,
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

