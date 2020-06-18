@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>CONSULTA DE BENEFÍCIO</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">CONSULTA DE BENEFÍCIO</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="span12">

                <div class="row registro-fase-topo">
                    <div class="span2">
                        Chamado: <b>{{ $processo->Chamado }}</b>
                    </div>
                    <div class="span2">
                        Data: <b>{{ date('d/m/Y', strtotime($processo->abertura)) }}</b>
                    </div>
                    <div class="span4">
                        Serviço: <b>{{ $processo->Serviço }}</b>
                    </div>
                    <div class="span4">
                        Responsável: <b>{{ $processo->responsavel_consulta }}</b><br>
                    </div>
                </div>
                <div class="justfy-content-center registro-fase">
                    <center>
                        @switch($processo->Fase)
                            @case('Abertura de Solicitação')
                                <img src="{{ asset('img/fases_pat_01.png') }}" alt="Fase" class="fase" />
                                @break
                            @case('Solicitação em Análise')
                                <img src="{{ asset('img/fases_pat_02.png') }}" alt="Fase" class="fase" />
                                @break
                            @case('Benefício Concedido')
                                <img src="{{ asset('img/fases_pat_03.png') }}" alt="Fase" class="fase" />
                                @break
                            @case('Solicitação Recusada')
                                <img src="{{ asset('img/fases_pat_04.png') }}" alt="Fase" class="fase" />
                                @break
                            @case('Solicitação Não Aprovada')
                                <img src="{{ asset('img/fases_pat_05.png') }}" alt="Fase" class="fase" />
                                @break
                        @endswitch
                    </center>
                </div>
                <div class="row registro-fase-topo">
                    <div class="span2 text-md-right">
                        Nome do Solicitante:
                    </div>
                    <div class="span5 text-md-left">
                        <strong>{{$usuario->nome}}</strong>
                    </div>
                </div>
                <div class="row registro-fase-topo">
                    <div class="span2 text-md-right">
                        Data da Solicitação:
                    </div>
                    <div class="span5 text-md-left">
                        <strong>{{date('d/m/Y H:i:s', strtotime($usuario->data))}}</strong>
                    </div>
                </div>
                <div class="row registro-fase-topo">
                    <div class="span2 text-md-right">
                        CPF do Solicitante:
                    </div>
                    <div class="span5 text-md-left">
                        <strong>{{$usuario->cpf}}</strong>
                    </div>
                </div>
                <div class="row registro-fase-topo">
                    <div class="span2 text-md-right">
                        Protocolo:
                    </div>
                    <div class="span5 text-md-left">
                        <strong>{{$usuario->protocolo}}</strong>
                    </div>
                </div>
                @if($processo->Fase == 'Solicitação Não Aprovada' || $processo->Fase == 'Solicitação Recusada')
                <div class="row registro-fase-topo">
                    <div class="span2 text-md-right">
                        Motivo:
                    </div>
                    <div class="span5 text-md-left">
                        <strong>{{$processo->motivo}}</strong>
                    </div>
                </div>
                <br>
                <br>
                @endif
                @if($processo->Fase == 'Solicitação Recusada' && ($processo->FINALIZADO == 'andamento' || $processo->FINALIZADO == 'reprovado'))
                    <h3>Recurso:</h3>
                    @if( $usuario->solicitacao_recurso ==  1)
                        <div class="alert alert-info">
                            Já foi efetuada uma solicitação de recurso em {{date('d/m/Y H:i:s', strtotime($usuario->data_recurso))}}
                        </div>
                    @else
                    <form method="POST" action="{{ route('pat_validarCpf') }}" id="pat_recurso" name="pat_recurso">
                        @csrf
                        <center>
                            Faça uma nova solicitação do benefício<br>
                            <br>
                            <button type="button" class="btn btn-small btn-blue e_wiggle align-center" id="solicitarRecurso" style="margin-botton: 15px;">
                                {{ __('Solicitar Retificação') }}
                            </button>
                            <br>
                            <input id="cpf1" type="hidden" name="pat_cpf" value="{{ $usuario->cpf }}">
                            <input id="chamado" type="hidden" name="chamado" value="{{ $processo->Chamado }}">
                            <input id="recurso" type="hidden" name="recurso" value="1">
                            
                            {!! $showRecaptcha !!}
                            
                            <br>

                        </center>

                    </form>
                    @endif
                @elseif($processo->Fase == 'Solicitação Não Aprovada')
                    <h3>Recurso:</h3>
                    @if( isset($recurso->RECURSO) )
                    <div class="alert alert-info">
                        Já foi efetuada uma solicitação de recurso em {{date('d/m/Y H:i:s', strtotime($recurso->DATA))}}
                    </div>
                    @else
                    <form method="POST" action="{{ route('pat_recurso') }}" id="pat_recurso2" name="pat_recurso">
                        @csrf
                        Justifique o motivo do recurso:<br>
                        <input id="cpf1" type="hidden" name="cpf" value="{{ $usuario->cpf }}">
                        <input id="processo" type="hidden" name="processo" value="{{ $processo->Chamado }}">
                        <textarea required class="form-input" id="txtRecurso" name="txtRecurso" rows="6" data-rule="required" data-msg="" placeholder=""></textarea>

                        <div class="row formrow">
                            <div class="controls span3 form-label">
                                <label class="col-md-4 col-form-label text-md-right">
                                    
                                </label>
                            </div>
                
                            <div class="span8">
                                <div class="alert alert-info">
                                    <b>DECLARO E RATIFICO PARA OS DEVIDOS FINS, EM CONFORMIDADE COM O ART. 2º, § 1º, XI, "ALÍNEA F" DA LEI 2920/20, MODIFICADA PELA LEI MUNICIPAL  2922/20, QUE TODOS OS DOCUMENTOS PROBATÓRIOS APRESENTADOS, PREVISTOS NAS ALÍNEAS "A","B","C","D","E", NO ATO DA INSCRIÇÃO, CORRESPONDEM AS PROVAS DA ATIVIDADE ECONÔMICA POR MIM DECLARADA E QUE FOI AFETADA A PARTIR DA PUBLICAÇÃO DO DECRETO MUNICIPAL Nº 499 DE 18 DE MARÇO DE 2020, O QUAL VEIO A DECLARAR, DENTRE OUTRAS MEDIDAS, O ESTADO DE EMERGÊNCIA EM SAÚDE PÚBLICA NO MUNICÍPIO DE MARICÁ.</b>
                                </div>
                            </div>
                        </div>
                        <div class="row formrow">
                            <div class="controls span3 form-label">
                                <label for="declaracao" class="col-md-4 col-form-label text-md-right">
                                    &nbsp;
                                </label>
                            </div>
                
                            <div class="span3">
                                <input type="checkbox" id="declaracao10" name="declaracao10" class="form-input"> Li e declaro estar ciente dos termos. <span class="required">*</span>
                                <br>
                                @if ($errors->has('declaracao10'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('declaracao10') }}</strong>
                                </span>
                                @endif 
                            </div>
                        </div>      



                        <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="solicitarRecurso2">
                            {{ __('Solicitar Recurso') }}
                        </button>
                    </form>
                    @endif
                @endif

                @if($processo->Fase == 'Benefício Concedido')
                    <h3>Dados do Banco Mumbuca:</h3>
                    <div class="row registro-fase-topo">
                        <div class="span2 text-md-right">
                            Agência:
                        </div>
                        <div class="span5 text-md-left">
                            <strong>{{$banco->agencia}}</strong>
                        </div>
                    </div>
                    <div class="row registro-fase-topo">
                        <div class="span2 text-md-right">
                            Conta:
                        </div>
                        <div class="span5 text-md-left">
                            <strong>{{$banco->conta}}</strong>
                        </div>
                    </div>
                    <div class="row registro-fase-topo">
                        <div class="span2 text-md-right">
                            Senha de 1º acesso:
                        </div>
                        <div class="span5 text-md-left">
                            <strong>{{$banco->chave}}</strong>
                        </div>
                    </div>
                    <div class="row registro-fase-topo">
                        <div class="span2 text-md-right">
                            
                        </div>
                        <div class="span8 text-md-left">
                            <div class="alert alert-info">

                                <p>Sua senha de primeiro acesso foi enviada para o e-mail cadastrado.</p>
                                <p>Ao realizar seu primeiro acesso e troca da senha, você concorda com a auto declaração abaixo:</p>
                                <p>Declaro e ratifico para os devidos fins, em conformidade com o Art. 2º, § 1º, XI, "alínea f" da Lei 2920/20, modificada pela Lei Municipal  2922/20, que todos os documentos probatórios apresentados, previstos nas alíneas "a","b","c","d","e", no ato da inscrição, correspondem as provas da atividade econômica por mim declarada e que foi afetada a partir da publicação do Decreto Municipal nº 499 de 18 de março de 2020, o qual veio a declarar, dentre outras medidas, o estado de emergência em saúde pública no Município de Maricá.</p>
                                <p><b>ATENÇÃO</b></p>
                                <p>Importante que você baixe o Aplicativo "e-dinheiro" na Play Store ou IOS. Informações de como baixar o Aplicativo, veja o vídeo explicativo em: https://institutoedinheiromarica.org.</p>
                                <p>Ao baixar o aplicativo, altere de imediato sua Senha. Você só terá acesso ao benefício quando efetivar a troca de senha. Veja o vídeo explicativo de como trocar a senha em:
                                    <a href="https:\\institutoedinheiromarica.org" target="_BLANK">https:\\institutoedinheiromarica.org</a></p>
                                <p>Em caso dúvidas, você pode entrar em contato com o Banco Mumbuca nos seguintes telefones: 3731-1021 / 97285-6635 / 96726-3882 / 3731-6550.</p>


                                {{-- <p>Para criar a sua senha ligue, pessoalmente para o banco Mumbuca, através do telefone (celular ou fixo) que você informou no cadastro.</p>
                                <p>No momento da ligação tenha em mãos o número de sua conta informada acima.</p>
                                <p>Ao entrar em contato com o banco, você concorda com a auto declaração abaixo:</p>
                                <p>Declaro e ratifico para os devidos fins, em conformidade com o Art. 2º, § 1º, XI, "alínea f" da Lei 2920/20, modificada pela Lei Municipal  2922/20, que todos os documentos probatórios apresentados, previstos nas alíneas "a","b","c","d","e", no ato da inscrição, correspondem as provas da atividade econômica por mim declarada e que foi afetada a partir da publicação do Decreto Municipal nº 499 de 18 de março de 2020, o qual veio a declarar, dentre outras medidas, o estado de emergência em saúde pública no Município de Maricá.</p>
                                <p>Os telefones para os quais você pode ligar são: 3731-1021 / 97285-6635 / 96726-3882 / 3731-6550.</p>
                                <p>É importante antes de ligar, que você baixe o aplicativo "e-dinheiro" na Play Store ou  IOS.</p>
                                <p>Para maiores informações de como baixar o aplicativo, veja o vídeo explicativo em:</p>
                                <p><a href="https:\\institutoedinheiromarica.org" target="_BLANK">https:\\institutoedinheiromarica.org</a></p> --}}                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="span3">
                <a href="{{ route('consultarsituacao' )  }}">
                    <button type="button" class="btn btn-theme e_wiggle" id="voltar">
                        {{ __('Voltar') }}
                    </button>
                    <a>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
