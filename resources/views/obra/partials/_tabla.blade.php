<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{ $tabla }}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Nombre de la Obra</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($obras as $key => $obra)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $obra->nombre_obra }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar obra')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarObra-{{ $obra->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar obra')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $obra->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar obra')
                                <a href="#" class="btn btn-success restore" data-id="{{ $obra->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

