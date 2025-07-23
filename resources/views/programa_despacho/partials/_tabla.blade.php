<div class="table-responsive">
    <table class="table table-bordered" width="100%">
        <thead class="header-modal">
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Sede</th>
                <th>Total m³</th>
                <th>Hora Entrada del Personal</th>
                <th>Total de personal</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programas as $key => $programa)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $programa->fecha_programa }}</td>
                    <td>{{ $programa->sede->nombre_sede }}</td>
                    <td>{{ $programa->total_m3 }}</td>
                    <td>{{ \Carbon\Carbon::parse($programa->hora_entrada_personal)->format('h:i A') }}</td>
                    <td>
                        {{ $programa->personalDespacho->count() }}
                    </td>
                    <td class="text-center">
                        @if ($tipo == 'activo')
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarPrograma-{{ $programa->id }}"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm delete" data-id="{{ $programa->id }}"><i class="fa fa-times"></i></a>
                        @else
                            <a href="#" class="btn btn-success btn-sm restore" data-id="{{ $programa->id }}"><i class="fa fa-undo"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
