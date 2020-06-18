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

                <p class="dados-certidao"><b>Tipo: </b>Certidão de Numeração Predial Oficial</p>
                <p class="dados-certidao"><b>Data de Emissão:</b> {{ \Carbon\Carbon::parse($dados->aInformacaoCertidao[0]->p50_data)->format('d/m/Y') }}</p>
                @if($dados->aInformacaoCertidao[0]->p50_diasvalidade > 0)
                    <p class="dados-certidao"><b>Validade da Certidão: </b>{{ $dados->aInformacaoCertidao[0]->p50_diasvalidade }} dias</p>
                @endif
                <p class="dados-certidao"><b>Endereço: </b> {{ $dados->aInformacaoCertidao[0]->logradouro_s_num }},
                                                            {{ $dados->aInformacaoCertidao[0]->numeroporta }}, {{ $dados->aInformacaoCertidao[0]->descbairro }}<br>
                                                            {{ $dados->aInformacaoCertidao[0]->municipio }} - {{ $dados->aInformacaoCertidao[0]->uf }} - CEP: {{ $dados->aInformacaoCertidao[0]->cep }} </p>

                <p class="data-autenticacao">
                    Maricá, {{ \Carbon\Carbon::parse(date("Y-m-d"))->locale("pt-BR")->format('d/m/Y')  }}.
                </p>
            </div>


    </body>
</html>
