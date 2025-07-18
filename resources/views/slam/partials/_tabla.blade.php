<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{$tabla}}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Tipo</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($slams as $key => $slam)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $slam->nombre_slam }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar slam')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarSlam-{{ $slam->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar slam')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $slam->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar slam')
                                <a href="#" class="btn btn-success restore" data-id="{{ $slam->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
