@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<style>
    .table td { vertical-align: middle !important; }
</style>
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Listado de Clientes</h1>
<p class="mb-4">Gestión de clientes</p>

<div class="card shadow mb-4">
    @can('crear cliente')
    <div class="card-header py-3">
        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#nuevoCliente">
            <i class="fa fa-plus"></i> Nuevo Cliente
        </a>
    </div>
    @endcan
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
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

        <ul class="nav nav-tabs mb-3" id="clienteTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="activos-tab" data-toggle="tab" href="#activos" role="tab">Activos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="eliminados-tab" data-toggle="tab" href="#eliminados" role="tab">Eliminados</a>
            </li>
        </ul>

        <div class="tab-content" id="clienteTabContent">
            <div class="tab-pane fade show active" id="activos" role="tabpanel">
                @include('clientes.partials._tabla', ['clientes' => $clientes, 'tipo' => 'activo', 'tabla' => '1'])
            </div>
            <div class="tab-pane fade" id="eliminados" role="tabpanel">
                @include('clientes.partials._tabla', ['clientes' => $clientesEliminados, 'tipo' => 'eliminado', 'tabla' => '2'])
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVO CLIENTE -->
<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Nuevo Cliente</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Tipo de documento: <span class="text-danger">*</span></label>
                    <select name="id_documento" class="form-control" id="tipo_documento" required>
                        <option value="">Seleccione</option>
                        @foreach($documentos as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->nombre_documento }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">N° Documento: <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="nro_documento" id="nro_documento" class="form-control" required>
                            <div class="input-group-append">
                            <button type="button" id="buscarDocumento" class="btn btn-outline-secondary">
                                🔍
                            </button>
                        </div>
                    </div>

                    <label class="mt-2">Nombre: <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" id="nombre_cliente" class="form-control" required>

                    <label class="mt-2">Dirección: <span class="text-danger">*</span></label>
                    <input type="text" name="direccion" id="direccion_cliente" class="form-control" required>

                    <label class="mt-2">Teléfono:</label>
                    <input type="text" name="telefono" class="form-control">

                    <label class="mt-2">Departamento: <span class="text-danger">*</span></label>
                    <select name="departamento" id="departamento" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->departamento }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">Provincia: <span class="text-danger">*</span></label>
                    <select name="provincia" id="provincia" class="form-control" required></select>

                    <label class="mt-2">Distrito: <span class="text-danger">*</span></label>
                    <select name="id_distrito" id="distrito" class="form-control" required></select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!--MODAL EDITAR -->
@foreach ($clientes as $cliente)
<!-- MODAL EDITAR CLIENTE -->
<div class="modal fade" id="editarCliente-{{ $cliente->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header header-modal">
                    <h5 class="modal-title">Editar Cliente</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Tipo de documento: <span class="text-danger">*</span></label>
                    <select name="id_documento" id="tipo_documento_{{ $cliente->id }}" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($documentos as $doc)
                            <option value="{{ $doc->id }}" {{ $cliente->id_documento == $doc->id ? 'selected' : '' }}>
                                {{ $doc->nombre_documento }}
                            </option>
                        @endforeach
                    </select>

                    <label class="mt-2">N° Documento: <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="nro_documento" id="nro_documento_{{ $cliente->id }}" class="form-control nro-documento" value="{{ $cliente->nro_documento }}" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary buscar-documento" data-id="{{ $cliente->id }}">
                                🔍
                            </button>
                        </div>
                    </div>


                    <label class="mt-2">Nombre: <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" id="nombre_cliente_{{ $cliente->id }}" class="form-control" value="{{ $cliente->nombre }}" required>

                    <label class="mt-2">Dirección: <span class="text-danger">*</span></label>
                    <input type="text" name="direccion" id="direccion_cliente_{{ $cliente->id }}" class="form-control" value="{{ $cliente->direccion }}" required>

                    <label class="mt-2">Teléfono:</label>
                    <input type="text" name="telefono" class="form-control" value="{{ $cliente->telefono }}">

                    @php
                        $dep_id = $cliente->distrito->provincia->departamento->id;
                        $prov_id = $cliente->distrito->provincia->id;
                        $dist_id = $cliente->distrito->id;
                    @endphp

                    <label class="mt-2">Departamento: <span class="text-danger">*</span></label>
                    <select class="form-control departamento-select" data-target="#provincia-{{ $cliente->id }}" data-distrito="#distrito-{{ $cliente->id }}" data-provincia="{{ $prov_id }}" data-distrito-id="{{ $dist_id }}" required>
                        <option value="">Seleccione</option>
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}" {{ $dep->id == $dep_id ? 'selected' : '' }}>{{ $dep->departamento }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">Provincia: <span class="text-danger">*</span></label>
                    <select id="provincia-{{ $cliente->id }}" class="form-control provincia-select" data-distrito="#distrito-{{ $cliente->id }}" required>
                    @php
                        $provList = optional($cliente->distrito->provincia)->provincias ?? [];
                    @endphp

                    @foreach($provList as $prov)      
                        <option value="{{ $prov->id }}" {{ $prov->id == $prov_id ? 'selected' : '' }}>{{ $prov->provincia }}</option>
                    @endforeach

                    </select>

                    <label class="mt-2">Distrito: <span class="text-danger">*</span></label>
                    <select name="id_distrito" id="distrito-{{ $cliente->id }}" class="form-control" data-selected="{{ $dist_id }}" required>

                    @php
                        $distList = optional($cliente->distrito->provincia)->distritos ?? [];
                    @endphp

                    @foreach($distList as $dist)
                        <option value="{{ $dist->id }}" {{ $dist->id == $dist_id ? 'selected' : '' }}>
                            {{ $dist->distrito }}
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

