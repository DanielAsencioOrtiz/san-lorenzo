@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>.table td { vertical-align:middle !important; }</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Tipos de Documento</h1>
<p class="mb-4">Gestión de tipos de documento para clientes y personal</p>

<div class="card shadow mb-4">
    @can('crear tipo documento')
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoDocumento"><i class="fa fa-plus"></i> Nuevo Registro</a>
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
                @include('tipo_documento.partials._tabla', ['documentos' => $documentos, 'tipo' => 'activo', 'tabla' => '1'])
            </div>
            <div class="tab-pane fade" id="eliminados">
                @include('tipo_documento.partials._tabla', ['documentos' => $documentosEliminados, 'tipo' => 'eliminado', 'tabla' => '2'])
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="nuevoDocumento" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tipo-documento.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Tipo de Documento</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del documento: <span class="text-danger">*</span></label>
                    <input type="text" name="nombre_documento" class="form-control" required>

                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" name="mostrar_cliente" id="mostrar_cliente" checked>
                        <label class="form-check-label" for="mostrar_cliente">Mostrar para cliente</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="mostrar_personal" id="mostrar_personal" checked>
                        <label class="form-check-label" for="mostrar_personal">Mostrar para personal</label>
                    </div>
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
@foreach ($documentos as $doc)
<div class="modal fade" id="editarDocumento-{{ $doc->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('tipo-documento.update', $doc->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Tipo de Documento</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nombre del documento: <span class="text-danger">*</span></label>
                    <input type="text" name="nombre_documento" class="form-control" value="{{ $doc->nombre_documento }}" required>

                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" name="mostrar_cliente" id="mostrar_cliente_{{ $doc->id }}" {{ $doc->mostrar_cliente ? 'checked' : '' }}>
                        <label class="form-check-label" for="mostrar_cliente_{{ $doc->id }}">Mostrar para cliente</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="mostrar_personal" id="mostrar_personal_{{ $doc->id }}" {{ $doc->mostrar_personal ? 'checked' : '' }}>
                        <label class="form-check-label" for="mostrar_personal_{{ $doc->id }}">Mostrar para personal</label>
                    </div>
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
            title: "Eliminar Documento",
            text: "¿Deseas desactivar este tipo de documento?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí, eliminar!",
            closeOnConfirm: false
        }, function() {
            $.get("/tipo-documento-delete/" + id, function(data) {
                swal("Eliminado", data.message, "success");
                location.reload();
            });
        });
    });

    $('.restore').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        swal({
            title: "Restaurar Documento",
            text: "¿Deseas restaurar este documento?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Sí, restaurar!",
            closeOnConfirm: false
        }, function() {
            $.get("/tipo-documento-restore/" + id, function(data) {
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
@endsection
