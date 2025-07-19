@extends('layouts.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>.table td { vertical-align:middle !important; }</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Personal</h1>
<p class="mb-4">Gestión de personal de la empresa</p>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoPersonal"><i class="fa fa-plus"></i> Nuevo Registro</a>
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
                @include('personal.partials._tabla', ['personales' => $personales, 'tipo' => 'activo', 'tabla' => '1'])
            </div>
            <div class="tab-pane fade" id="eliminados">
                @include('personal.partials._tabla', ['personales' => $eliminados, 'tipo' => 'eliminado', 'tabla' => '2'])
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="nuevoPersonal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('personal.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Personal</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Tipo de documento (*)</label>
                    <select name="id_documento" class="form-control" required>
                        @foreach($tiposDocumento as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->nombre_documento }}</option>
                        @endforeach
                    </select>

                    <label>Número de documento (*)</label>
                    <input type="text" name="nro_documento" class="form-control" required>

                    <label>Fecha de ingreso (*)</label>
                    <input type="date" name="fecha_ingreso" class="form-control" required>

                    <label>Nombres (*)</label>
                    <input type="text" name="nombres" class="form-control" required>

                    <label>Apellidos (*)</label>
                    <input type="text" name="apellidos" class="form-control" required>

                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control">

                    <label>Tipo de personal (*)</label>
                    <select name="id_tipo_personal" class="form-control select2" required>
                        @foreach($tiposPersonal as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre_tipo }}</option>
                        @endforeach
                    </select>

                     <label>Brevete</label>
                    <input type="text" name="brevete" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar -->
@foreach ($personales as $p)
<div class="modal fade" id="editarPersonal-{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('personal.update', $p->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Personal</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Tipo de documento (*)</label>
                    <select name="id_documento" class="form-control" required>
                        @foreach($tiposDocumento as $doc)
                            <option value="{{ $doc->id }}" {{ $p->id_documento == $doc->id ? 'selected' : '' }}>
                                {{ $doc->nombre_documento }}
                            </option>
                        @endforeach
                    </select>

                    <label>Número de documento (*)</label>
                    <input type="text" name="nro_documento" class="form-control" value="{{ $p->nro_documento }}" required>

                    <label>Fecha de ingreso (*)</label>
                    <input type="date" name="fecha_ingreso" class="form-control" value="{{ $p->fecha_ingreso }}" required>

                    <label>Nombres (*)</label>
                    <input type="text" name="nombres" class="form-control" value="{{ $p->nombres }}" required>

                    <label>Apellidos (*)</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ $p->apellidos }}" required>

                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ $p->telefono }}">

                    <label>Tipo de personal (*)</label>
                    <select name="id_tipo_personal" class="form-control select2" required>
                        @foreach($tiposPersonal as $tipo)
                            <option value="{{ $tipo->id }}" {{ $p->id_tipo_personal == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre_tipo }}
                            </option>
                        @endforeach
                    </select>

                    <label>Brevete</label>
                    <input type="text" name="brevete" class="form-control" value="{{ $p->brevete }}">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
    $('.delete').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        swal({
            title: "Eliminar Personal",
            text: "¿Deseas desactivar este registro?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí, eliminar!",
            closeOnConfirm: false
        }, function() {
            $.get("/personal-delete/" + id, function(data) {
                swal("Eliminado", data.message, "success");
                location.reload();
            });
        });
    });

    $('.restore').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        swal({
            title: "Restaurar Personal",
            text: "¿Deseas restaurar este personal?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Sí, restaurar!",
            closeOnConfirm: false
        }, function() {
            $.get("/personal-restore/" + id, function(data) {
                if (data.success) {
                    swal("Restaurado", data.message, "success");
                    location.reload();
                } else {
                    swal("Error", data.message, "error");
                }
            });
        });
    });
</script>
<script>
    function initSelect2() {
        $('.select2').select2({
            dropdownParent: $('#nuevoPersonal, .modal.show'),
            width: '100%'
        });
    }

    $(document).ready(function () {
        initSelect2();

        $('#nuevoPersonal').on('shown.bs.modal', function () {
            initSelect2();
        });

        $('.modal').on('shown.bs.modal', function () {
            initSelect2();
        });
    });
</script>
@endsection
