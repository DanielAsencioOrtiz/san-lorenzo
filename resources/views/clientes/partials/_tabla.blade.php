<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{ $tabla }}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Ubicación</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $key => $cliente)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        {{ $cliente->documento->nombre_documento ?? '-' }}<br>
                        <strong>{{ $cliente->nro_documento }}</strong>
                    </td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>{{ $cliente->telefono ?? '-' }}</td>
                    <td>
                        {{ $cliente->distrito->provincia->departamento->departamento ?? '' }} /
                        {{ $cliente->distrito->provincia->provincia ?? '' }} /
                        {{ $cliente->distrito->distrito ?? '' }}
                    </td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar cliente')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarCliente-{{ $cliente->id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan
                            @can('eliminar cliente')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $cliente->id }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endcan
                        @else
                            @can('restaurar cliente')
                                <a href="#" class="btn btn-success restore" data-id="{{ $cliente->id }}">
                                    <i class="fa fa-undo"></i>
                                </a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
