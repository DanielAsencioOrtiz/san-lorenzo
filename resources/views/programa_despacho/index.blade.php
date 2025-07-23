@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .table td { vertical-align:middle !important; }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Programas de Despacho</h1>
<p class="mb-4">Gestión de programas registrados</p>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoPrograma"><i class="fa fa-plus"></i> Nuevo Programa</a>
    </div>

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

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="programaTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab">Activos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="eliminados-tab" data-toggle="tab" href="#eliminados" role="tab">Eliminados</a>
            </li>
        </ul>

        <div class="tab-content" id="programaTabContent">
            <!-- TAB ACTIVOS -->
            <div class="tab-pane fade show active" id="activos" role="tabpanel">
                @include('programa_despacho.partials._tabla', ['programas' => $programas, 'tipo' => 'activo'])
            </div>

            <!-- TAB ELIMINADOS -->
            <div class="tab-pane fade" id="eliminados" role="tabpanel">
                @include('programa_despacho.partials._tabla', ['programas' => $programasEliminados, 'tipo' => 'eliminado'])
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVO PROGRAMA -->
<div class="modal fade" id="nuevoPrograma" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('programas.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Programa</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Fecha del programa: <span class="red">*</span></label>
                    <input type="date" name="fecha_programa" class="form-control" required>

                    <label class="mt-2">Sede: <span class="red">*</span></label>
                    <select name="id_sede" class="form-control" required>
                        @foreach ($sedes as $sede)
                            <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                        @endforeach
                    </select>


                    <label class="mt-2">Hora entrada personal:</label>
                    <input type="time" name="hora_entrada_personal" class="form-control">

                    <label class="mt-2">Personal asignado:</label>
                    <select name="id_personal[]" class="form-control select2" multiple>
                        @foreach ($personalDisponible as $personal)
                            <option value="{{ $personal->id }}">
                                {{ $personal->nombres }} {{ $personal->apellidos }} - {{ $personal->nro_documento }}
                            </option>
                        @endforeach
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

<!-- MODALES EDITAR PROGRAMA -->
@foreach ($programas as $programa)
<div class="modal fade" id="editarPrograma-{{ $programa->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('programas.update', $programa->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Programa</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Fecha del programa:</label>
                    <input type="date" name="fecha_programa" value="{{ $programa->fecha_programa }}" class="form-control" required>

                    <label class="mt-2">Sede:</label>
                    <select name="id_sede" class="form-control" required>
                        @foreach ($sedes as $sede)
                            <option value="{{ $sede->id }}" {{ $programa->id_sede == $sede->id ? 'selected' : '' }}>
                                {{ $sede->nombre_sede }}
                            </option>
                        @endforeach
                    </select>

                    <label class="mt-2">Hora entrada personal:</label>
                    <input type="time" name="hora_entrada_personal" value="{{ $programa->hora_entrada_personal }}" class="form-control">

                    <label class="mt-2">Personal asignado (tipo 2):</label>
                    <select name="id_personal[]" class="form-control select2" multiple>
                        @foreach ($personalDisponible as $personal)
                            <option value="{{ $personal->id }}"
                                {{ $programa->personalDespacho->contains($personal->id) ? 'selected' : '' }}>
                                {{ $personal->nombres }} {{ $personal->apellidos }} - {{ $personal->nro_documento }}
                            </option>
                        @endforeach
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({ width: '100%' });
        $('.delete').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Eliminar Programa",
                text: "Esta acción marcará el programa como eliminado.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí, eliminar!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "get",
                    url: "/programas-delete/" + id,
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
                title: "Restaurar Programa",
                text: "¿Deseas restaurar este programa?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                confirmButtonText: "Sí, restaurar!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "get",
                    url: "/programas-restore/" + id,
                    success: function (data) {
                        swal("Restaurado", data.message, "success");
                        location.reload();
                    }
                });
            });
        });
    });
</script>
@endsection
