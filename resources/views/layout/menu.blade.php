<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('home')}}">DESAFIO</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('home')}}">PC</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-address-book"></i><span>Agenda</span></a>
                <ul class="dropdown-menu">
                    @canany([config("desafio.role-default"),"Visualizar Telefones","Editar Telefone","Excluir Telefone"])
                        <li><a class="nav-link" href="{{route('client.index')}}">Clientes</a></li>
                    @endcanany
                    @can(config("desafio.role-default"))
                        <li><a class="nav-link" href="{{route('user.index')}}">Usuários</a></li>
                    @endcan
                    @can(config("desafio.role-default"))
                        <li><a class="nav-link" href="{{route('role.index')}}">Perfis</a></li>
                    @endcan
                    @canany([config("desafio.role-default"),"Visualizar Histórico","Visualizar Histórico Todos"])
                        <li><a class="nav-link" href="{{route('log.index')}}">Histórico</a></li>
                    @endcanany
                </ul>
            </li>


            @can(config('desafio.role-admin'))
            <li class="menu-header">Administrador</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users-cog"></i> <span>Administrador</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('admin-user.index')}}">Usuários</a></li>
                    <li><a class="nav-link" href="{{route('admin-role.index')}}">Perfis</a></li>
                    <li><a class="nav-link" href="{{route('log.index')}}">Histórico</a></li>
                </ul>
            </li>
            @endcan
        </ul>
    </aside>
</div>
