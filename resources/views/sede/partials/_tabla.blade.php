<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{ $tabla }}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Nombre de la Sede</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sedes as $key => $sede)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $sede->nombre_sede }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar sede')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarSede-{{ $sede->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar sede')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $sede->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar sede')
                                <a href="#" class="btn btn-success restore" data-id="{{ $sede->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