<script>
$(document).ready(function() {
    // SweetAlert delete
    $('.delete').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
            title: "Eliminar Cliente",
            text: "Esta acción desactivará al cliente.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí, eliminar!",
            closeOnConfirm: false
        }, function() {
            $.get("/clientes-delete/" + id, function(data) {
                swal("Eliminado", data.message, "success");
                location.reload();
            });
        });
    });

    // SweetAlert restore
    $('.restore').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        swal({
            title: "Restaurar Cliente",
            text: "¿Deseas restaurar este cliente?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Sí, restaurar!",
            closeOnConfirm: false
        }, function() {
            $.get("/clientes-restore/" + id, function(data) {
                if (data.success) {
                    swal("Restaurado", data.message, "success");
                    location.reload();
                } else {
                    swal("Error", data.message, "error");
                }
            });
        });
    });

    // AJAX: provincias según departamento
    $('#departamento').on('change', function() {
        let id = $(this).val();
        $('#provincia').html('<option value="">Cargando...</option>');
        $('#distrito').html('<option value="">Seleccione</option>');
        $.get('/clientes/provincias/' + id, function(data) {
            let options = '<option value="">Seleccione</option>';
            data.forEach(function(p) {
                options += `<option value="${p.id}">${p.provincia}</option>`;
            });
            $('#provincia').html(options);
        });
    });

    // AJAX: distritos según provincia
    $('#provincia').on('change', function() {
        let id = $(this).val();
        $('#distrito').html('<option value="">Cargando...</option>');
        $.get('/clientes/distritos/' + id, function(data) {
            let options = '<option value="">Seleccione</option>';
            data.forEach(function(d) {
                options += `<option value="${d.id}">${d.distrito}</option>`;
            });
            $('#distrito').html(options);
        });
    });
});
</script>
<script>
    // Manejo dinámico para selects de modales de edición
    $(document).on('change', '.departamento-select', function () {
        const idDep = $(this).val();
        const provinciaSelector = $(this).data('target');
        const distritoSelector = $(this).data('distrito');

        $(provinciaSelector).html('<option value="">Cargando...</option>');
        $(distritoSelector).html('<option value="">Seleccione</option>');

        $.get('/clientes/provincias/' + idDep, function (data) {
            let options = '<option value="">Seleccione</option>';
            data.forEach(function (prov) {
                options += `<option value="${prov.id}">${prov.provincia}</option>`;
            });
            $(provinciaSelector).html(options);
        });
    });

    $(document).on('change', '.provincia-select', function () {
        const idProv = $(this).val();
        const distritoSelector = $(this).data('distrito');

        $(distritoSelector).html('<option value="">Cargando...</option>');

        $.get('/clientes/distritos/' + idProv, function (data) {
            let options = '<option value="">Seleccione</option>';
            data.forEach(function (dist) {
                options += `<option value="${dist.id}">${dist.distrito}</option>`;
            });
            $(distritoSelector).html(options);
        });
    });
