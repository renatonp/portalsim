<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Prefeitura de Maricá</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Serviço Integrado Municipal" />
    <meta name="author" content="Mizael Pardinho" />

    <!-- css -->
    <style>
        div.g-recaptcha {
          margin: 0 auto;
          width: 304px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif:400,400italic,700|Open+Sans:300,400,600,700" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jcarousel.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/flexslider.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('skins/blue.css') }}" rel="stylesheet" />
    <link href="{{ asset('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('ico/apple-touch-icon-144-precomposed.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('ico/apple-touch-icon-114-precomposed.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('ico/apple-touch-icon-72-precomposed.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('ico/apple-touch-icon-57-precomposed.png') }}" />
    {{-- <link rel="shortcut icon" href="{{ asset('favicon.png') }}" /> --}}
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

</head>

<body>
    <div class="lateral-menu hide" id="menu_lateral">
        <div class="corpo-menu-sim">
            <div class="topo-servicos-sim alignright">
            </div>
            {{-- <br> --}}
            {{-- <div class="aligncenter">
                <img src="{{ asset('img/logo_marica.png') }}" alt="Prefeitura de Maricá" class="logo_menu_sim" />
            </div>
            <br> --}}
            <div class="titulo-menu-sim">
                SERVIÇOS
            </div>
            <ul class="menu-servicos">
                @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
                <li>
                    <a href="{{ route('servicos', 1 ) }}" class="btn btn-blue btn-menu-sim">CIDADÃO</a>
                </li>
                @endif
                @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
                <li>
                    <a href="{{ route('servicos', 2 ) }}" class="btn btn-blue btn-menu-sim">EMPRESA</a>
                </li>
                @endif
            </ul>
            <div class="titulo-menu-sim">
                OUTROS SERVIÇOS
            </div>
            <ul class="menu-servicos">
                <li>
                    <a href="http://passaporteuniversitario.marica.rj.gov.br/"  target="_BLANK" class="btn btn-blue btn-menu-sim">PASSAPORTE UNIVERSITÁRIO</a>
                </li>
                <li>
                    @if( !Auth::user())
                    <a href="http://itbionline.marica.rj.gov.br" target="_BLANK" class="btn btn-blue btn-menu-sim">
                    @else
                    <a href="{{ url('servicos/1/4' ) }}" class="btn btn-blue btn-menu-sim">
                    @endif
                        ITBI ON-LINE
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('servicos', 5 ) }}" class="btn btn-blue btn-menu-sim">SERVIDOR</a>
                </li> --}}
            </ul>
        </div>
    </div>
    <div class="lateral-direita" id="lateral-direita">
        <div id="wrapper">
            <!-- Inicio header -->
            <header class="bg_sim" style="border-bottom: 6px solid #252525;">
                {{-- <div class="container "> --}}
                <div class="row nomargin">
                    <div class="span1 logo-principal">
                        <a href="javascript:void(0)" class="menusim-topo" id="btn_menu">
                            <div class="menusim aligncenter" id="abrir_menu">
                                <i class="fa fa-navicon fa-3x"></i><br>
                                SERVIÇOS
                            </div>
                            <div class="menusim aligncenter hide" id="fechar_menu">
                                <i class="fa fa-close fa-3x"></i><br>
                            </div>
                        </a>
                    </div>
                    <div class="span5" style="margin-left: 12px;">
                        <div>
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('img/logo_marica_sim.png') }}" alt="Prefeitura de Maricá"
                                    style="height: 89px; width: 529px;" />
                            </a>
                        </div>
                    </div>
                    <div style="padding-right: 15px;">
                        <div class="box-cpf">
                            @guest
                            <div class="control-group">
                                <form class="form-horizontal topo-pagina" method="POST"
                                    action="{{ route('valida_cpf_login') }}" id="frmCpf">
                                    @csrf
                                    <input type="text" id="cpf_login" name="cpf_login" placeholder="CPF/CNPJ">
                                    <a id="valida_cpf_login" href="javascript:void(0);"
                                        class="btn btn-theme btn-rounded e_wiggle">Login
                                    </a>
                                </form>
                            </div>
                            @else
                            <div class="control-group">
                                {{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', Auth::user()->name))) }}
                                <a id="logout" href="javascript:void(0);" class="btn btn-theme btn-rounded e_wiggle">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                            @endguest
                        </div>
                        <div class="navbar navbar-static-top">
                            <div class="navigation">
                                <nav>
                                    <ul class="nav topnav">
                                        @if(!empty($pagina))
                                            @if ($pagina == "OutrosServicos")
                                                <li class="active">
                                            @else
                                                <li>
                                            @endif
                                        @else
                                            <li>
                                        @endif
                                            <a href="{{ route('outrosservicos') }}" data-toggle="modal">OUTROS SERVIÇOS</a>
                                        </li>

                                        {{-- Só exibe a opção CONSULTA de estiver logado --}}
                                        @auth
                                        @if(!empty($pagina))
                                        @if ($pagina == "Consulta")
                                        <li class="active">
                                            @else
                                        <li>
                                            @endif
                                            @else
                                        <li>
                                            @endif
                                            <a href="{{ route('acompanhamento') }}">CONSULTA </a>
                                        </li>
                                        @endauth

                                        @if(!empty($pagina))
                                            @if ($pagina == "FaleConosco")
                                                <li class="active">
                                            @else
                                                <li>
                                            @endif
                                        @else
                                            <li>
                                        @endif
                                            <a href="{{ route('faleconosco') }}">FALE CONOSCO </a>
                                        </li>

                                        @if(!empty($pagina))
                                        @if ($pagina == "Contato")
                                        <li class="active">
                                            @else
                                        <li>
                                            @endif
                                            @else
                                        <li>
                                            @endif
                                            <a href="{{ route('contato') }}" data-toggle="modal">CONTATO </a>
                                        </li>
                                        {{--  @auth
                                        @if(!empty($pagina))
                                            @if ($pagina == "perfil")
                                                <li class="active">
                                            @else
                                                <li>
                                            @endif
                                        @else
                                            <li>
                                        @endif
                                            <a href="{{ route('perfil') }}">CADASTRO DO CIDADÃO</a>
                                        </li>
                                        @endauth --}}
                                    </ul>
                                </nav>
                            </div>

                            <!-- end navigation -->
                        </div>
                    </div>
                </div>
            </header>
            <!-- end header -->
            @yield('content')



            <!-- Rodapé -->
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="span2">
                            <div class="widget">
                            </div>
                        </div>
                        <div class="span4">
                            <div class="widget">
                                <img src="{{ asset('img/logo_marica_b.png') }}" alt="Prefeitura de Maricá"
                                    class="logo" />
                                <br>
                                <br>
                                <address>
                                    <strong>SIM Maricá</strong><br>
                                    Rua Álvares de Castro, nº 272 - Centro - Maricá - RJ
                                </address>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="widget">
                                <h5 class="widgetheading">Fale Conosco</h5>
                                <p>
                                    <i class="fa fa-phone"></i> (21) 3731-2067 | (21) 2637-2053 | (21) 2637-2054 <br>
                                    <i class="fa fa-phone"></i> (21) 2637-2055 | (21) 2637-3706 | (21) 2637-4208 <br>
                                    <i class="fa fa-phone"></i> Inoã: (21)2637-2052 / ramal 1252<br>
                                    <i class="fa fa-phone"></i> Itaipuaçu: (21)2638-4982<br>
                                    {{-- <i class="fa fa-envelope-o"></i> --}}
                                    {{-- <a href="mailto:itbimarica@gmail.com">itbimarica@gmail.com</a> <br> --}}
                                    <i class="fa fa-globe"></i>
                                    <a href="http://www.marica.rj.gov.br" target="_blank">www.marica.rj.gov.br</a>
                                </p>
                            </div>
                            {{--  </div>
                        <div class="span3 alignleft">  --}}
                            <div class="widget">
                                <ul class="social-network">
                                    <li>
                                        <a href="https://www.facebook.com/prefeiturademarica/" target="_blank"
                                            data-placement="bottom" title="Facebook">
                                            <span class="fa-stack fa-lg e_tada">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/MaricaRJ" target="_blank" data-placement="bottom"
                                            title="Twitter">
                                            <span class="fa-stack fa-lg e_tada">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.youtube.com/user/prefeiturademarica1" target="_blank"
                                            data-placement="bottom" title="Youtube">
                                            <span class="fa-stack fa-lg e_tada">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-youtube-play fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <div id="faleconosco" class="modal styled hide fade" tabindex="-1" role="dialog" aria-labelledby="mySignupModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="mySignupModalLabel">Fale <strong>Conosco</strong></h4>
        </div>
        <div class="modal-body">
            {{-- <form action="{{ route('enviarmensagem') }}" method="post" role="form" class="contactForm">
                @csrf
            </form> --}}
            <form id="contactForm" action="{{ route('enviarmensagem') }}" method="post" role="form" class="contactForm">
                @csrf
                <div id="sendmessage">Sua mensagem foi enviada. Obrigado!</div>
                <div id="errormessage"></div>

                <div class="form-group">
                    <input maxlength="40" type="text" name="name" class="form-input" id="nameFC" placeholder="Seu nome" />
                    <div class="validation"></div>
                </div>
                <div class="form-group">
                    <input maxlength="100" type="email" class="form-input" name="email" id="emailFC" placeholder="Seu email" />
                    <div class="validation"></div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-input" name="phone" id="phoneFC" placeholder="Telefone" />
                    <div class="validation"></div>
                </div>
                <div class="form-group">
                    <select id="solicitacao" name="solicitacao" class="servico-opcoes">
                        <option value="">Informe o Tipo de Solicitação</option>

                        @inject('servicos_fc', 'App\Services\ServicosService')

                        @foreach ($servicos_fc->servicos_fc() as $servico)
                        <option value="{{$servico->servico}}">{{$servico->servico}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select id="assunto" name="assunto" class="servico-opcoes">
                        <option value="Elogio">Elogio</option>
                        <option value="Dúvida">Dúvida</option>
                        <option value="Reclamação">Reclamação</option>
                    </select>
                </div>
                <div class="margintop10 form-group">
                    <textarea class="form-input" id="mensagem" name="message" rows="6" data-rule="required" data-msg="Por favor, escreva a sua mensagem" placeholder="Por favor, escreva a sua mensagem"></textarea>
                    <div class="validation"></div>

                    <p class="text-center">
                        <button id="btn_contato" class="btn btn-large btn-theme margintop10" type="button">Enviar Mensagem</button>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <div class="modal styled hide fade" id="buscaCep" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-body">
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                        <span>Aguarde...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal styled hide" id="mdlAguarde" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-body">
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                        <span>Aguarde...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('erroServico'))
    @if (session('erroServico') == 1)

    <div id="erroServico" class="modal styled hide fade" tabindex="-1" role="dialog"
        aria-labelledby="mySignupModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="mySignupModalLabel">SERVIÇOS</h4>
        </div>
        <div class="modal-body">

            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Erro!</strong> Houve um erro ao tentar acessar os serviços. Tente novamente em alguns intantes.
            </div>

            <p class="text-center">
                <button class="btn btn-large btn-theme margintop10" type="button" data-dismiss="modal">Fechar</button>
            </p>
        </div>
    </div>

    @endif
    @endif

    @if (isset($mensagem))
    @if($mensagem=="respostafaleconosco")
    <div id="respostafaleconosco" class="modal styled show fade" tabindex="-1" role="dialog" aria-labelledby="LabelFaleConosco">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="LabelFaleConosco">Fale <strong>Conosco</strong></h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-success">
                <strong>Sucesso!</strong> Enviamos a sua mensagem com sucesso.<br> Em breve retornaremos o contato.
            </div>
        </div>
        <div class="modal-footer">
            <p class="text-center">
                <button class="btn btn-large btn-theme margintop10" type="button" data-dismiss="modal">Fechar</button>
            </p>
        </div>
    </div>
    @endif
    @endif

    @if(session("mensagem")=="errofaleconosco")
    <div id="errofaleconosco" class="modal styled show fade" tabindex="-1" role="dialog" aria-labelledby="LabelFaleConosco">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="LabelFaleConosco">Fale <strong>Conosco</strong></h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-error">
                <strong>Erro! </strong>Não foi possível enviar a sua mensagem.<br> Tente novamente em alguns instantes.
            </div>
        </div>
        <div class="modal-footer">
            <p class="text-center">
                <button class="btn btn-large btn-theme margintop10" type="button" data-dismiss="modal">Fechar</button>
            </p>
        </div>
    </div>
    @endif

    <div id="abrirITBI" class="modal styled hide fade" tabindex="-1" role="dialog" aria-labelledby="mySignupModalLabel"
        aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="mySignupModalLabel"><strong>ITBI</strong> Online</h4>
        </div>
        <div class="modal-body">
            <p>
                Para solicitar o lançamento do ITBI, siga os passos abaixo:
            </p>
            <p>
                1. Faça o download do FORMULÁRIO DE SOLICITAÇÃO DE ITBI,
                preencha preferencialmente de forma eletrônica e anexe-o na solicitação do processo.<br>

            </p>
            <p class="text-center">
                <a href="{{  url('fileDownload/1') }}" class="btn default">
                    <i class="icon-download-alt"></i> FORMULÁRIO DE SOLICITAÇÃO DE ITBI
                </a>
            </p>
            <p>&nbsp;</p>
            <p>
                2. Veja as observações e os documentos necessários para a solicitação do ITBI <br>
            </p>
            <p class="text-center">
                <a href="{{  url('fileDownload/2') }}" class="btn default">
                    <i class="icon-download-alt"></i> DOCUMENTOS PARA SOLICITAÇÃO DE ITBI
                </a>
            </p>
            <p>&nbsp;</p>
            <div class="margintop10 form-group">
                <div class="row nomargin">
                    <div class="span2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button data-dismiss="modal" class="btn btn-large btn-warning margintop10" type="button">
                            CANCELAR
                        </button>
                    </div>
                    <div class="span3" style="text-align:right;">
                        <a href="{{ route('itbionline') }}">
                            <button id="btn_contato" class="btn btn-large btn-theme margintop10" type="button">
                                CONTINUAR
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pesquisa" class="modal styled hide" tabindex="-1" role="dialog" aria-labelledby="mySignupModalLabel"
        aria-hidden="true" style="width: 70%; margin-left: -500px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="mySignupModalLabel">Pesquisa</h4>
        </div>
        <div class="modal-body">
            <div class="margintop10 form-group">
                <table id="pesquisaTaxa" class="display">
                    <thead>
                        <tr>
                            <th width='10%'>Matrícula</th>
                            <th width='10%'>Tipo</th>
                            <th width='10%'>Bairro</th>
                            <th width='20%'>Logradouro</th>
                            <th width='5%'>Número</th>
                            <th width='10%'>Compl</th>
                            <th width='25%'>Planta/Quadra/Lote</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <p class="text-left">
                    <a href="#pesquisa" data-toggle="modal">
                        <button class="btn btn-theme margintop10 e_wiggle" type="button">Cancelar</button>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div id="ListaItbi" class="modal styled hide" tabindex="-1" role="dialog" aria-labelledby="mySignupModalLabel"
        aria-hidden="true" style="width: 70%; margin-left: -500px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="mySignupModalLabel">Pesquisa</h4>
        </div>
        <div class="modal-body">
            <div class="margintop10 form-group">
                <table id="ListagemItbi" class="display">
                    <thead>
                        <tr>
                            <th width='45%'>Guia</th>
                            <th width='45%'>Data</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <p class="text-left">
                    <a href="#ListaItbi" data-toggle="modal">
                        <button class="btn btn-theme margintop10 e_wiggle" type="button">Cancelar</button>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div id="pesquisaInscricaoTaxa" class="modal styled hide" tabindex="-1" role="dialog"
        aria-labelledby="mySignupModalLabel" aria-hidden="true" style="width: 70%; margin-left: -500px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="mySignupModalLabel">Pesquisa</h4>
        </div>
        <div class="modal-body">
            <div class="margintop10 form-group">
                <table id="pesquisaInscricaoTaxaTbl" class="display" >
                    <thead>
                        <tr>
                            <th>Inscrição</th>
                            <th>Nome</th>
                            <th>Endereço</th>
                            <th>Número</th>
                            <th>Complemento</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <p class="text-left">
                    <a href="#pesquisaInscricaoTaxa" data-toggle="modal">
                        <button class="btn btn-theme margintop10 e_wiggle" type="button">Cancelar</button>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div id="pesquisaCid10" class="modal styled hide" tabindex="-1" role="dialog"
        aria-labelledby="mySignupModalLabel" aria-hidden="true" style="width: 70%; margin-left: -500px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="mySignupModalLabel">Pesquisa</h4>
        </div>
        <div class="modal-body">
            <div class="margintop10 form-group">
                <table id="pesquisaCid10Tbl" class="display" >
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Descrição</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <p class="text-left">
                    <a href="#pesquisaCid10" data-toggle="modal">
                        <button class="btn btn-theme margintop10 e_wiggle" type="button">Cancelar</button>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div id="pesquisaITBI" class="modal styled hide" tabindex="-1" role="dialog"
        aria-labelledby="mySignupModalLabel" aria-hidden="true" style="width: 70%; margin-left: -500px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="mySignupModalLabel">Pesquisa</h4>
        </div>
        <div class="modal-body">
            <div class="margintop10 form-group">
                <table id="pesquisaITBITbl" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="30%">Inscrição</th>
                            <th width="30%">Guia</th>
                            <th width="30%">Data</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <p class="text-left">
                    <a href="#pesquisaITBI" data-toggle="modal">
                        <button class="btn btn-theme margintop10 e_wiggle" type="button">Cancelar</button>
                    </a>
                </p>
            </div>
        </div>
    </div>



    <!-- javascript
        ================================================== -->

    <script src="{{ asset('js/jcarousel/jquery.jcarousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox-media.js') }}"></script>
    <script src="{{ asset('js/google-code-prettify/prettify.js') }}"></script>
    <script src="{{ asset('js/portfolio/jquery.quicksand.js') }}"></script>
    <script src="{{ asset('js/portfolio/setting.js') }}"></script>
    <script src="{{ asset('js/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('js/jquery.nivo.slider.js') }}"></script>
    <script src="{{ asset('js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('js/jquery.ba-cond.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slitslider.js') }}"></script>
    <script src="{{ asset('js/animate.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

    <!-- Template Custom JavaScript File -->
    <script src="{{ asset('js/custom.js') }}"></script>
    @yield('post-script')
    <script>

        @if (isset($mensagem))
            @if($mensagem=="respostafaleconosco")
                jQuery(document).ready(function($) {
                    $("#respostafaleconosco").modal("show");
                });
            @endif

        @endif

        @if(session("mensagem")=="errofaleconosco")
            jQuery(document).ready(function($) {
                $("#errofaleconosco").modal("show");
            });
        @endif

        @if (session('erroServico'))
            @if (session('erroServico') == 1)
                jQuery(document).ready(function($) {
                    $("#erroServico").modal("show");
                });
            @endif
        @endif

    </script>

</body>

</html>
