<div class="table-responsive">
    <table class="table table-bordered" id="tabla-traducida-{{ $tabla }}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Apellidos y Nombres</th>
                <th>N° Documento</th>
                <th>Fecha de ingreso</th>
                <th>Tipo Personal</th>
                <th>Brevete</th>
                <th>Teléfono</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personales as $key => $p)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $p->apellidos }} {{ $p->nombres }}</td>
                    <td><strong>{{ $p->tipoDocumento->nombre_documento ?? '' }}:</strong> {{ $p->nro_documento }}</td>
                    <td>{{ $p->fecha_ingreso }}</td>
                    <td>{{ $p->tipoPersonal->nombre_tipo ?? '' }}</td>
                    <td>{{ $p->brevete ?? '---'}}</td>
                    <td>{{ $p->telefono }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarPersonal-{{ $p->id }}"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm delete" data-id="{{ $p->id }}"><i class="fa fa-times"></i></a>
                        @else
                            <a href="#" class="btn btn-success btn-sm restore" data-id="{{ $p->id }}"><i class="fa fa-undo"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
