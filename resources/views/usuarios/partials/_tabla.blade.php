<div class="table-responsive">
    <table class="table table-bordered" width="100%" id="tabla-traducida-{{ $tabla }}" cellspacing="0">
        <thead class="header-modal">
            <tr>
                <th class="text-center">#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>DNI</th>
                <th>Roles</th>
                <td>Sede</td>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $key => $u)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->dni }}</td>
                    <td>
                        @foreach ($u->roles as $r)
                            <span class="badge badge-info">{{ $r->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if (isset($u->sede))
                            {{ $u->sede->nombre_sede }}
                        @else
                            <span class="text-muted">TODAS</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            @can('editar usuarios')
                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#editarUsuario-{{ $u->id }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('eliminar usuarios')
                                <a href="#" class="btn btn-danger btn-sm delete-user" data-id="{{ $u->id }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endcan
                        @else
                            @can('restaurar usuarios')
                                <a href="#" class="btn btn-success btn-sm restore-user" data-id="{{ $u->id }}">
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
