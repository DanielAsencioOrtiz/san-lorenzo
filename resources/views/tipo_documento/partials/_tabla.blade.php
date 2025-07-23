<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{ $tabla }}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Mostrar en Cliente</th>
                <th>Mostrar en Personal</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentos as $key => $doc)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $doc->nombre_documento }}</td>
                    <td>{{ $doc->mostrar_cliente ? 'Sí' : 'No' }}</td>
                    <td>{{ $doc->mostrar_personal ? 'Sí' : 'No' }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarDocumento-{{ $doc->id }}"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm delete" data-id="{{ $doc->id }}"><i class="fa fa-times"></i></a>
                        @else
                            <a href="#" class="btn btn-success btn-sm restore" data-id="{{ $doc->id }}"><i class="fa fa-undo"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
