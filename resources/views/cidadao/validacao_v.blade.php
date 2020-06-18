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
                SECRETARIA DE PLANEJAMENTO, ORÇAMENTO E GESTÃO
            </div>
        </div>
            <div>
                <h1 class="titulo-autenticacao">AUTENTICAÇÃO DE CERTIDÃO</h1>

                <p class="texto-autenticacao">
                    Declaramos para os devidos fins que a certidão de código:<br>
                    <b>{{$numero}}</b>, é<br>
                </p>
                <h2 class="status">VÁLIDA</h2>

                <p class="dados-certidao"><b>Tipo: </b>Declaração de Valor Venal</p>
                <p class="dados-certidao"><b>Data de Emissão:</b> {{ \Carbon\Carbon::parse($dados->aInformacaoCertidao[0]->p50_data)->format('d/m/Y') }}</p>
                <p class="dados-certidao"><b>Matrícula do Imóvel: </b>{{ $dados->aInformacaoCertidao[0]->matricula_imovel }}</p>
                <p class="dados-certidao"><b>Valor venal do Imóvel: </b>R$ {{$dados->aInformacaoCertidao[0]->venal_total}}</p>

                <p class="data-autenticacao">
                    
                    Maricá, {{ \Carbon\Carbon::parse(date("Y-m-d"))->locale("pt-BR")->format('d/m/Y') }}.
                </p>
            </div>


    </body>
</html>
