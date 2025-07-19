<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0" id="tabla-traducida-{{$tabla}}">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Serie</th>
                <th>Descripción</th>
                <th>Modelo</th>
                <th>Placa</th>
                <th>Forms</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movils as $key => $movil)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $movil->serie }}</td>
                    <td>{{ $movil->descripcion }}</td>
                    <td>{{ $movil->modelo }}</td>
                    <td>{{ $movil->placa }}</td>
                    <td>{{ $movil->forms }}</td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar maquinaria')
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editarMovil-{{ $movil->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar maquinaria')
                                <a href="#" class="btn btn-danger delete" data-id="{{ $movil->id }}"><i class="fa fa-times"></i></a>
                            @endcan
                        @else
                            @can('restaurar maquinaria')
                                <a href="#" class="btn btn-success restore" data-id="{{ $movil->id }}"><i class="fa fa-undo"></i></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