</section>
@endsection

@section('post-script')

<script type="text/javascript">

    $("#solicitarRecurso2").click(function(){

        if($("#txtRecurso").val()==""){
            alert("Por favor preencha as informações para solicitar o Recurso");
            $("#txtRecurso").focus();
            return false; 
        }

        if(!$("#declaracao10").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#declaracao10").focus();
            return false;       
        }
        else{

            $text = $("#txtRecurso").val();
            $("#txtRecurso").val($text + '\r\n\r\n' + 'DECLARO E RATIFICO PARA OS DEVIDOS FINS, EM CONFORMIDADE COM O ART. 2º, § 1º, XI, "ALÍNEA F" DA LEI 2920/20, MODIFICADA PELA LEI MUNICIPAL  2922/20, QUE TODOS OS DOCUMENTOS PROBATÓRIOS APRESENTADOS, PREVISTOS NAS ALÍNEAS "A","B","C","D","E", NO ATO DA INSCRIÇÃO, CORRESPONDEM AS PROVAS DA ATIVIDADE ECONÔMICA POR MIM DECLARADA E QUE FOI AFETADA A PARTIR DA PUBLICAÇÃO DO DECRETO MUNICIPAL Nº 499 DE 18 DE MARÇO DE 2020, O QUAL VEIO A DECLARAR, DENTRE OUTRAS MEDIDAS, O ESTADO DE EMERGÊNCIA EM SAÚDE PÚBLICA NO MUNICÍPIO DE MARICÁ.');
            console.log($("#txtRecurso").val());

            $("#pat_recurso2").submit();
        }
    });

    $("#solicitarRecurso").click(function(){

        // if($("#txtRecurso").val()==""){
        //     alert("Por favor preencha as informações para solicitar o Recurso");
        //     $("#txtRecurso").focus();
        //     return false; 
        // }

        // if(!$("#declaracao10").is(':checked')){
        //     alert("É necessário concordar com os termos do programa");
        //     $("#declaracao10").focus();
        //     return false;       
        // }
        // else{

            // $text = $("#txtRecurso").val();
            // $("#txtRecurso").val($text + '\r\n\r\n' + 'DECLARO E RATIFICO PARA OS DEVIDOS FINS, EM CONFORMIDADE COM O ART. 2º, § 1º, XI, "ALÍNEA F" DA LEI 2920/20, MODIFICADA PELA LEI MUNICIPAL  2922/20, QUE TODOS OS DOCUMENTOS PROBATÓRIOS APRESENTADOS, PREVISTOS NAS ALÍNEAS "A","B","C","D","E", NO ATO DA INSCRIÇÃO, CORRESPONDEM AS PROVAS DA ATIVIDADE ECONÔMICA POR MIM DECLARADA E QUE FOI AFETADA A PARTIR DA PUBLICAÇÃO DO DECRETO MUNICIPAL Nº 499 DE 18 DE MARÇO DE 2020, O QUAL VEIO A DECLARAR, DENTRE OUTRAS MEDIDAS, O ESTADO DE EMERGÊNCIA EM SAÚDE PÚBLICA NO MUNICÍPIO DE MARICÁ.');
            // console.log($("#txtRecurso").val());

            $("#pat_recurso").submit();
        // }
    });
</script>

@endsection