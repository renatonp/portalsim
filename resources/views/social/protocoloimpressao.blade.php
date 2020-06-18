<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Portal SIM - Autenticação de Certidão</title>

        <!--Custon CSS-->
        <link rel="stylesheet" href="{{ getcwd().'/css/certidao.css' }}">

        <!--Favicon-->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    </head>
    <body>

        <div class="header">
            <div class="div-logo">
                <img src="{{ getcwd().'/img/brasao.png'  }}" class="logo" alt="Prefeitura de Maricá">
            </div>
            <div class="titulo">
                ESTADO DO RIO DE JANEIRO<br>
                PREFEITURA MUNICIPAL DE MARICÁ<br>
                PAT - PROGRAMA DE AMPARO AO TRABALHADOR
            </div>
        </div>
            <div>
                <h1 class="titulo-autenticacao">
                    PROTOCOLO DE SOLICITAÇÃO<br>
                    DE BENFÍCIO
                </h1>

                <p class="dados-certidao">
                    A sua solicitação do benefício do PAT - PROGRAMA DE AMPARO AO TRABALHADOR foi realizada com sucesso.<br>
                </p>
                <br>
                <p class="texto-autenticacao">
                    Número do protocolo:<br>
                </p>

                <h2 class="status">{{$protocolo}}</h2>

                <p class="dados-certidao"><b>CPF: </b>{{$cpf}} </p>
                <p class="dados-certidao"><b>Nome: </b> {{$nome}}</p>
                <p class="dados-certidao"><b>Data de Emissão:</b> {{ \Carbon\Carbon::parse()->format('d/m/Y H:i:s') }}</p>
                <br>
                <br>
                <br>
                <p class="data-autenticacao">
                    
                    Maricá, {{ \Carbon\Carbon::parse(date("Y-m-d"))->locale("pt-BR")->format('d/m/Y') }}.
                </p>
            </div>


    </body>
</html>
