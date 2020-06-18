<aside class="dash-sidebar">
    <ul class="dash-sidebar-nav">
        @if (!Auth::user())
            <li class="title text-white text-center"><i class="fa fa-lock"></i> ENTRE NA SUA CONTA</li>
            <li>
                <a class="nav-link" data-toggle="modal" data-target="#modal_login" href="javascript:;">
                    <i class="fa fa-user"></i> FAÇA LOGIN
                </a>
            </li>
        @else
            <li class="title text-white text-center">BEM-VINDO</li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fa fa-user"></i> {{ Auth::user()->shortName() }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Sair do sistema
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endif
        
        <li class="title text-white text-center"><i class="fa fa-cogs"></i> SERVIÇOS</li>
        
        @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
            <li><a href="{{ route('servicos', 1) }}"><i class="fa fa-user"></i> CIDADÃO</a></li>
        @endif
        
        @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
            <li><a href="{{ route('servicos', 2) }}"><i class="fa fa-building"></i> EMPRESA</a></li>
        @endif

        <li class="title text-white text-center"><i class="fa fa-cogs"></i> OUTROS SERVIÇOS</li>
        
        <li>
            <a href="https://passaporteuniversitario.marica.rj.gov.br/">
                <i class="fa fa-book"></i> PASSAPORTE UNIVERSITÁRIO
            </a>
            
            @if( !Auth::user() )
                <a href="http://itbionline.marica.rj.gov.br" target="_BLANK">
                    <i class="fa fa-book"></i> ITBI ONLINE
                </a>
            @else
                <a href="{{ url('servicos/1/4' ) }}">
                    <i class="fa fa-book"></i> ITBI ONLINE
                </a>
            @endif
        </li>
        
        <li class="title text-white text-center"><i class="fa fa-phone-square"></i> NOSSOS CONTATOS</li>
        <li><a class="nav-link" href="{{ route('faleconosco') }}"><i class="fa fa-envelope"></i> FALE CONOSCO</a></li>
        
        <li>
            <a class="nav-link" href="{{ route('contato') }}">
                <i class="fa fa-phone"></i> CONTATO
            </a>
        </li>
    </ul>
</aside>

<nav class="navbar navbar-expand-md navbar-laravel fixed-top py-0 shadow-sm">
    <div class="container-fluid" style="margin-top: 0px !important; padding: 0px !important;">

        <!-- MENU SIDEBAR MOBILE -->
        <div class="menu-hamburguer mr-2">
            <label for="check"></label>
            <input type="checkbox" id="check" />

            <span class="icon-menu"></span>
            <span class="title-menu">SERVIÇOS</span>
        </div>

        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('img/logo_marica_b.png') }}" class="logo-desktop" />
            <img src="{{ asset('img/logo_sim.png') }}" class="logo-mobile d-none" />
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto menu">
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('outrosservicos') }}"><i class="fa fa-cogs"></i> Outros Serviços</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('faleconosco') }}"><i class="fa fa-envelope"></i> Fale Conosco</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contato') }}"><i class="fa fa-phone"></i> Contato</a>
                </li>

                <!-- Authentication Links -->
                @if (!Auth::user())
                    <li class="nav-item">
                        <a class="nav-link btn btn-white btn-login" href="javascript:;" data-toggle="modal" data-target="#modal_login">
                            <i class="fa fa-lock"></i> Login</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-user"></i> {{ Auth::user()->shortName() }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Sair do sistema
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li>
                    <img src="{{ asset('img/logo_sim.png') }}" style="margin-right: -16px !important" />
                </li>
            </ul>
        </div>
    </div>
</nav>