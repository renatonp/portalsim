<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Prefeitura de Maricá | #MaisPertoDeVocê</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.3.3.1.min.js') }}" ></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/javascript_jquery.maskedinput.js') }}" defer></script>
    <script src="{{ asset('js/jquery.flexslider-min.js') }}" defer></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('js/slide.js') }}" defer></script>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" >
    <link rel="stylesheet" href="{{ asset('css/slide.css') }}" >
    <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" >

</head>
<body>
    {{-- <div class="container"> --}}
    <div id="app">
        <div class="titulo row">
            {{-- <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/logo_marica.png') }}" alt="Prefeitura de Maricá" class="logo" />
            </a> --}}
            <div class="col-md-6 justify-content-left">
                <img src="{{ asset('img/logo_l.jpeg') }}" alt="Prefeitura de Maricá" class="logo" />
            </div>
            <div class="col-md-6 justify-content-right logo-direita">
                <img src="{{ asset('img/logo_r.jpeg') }}" alt="Prefeitura de Maricá" class="logo" />
            </div>

        </div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel navbar-menu">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="{{  url('/') }}">{{ __('PRINCIPAL') }}</a>
                    </li>     

                    <li class="nav-item ">
                        <a class="nav-link"  href="{{ route('servicos') }}">{{ __('SERVIÇOS') }}</a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('acompanhamento') }}">{{ __('CONSULTA') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faleconosco') }}">{{ __('CONTATO') }}</a>
                    </li>
                </ul>
                
            </div>
            @guest
                    <form method="POST" action="{{ route('valida_cpf_login') }}" id="frmCpf">
                        @csrf
                        <div class="">
                            <input id="cpf_login" type="text" name="cpf_login" value="" placeholder="CPF" class="input-box-login-cpf">
                            <button type="button" name="valida_cpf_login" id="valida_cpf_login" class="btn btn-box-login-cpf">
                                {{ __('OK') }}
                            </button>
                        </div>
                    </form>

                    <a href="javascript:void(0);" id="btnCad">
                        <button type="button" class="btn btn-box-login-cpf bnt-cadastro">
                            {{ __('Cadastre-se') }}
                        </button>
                    </a>
            @else
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home') }}"
                                onclick="event.preventDefault();">
                                {{ __('Perfil') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>                
                </ul>                
            @endguest
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        <div class="navbar-rodape">
            <table class="endereco">
                <tr>
                    <td class="endereco-esquerda">
                        Prefeitura de Maricá - <a href="http://www.marica.rj.gov.br" target="_BLANK">www.marica.rj.gov.br</a> - Rua Álvares de Castro, nº 346<br>
                        Centro - Maricá - RJ - CEP: 24900-880
                    </td>
                    <td class="endereco-direita">
                        Telefones: | 3731-2067 | 2637-2053 | 2637-2054 |<br> | 2637-2055 | 2637-3706 | 2637-4208 |
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){

            $("#valida_cpf_login").click(function(){
                if ($("#cpf_login").val() !== "") {
                    if(validarCPF($("#cpf_login").val())){
                        $("#frmCpf").submit();
                    }
                    else{
                        alert("CPF Inválido!  Inoforme o corretamente o número do seu CPF");
                    }
                }
                else{
                    alert("Por favor, informe o número do seu CPF.");
                }
            });

            $("#btnCad").click(function(){
                if ($("#cpf_login").val() !== "") {
                    if(validarCPF($("#cpf_login").val())){
                        var url = "{{URL::to('valida_cpf_cadastro/:cpf')}}"
                        url = url.replace( ':cpf', $("#cpf_login").val() );
                        window.location.href = url;
                    }
                    else{
                        alert("CPF Inválido!  Inoforme o corretamente o número do seu CPF");
                    }
                }
                else{
                    alert("Por favor, informe o número do seu CPF.");
                }
            });

            if (typeof($("#cpf_login")) !== "undefined") {
                $("#cpf_login").mask("999.999.999-99");
            }
            if (typeof($("#cpf")) !== "undefined") {
                $("#cpf").mask("999.999.999-99");
            }   
            if (typeof($("#avisos")) !== "undefined") {
                $('#avisos').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                    }
                });


                var table = $('#avisos').DataTable();
 
                $('#avisos tbody').on( 'click', 'tr', function () {
                    if ( $(this).hasClass('selected') ) {
                        // $(this).removeClass('selected');
                    }
                    else {
                        var linha = table.row( this ).data();
                        var url = "{{URL::to('avisoEdit/:id')}}";

                        url = url.replace(':id', linha[0]);
                        window.location.href = url;
                    }
                } );
            }

            if (typeof($("#acompanhamento")) !== "undefined") {
                $('#acompanhamento').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                    }
                });
            }

            $('.flexslider').flexslider({
                animation: "fade"
            });
            
            $(function() {
                $('.show_menu').click(function(){
                        $('.menu').fadeIn();
                        $('.show_menu').fadeOut();
                        $('.hide_menu').fadeIn();
                });
                $('.hide_menu').click(function(){
                        $('.menu').fadeOut();
                        $('.show_menu').fadeIn();
                        $('.hide_menu').fadeOut();
                });
            });


            function validarCPF(cpf) {	
                cpf = cpf.replace(/[^\d]+/g,'');	
                if(cpf == '') return false;	
                // Elimina CPFs invalidos conhecidos	
                if (cpf.length != 11 || 
                    cpf == "00000000000" || 
                    cpf == "11111111111" || 
                    cpf == "22222222222" || 
                    cpf == "33333333333" || 
                    cpf == "44444444444" || 
                    cpf == "55555555555" || 
                    cpf == "66666666666" || 
                    cpf == "77777777777" || 
                    cpf == "88888888888" || 
                    cpf == "99999999999")
                        return false;		
                // Valida 1o digito	
                add = 0;	
                for (i=0; i < 9; i ++)		
                    add += parseInt(cpf.charAt(i)) * (10 - i);	
                    rev = 11 - (add % 11);	
                    if (rev == 10 || rev == 11)		
                        rev = 0;	
                    if (rev != parseInt(cpf.charAt(9)))		
                        return false;		
                // Valida 2o digito	
                add = 0;	
                for (i = 0; i < 10; i ++)		
                    add += parseInt(cpf.charAt(i)) * (11 - i);	
                rev = 11 - (add % 11);	
                if (rev == 10 || rev == 11)	
                    rev = 0;	
                if (rev != parseInt(cpf.charAt(10)))
                    return false;		
                return true;   
            }
        });

        
    </script>
    
    @yield('post-script')
<br>
<br>
<br>
<br>
<br>
</body>
</html>
