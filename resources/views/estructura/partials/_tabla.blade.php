<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{$tabla}}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Nombre de la estructura</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estructuras as $key => $estructura)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $estructura->nombre_estructura }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar estructura')
                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarEstructura-{{ $estructura->id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan
                            @can('eliminar estructura')
                                <a href="#" class="btn btn-danger btn-sm delete" data-id="{{ $estructura->id }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endcan
                        @else
                            @can('restaurar estructura')
                                <a href="#" class="btn btn-success btn-sm restore" data-id="{{ $estructura->id }}">
                                    <i class="fa fa-undo"></i>
                                </a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
