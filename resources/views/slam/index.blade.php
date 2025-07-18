@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    .table td { vertical-align:middle !important; }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Slams</h1>
<p class="mb-4">Gestión de slams de cemento</p>

<div class="card shadow mb-4">
    @can('crear slam')
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoSlam"><i class="fa fa-plus"></i> Nuevo Registro</a>
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
        <ul class="nav nav-tabs mb-3" id="slamTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab">Activos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="eliminados-tab" data-toggle="tab" href="#eliminados" role="tab">Eliminados</a>
            </li>
        </ul>

        <div class="tab-content" id="slamTabContent">
            <!-- TAB ACTIVOS -->
            <div class="tab-pane fade show active" id="activos" role="tabpanel">
                @include('slam.partials._tabla', ['slams' => $slams, 'tipo' => 'activo', 'tabla' => '1'])
            </div>

            <!-- TAB ELIMINADOS -->
            <div class="tab-pane fade" id="eliminados" role="tabpanel">
                @include('slam.partials._tabla', ['slams' => $slamsEliminadas, 'tipo' => 'eliminado', 'tabla' => '2'])
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVO -->
<div class="modal fade" id="nuevoSlam" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('slams.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Slam</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del slam: <span class="red">*</span></label>
                    <input type="text" name="nombre_slam" class="form-control" required>
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
@foreach ($slams as $slam)
<div class="modal fade" id="editarSlam-{{ $slam->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('slams.update', $slam->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Slam</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del slam: <span class="red">*</span></label>
                    <input type="text" name="nombre_slam" class="form-control" value="{{ $slam->nombre_slam }}" required>
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
                title: "Eliminar Slam",
                text: "Esta acción eliminará el registro.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí, eliminar!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "get",
                    url: "/slams-delete/" + id,
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
            title: "Restaurar Slam",
            text: "¿Deseas restaurar este slam?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Sí, restaurar!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "get",
                url: "/slams-restore/" + id,
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

