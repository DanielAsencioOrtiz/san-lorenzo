 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary2 sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon">
            <span><img width="150px" src="{{asset('img/logo.png')}}" alt=""></span>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading 
    <div class="sidebar-heading">
        MENÚ
    </div>
-->

    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->is('tipo-documento*','sede*') ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapsePages2"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Configuración General</span>
        </a>
        <div id="collapsePages2" class="collapse {{ request()->is('tipo-documento*','sede*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('sede.index') ? 'active' : '' }}" href="{{route('sede.index')}}">Sedes</a>
                <a class="collapse-item {{ request()->routeIs('tipo-documento.index') ? 'active' : '' }}" href="{{route('tipo-documento.index')}}">Tipo de Documento</a>
                <a class="collapse-item {{ request()->routeIs('canteras.index') ? 'active' : '' }}" href="{{route('canteras.index')}}">Cantera</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->is('tipo_concretos*','metodo_colocacions*','bombas*', 'tipo_cementos*', 'estructuras*','obras*','resistencias*','piedras*','slams*') ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-truck-loading"></i>
            <span>Configuración Despacho</span>
        </a>
        <div id="collapsePages" class="collapse {{ request()->is('tipo_concretos*','metodo_colocacions*','bombas*', 'tipo_cementos*', 'estructuras*','obras*','resistencias*','piedras*','slams*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can ('ver tipo concreto')
                    <a class="collapse-item {{ request()->routeIs('tipo_concretos.index') ? 'active' : '' }}" href="{{route('tipo_concretos.index')}}">Tipo de Concreto</a>
                @endcan
                @can ('ver metodo colocacion')
                    <a class="collapse-item {{ request()->routeIs('metodo_colocacions.index') ? 'active' : '' }}" href="{{route('metodo_colocacions.index')}}">Metodo de Colocación</a>
                @endcan
                @can ('ver resistencia')
                    <a class="collapse-item {{ request()->routeIs('resistencias.index') ? 'active' : '' }}" href="{{route('resistencias.index')}}">Resistencias</a>
                @endcan
                @can ('ver slam')
                    <a class="collapse-item {{ request()->routeIs('slams.index') ? 'active' : '' }}" href="{{route('slams.index')}}">Slams</a>
                @endcan
                @can ('ver piedra')
                    <a class="collapse-item {{ request()->routeIs('piedras.index') ? 'active' : '' }}" href="{{route('piedras.index')}}">Piedras</a>
                @endcan
                
                @can ('ver tipo cemento')
                <a class="collapse-item {{ request()->routeIs('tipo_cementos.index') ? 'active' : '' }}" href="{{route('tipo_cementos.index')}}">Tipo de Cemento</a>
                @endcan
                @can ('ver estructura')
                <a class="collapse-item {{ request()->routeIs('estructuras.index') ? 'active' : '' }}" href="{{route('estructuras.index')}}">Estructuras</a>
                @endcan
                @can ('ver bomba')
                    <a class="collapse-item {{ request()->routeIs('bombas.index') ? 'active' : '' }}" href="{{route('bombas.index')}}">Bombas</a>
                @endcan
                @can ('ver obra')
                <a class="collapse-item {{ request()->routeIs('obras.index') ? 'active' : '' }}" href="{{route('obras.index')}}">Obras</a>
                @endcan
            </div>
        </div>
    </li>

    @role('admin')
    <li class="nav-item {{ request()->routeIs('roles.index*') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('roles.index')}}">
            <i class="fas fa-user-shield"></i>
            <span>Roles</span></a>
    </li>
    @endrole

    @can('ver usuarios')
    <li class="nav-item {{ request()->routeIs('usuarios.index') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('usuarios.index')}}">
            <i class="fas fa-users"></i>
            <span>Usuarios</span></a>
    </li>
    @endcan

    @can('ver personal')
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->is('tipo-personal*','personal*') ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapsePages3"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-id-badge"></i>
            <span>Personal</span>
        </a>
        <div id="collapsePages3" class="collapse {{ request()->is('tipo-personal*','personal*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('tipo-personal.index') ? 'active' : '' }}" href="{{route('tipo-personal.index')}}">Tipo de Personal</a>
                <a class="collapse-item {{ request()->routeIs('personal.index') ? 'active' : '' }}" href="{{route('personal.index')}}">Lista de Personal</a>
            </div>
        </div>
    </li>
    @endcan

    @can('ver cliente')
    <li class="nav-item {{ request()->routeIs('clientes.index') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('clientes.index')}}">
            <i class="fas fa-handshake"></i>
            <span>Clientes</span></a>
    </li>
    @endcan

    @can('ver maquinaria')
    <li class="nav-item {{ request()->routeIs('movil.index') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('movil.index')}}">
            <i class="fas fa-shuttle-van"></i>
            <span>Maquinaria</span></a>
    </li>
    @endcan


    @can('ver control')
    <li class="nav-item">
        <a class="nav-link " href="#">
            <i class="fas fa-clipboard-check"></i>
            <span>Control de Despacho</span></a>
    </li>
    @endcan

    @can('ver programa')
        <li class="nav-item">
        <a class="nav-link " href="#">
            <i class="fas fa-calendar-check"></i>
            <span>Programa de Despacho</span></a>
    </li>
    @endcan

    @can('ver diseño de concreto')
        <li class="nav-item">
        <a class="nav-link " href="#">
            <i class="fas fa-cubes"></i>
            <span>Diseño de concreto</span></a>
    </li>
    @endcan

    @can('ver boletas')
    <li class="nav-item">
        <a class="nav-link " href="#">
            <i class="fas fa-file-invoice"></i>
            <span>Boletas de Despacho</span></a>
    </li>
    @endcan

    @can('ver guias de remision')
        <li class="nav-item">
        <a class="nav-link " href="#">
            <i class="fas fa-file-signature"></i>
            <span>Guía de Remisión</span></a>
    </li>
    @endcan


    

    @role('Estudiante')
        <li class="nav-item {{ request()->routeIs('panel.vista.estudiante') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('panel.vista.estudiante')}}">
                <i class="fas fa-table"></i>
                <span>Panel de cursos</span></a>
        </li>
        <li class="nav-item {{ request()->routeIs('cursos.matriculados.estudiante') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('cursos.matriculados.estudiante')}}">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Historial de Pagos</span></a>
        </li>
        <li class="nav-item {{ request()->routeIs('notas.estudiante') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('notas.estudiante')}}">
                <i class="fas fa-book"></i>
                <span>Historial de Notas</span></a>
        </li>
    @endrole

    @role('Docente')
    <li class="nav-item {{ request()->routeIs('cursos.matriculados.docente') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('cursos.matriculados.docente')}}">
            <i class="fas fa-book"></i>
            <span>Registro de Notas</span></a>
    </li>
    @endrole

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
