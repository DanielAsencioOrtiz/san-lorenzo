<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{ $tabla }}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Nombre del Tipo</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tipos as $key => $tipo_personal)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $tipo_personal->nombre_tipo }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar tipo personal')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarTipoPersonal-{{ $tipo_personal->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar tipo personal')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $tipo_personal->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar tipo personal')
                                <a href="#" class="btn btn-success restore" data-id="{{ $tipo_personal->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
