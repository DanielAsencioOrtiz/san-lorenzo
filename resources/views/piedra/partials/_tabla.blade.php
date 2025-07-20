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
            @foreach ($piedras as $key => $piedra)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $piedra->nombre_piedra }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar piedra')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarPiedra-{{ $piedra->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar piedra')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $piedra->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar piedra')
                                <a href="#" class="btn btn-success restore" data-id="{{ $piedra->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
