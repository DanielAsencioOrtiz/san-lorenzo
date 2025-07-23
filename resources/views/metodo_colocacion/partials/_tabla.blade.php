<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{$tabla}}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Nombre del Método</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($metodos as $key => $metodo)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $metodo->nombre_metodo }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar metodo colocacion')
                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarMetodoColocacion-{{ $metodo->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar metodo colocacion')
                                <a href="#" class="btn btn-danger btn-sm delete" data-id="{{ $metodo->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar metodo colocacion')
                                <a href="#" class="btn btn-success btn-sm restore" data-id="{{ $metodo->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
