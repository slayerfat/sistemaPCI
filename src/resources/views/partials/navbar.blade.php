<nav class="navbar navbar-default" id="main-navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse-1">
                <span class="sr-only">Cambiar Navegacion</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                sistemaPCI
            </a>
        </div>

        <div class="collapse navbar-collapse" id="main-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Productos
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        @unless(Auth::guest())
                            <li>
                                <a href="#">Crear</a>
                            </li>
                        @endunless
                        <li>
                            <a href="#">Consultar</a>
                        </li>
                    </ul>
                </li>
                <li>
                    Pedidos
                </li>
                     Notas
                <li>
                </li>
            @unless (Auth::guest())
                @if (Auth::user()->isAdmin())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Mant.
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#">Crear Usuario</a>
                                    <a href="#">Consultar Usuarios</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">Crear Perfil</a>
                                    <a href="#">Consultar Perfiles</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">Crear Perfil</a>
                                    <a href="#">Consultar Perfiles</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endunless
            </ul>

            <ul class="nav navbar-nav navbar-right" id="main-navbar-user">
                @if (Auth::guest())
                    <li><a href="/auth/login">Entrar</a></li>
                    <li><a href="/auth/register">Registrarse</a></li>
                @else
                    <p class="navbar-text">Hola {{Auth::user()->name}}!</p>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                {!! link_to_route('users.show', 'Perfil', Auth::user()->name) !!}
                            </li>
                            <li><a href="/auth/logout">Salir</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
