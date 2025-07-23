<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{$tabla}}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($canteras as $key => $cantera)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $cantera->nombre_cantera }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar cantera')
                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarCantera-{{ $cantera->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar cantera')
                                <a href="#" class="btn btn-danger btn-sm delete" data-id="{{ $cantera->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar cantera')
                                <a href="#" class="btn btn-success btn-sm restore" data-id="{{ $cantera->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