</script>
<script>
$(document).on('show.bs.modal', '.modal', function () {
    const departamentoSelect = $(this).find('.departamento-select');
    const provinciaSelector = departamentoSelect.data('target');
    const distritoSelector = departamentoSelect.data('distrito');

    const selectedDepartamento = departamentoSelect.val();
    const selectedProvincia = departamentoSelect.data('provincia');
    const selectedDistrito = departamentoSelect.data('distrito-id');

    // Cargar provincias
    if (selectedDepartamento) {
        $.get('/clientes/provincias/' + selectedDepartamento, function (data) {
            let options = '<option value="">Seleccione</option>';
            data.forEach(function (prov) {
                console.log(prov);
                const selected = (prov.id == selectedProvincia) ? 'selected' : '';
                options += `<option value="${prov.id}" ${selected}>${prov.provincia}</option>`;
            });
            $(provinciaSelector).html(options);

            // Cargar distritos solo después de que provincias estén listas
            if (selectedProvincia) {
                $.get('/clientes/distritos/' + selectedProvincia, function (data) {
                    let distOptions = '<option value="">Seleccione</option>';
                    data.forEach(function (dist) {
                        const selected = (dist.id == selectedDistrito) ? 'selected' : '';
                        distOptions += `<option value="${dist.id}" ${selected}>${dist.distrito}</option>`;
                    });
                    $(distritoSelector).html(distOptions);
                });
            }
        });
    }
});

</script>
<script>
    $('#buscarDocumento').on('click', function () {
        const tipoTexto = $('#tipo_documento option:selected').text().trim().toLowerCase();
        const numero = $('#nro_documento').val();

        if (!tipoTexto  || !numero) {
            alert('Seleccione tipo de documento y escriba el número.');
            return;
        }

        // Validamos solo si es DNI o RUC para no admiitr otros documentos porque solo permite eso en el api
        if (!['dni', 'ruc'].includes(tipoTexto)) {
            alert('Solo se puede buscar documentos tipo DNI o RUC.');
            return;
        }

        swal({
        title: "Buscando...",
        text: "Consultando documento, por favor espera",
        imageUrl: "/img/loader.gif", 
        showConfirmButton: false,
        allowOutsideClick: false
        });

        $.ajax({
            url: `/consulta-documento/${tipoTexto}/${numero}`,
            method: 'GET',
            success: function (data) {
                if (tipoTexto === 'dni') {
                    const nombre = `${data.nombres} ${data.apellidoPaterno} ${data.apellidoMaterno}`;
                    $('#nombre_cliente').val(nombre);
                    $('#direccion_cliente').val('');
                } else if (tipoTexto === 'ruc') {
                    $('#nombre_cliente').val(data.razonSocial);
                    $('#direccion_cliente').val(data.direccion);
                }
                swal.close();
            },
            error: function (xhr) {
                console.error(xhr);
                swal("Error", "Ocurrió un error al consultar el documento.", "error");
            }
        });
    });
</script>
<script>
    $(document).on('click', '.buscar-documento', function () {
    const id = $(this).data('id');
    const tipoTexto = $(`#tipo_documento_${id} option:selected`).text().trim().toLowerCase();
    const numero = $(`#nro_documento_${id}`).val();

    if (!tipoTexto || !numero) {
        alert('Seleccione tipo de documento y escriba el número.');
        return;
    }

    if (!['dni', 'ruc'].includes(tipoTexto)) {
        alert('Solo se puede buscar documentos tipo DNI o RUC.');
        return;
    }

    swal({
        title: "Buscando...",
        text: "Consultando documento, por favor espera",
        imageUrl: "/img/loader.gif", 
        showConfirmButton: false,
        allowOutsideClick: false
    });

    $.ajax({
        url: `/consulta-documento/${tipoTexto}/${numero}`,
        method: 'GET',
        success: function (data) {
            if (tipoTexto === 'dni') {
                const nombre = `${data.nombres} ${data.apellidoPaterno} ${data.apellidoMaterno}`;
                $(`#nombre_cliente_${id}`).val(nombre);
                $(`#direccion_cliente_${id}`).val('');
            } else if (tipoTexto === 'ruc') {
                $(`#nombre_cliente_${id}`).val(data.razonSocial);
                $(`#direccion_cliente_${id}`).val(data.direccion);
            }
            swal.close();
        },
        error: function (xhr) {
            console.error(xhr);
            swal("Error", "Ocurrió un error al consultar el documento.", "error");
        }
    });
});

</script>
@endsection
