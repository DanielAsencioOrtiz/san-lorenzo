<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-bombas">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Nombre de la Bomba</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bombas as $key => $bomba)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $bomba->nombre_bomba }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar bomba')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarBomba-{{ $bomba->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar bomba')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $bomba->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar bomba')
                                <a href="#" class="btn btn-success restore" data-id="{{ $bomba->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
