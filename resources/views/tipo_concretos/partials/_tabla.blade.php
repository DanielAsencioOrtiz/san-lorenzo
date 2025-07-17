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
            @foreach ($tipo_concretos as $key => $tipo_concreto)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $tipo_concreto->nombre_tipo }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar moviles')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarTipoConcreto-{{ $tipo_concreto->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar moviles')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $tipo_concreto->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar tipo concreto')
                                <a href="#" class="btn btn-success restore" data-id="{{ $tipo_concreto->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
