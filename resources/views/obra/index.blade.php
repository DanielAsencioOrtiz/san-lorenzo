@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    .table td { vertical-align:middle !important; }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Obras</h1>
<p class="mb-4">Gestión de obras</p>

<div class="card shadow mb-4">
    @can('crear obra')
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevaObra"><i class="fa fa-plus"></i> Nueva Obra</a>
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

        <ul class="nav nav-tabs mb-3" id="obraTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab">Activas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="eliminadas-tab" data-toggle="tab" href="#eliminadas" role="tab">Eliminadas</a>
            </li>
        </ul>

        <div class="tab-content" id="obraTabContent">
            <div class="tab-pane fade show active" id="activos" role="tabpanel">
                @include('obra.partials._tabla', ['obras' => $obras, 'tipo' => 'activo', 'tabla' => '1'])
            </div>
            <div class="tab-pane fade" id="eliminadas" role="tabpanel">
                @include('obra.partials._tabla', ['obras' => $obrasEliminadas, 'tipo' => 'eliminado', 'tabla' => '2'])
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVA OBRA -->
<div class="modal fade" id="nuevaObra" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('obras.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nueva Obra</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre de la obra: <span class="red">*</span></label>
                    <input type="text" name="nombre_obra" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDITAR OBRA -->
@foreach ($obras as $obra)
<div class="modal fade" id="editarObra-{{ $obra->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('obras.update', $obra->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Obra</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre de la obra: <span class="red">*</span></label>
                    <input type="text" name="nombre_obra" class="form-control" value="{{ $obra->nombre_obra }}" required>
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
    $('.delete').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
            title: "Eliminar Obra",
            text: "Esta acción eliminará la obra.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí, eliminar!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "get",
                url: "/obras-delete/" + id,
                success: function (data) {
                    swal("Eliminado", data.message, "success");
                    location.reload();
                }
            });
        });
    });

    $('.restore').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
            title: "Restaurar Obra",
            text: "¿Deseas restaurar esta obra?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Sí, restaurar!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "get",
                url: "/obras-restore/" + id,
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

