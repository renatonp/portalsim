@extends('layouts.tema01')

@section('content')

<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    @if($vencimentoIPTU == 0)
                    <h2>{{ __('Cadastrar / Atualizar CGM') }}</h2>
                    @else
                    <h2>{{ __('ALTERAR VENCIMENTO DE IPTU') }}</h2>
                    @endif
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    @if($vencimentoIPTU == 0)
                    <li class="active">{{ __('Cadastrar / Atualizar CGM') }}</li>
                    @else
                    <li class="active">{{ __('ALTERAR VENCIMENTO DE IPTU') }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form method="POST" action="{{ route('gravar_cadastro') }}" id="formDocumentos" enctype="multipart/form-data"> 
                    @csrf
                    <input type="hidden" name="ArquivosPF" id="ArquivosPF" value="" />
                    <input type="hidden" name="ArquivosCR" id="ArquivosCR" value="" />
                    <input type="hidden" name="ArquivosVI" id="ArquivosVI" value="" />
                    <input type="hidden" name="ArquivosPJ" id="ArquivosPJ" value="" />
                    <input type="hidden" name="ArquivosReq" id="ArquivosReq" value="" />
                    <input type="hidden" name="MatrcImoveis" id="MatrcImoveis" value="" />
                    <input type="hidden" name="vencimentoIPTU" id="vencimentoIPTU" value="{{$vencimentoIPTU}}" />
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion" id="accordion3">
                                @if($vencimentoIPTU == 0)
                                    @guest
                                        {{--                                     
                                        *********************************************************************
                                        *********************************************************************
                                        ************ CGM 
                                        *********************************************************************
                                        *********************************************************************
                                        --}}

                                        {{-- 
                                        ***********************************
                                        *** Dados do Requerente 
                                        ***********************************
                                        --}}
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseReq">
                                                    <i class="icon-plus"></i>
                                                    Dados do Requerente
                                                </a>
                                            </div>
                                            <div id="collapseReq" class="accordion-body collapse">
                                                @include('cadastro.requerente')
                                                {{-- @include('cadastro.emconstrucao') --}}
                                            </div>
                                        </div>

                                        @if(strlen($cpf) == 14)
                                            {{-- 
                                            ***********************************
                                            *** Informações Pessoais 
                                            ***********************************
                                            --}}
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                                        href="#collapseOne1">
                                                        <i class="icon-plus"></i>
                                                        Informações Pessoais
                                                    </a>
                                                </div>
                                                <div id="collapseOne1" class="accordion-body collapse">
                                                    @include('cadastro.pessoa_fisica')
                                                </div>
                                            </div>
                                        @elseif(strlen($cpf) > 14)

                                            {{-- 
                                            ***********************************
                                            *** Dados Mercantis 
                                            ***********************************
                                            --}}
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseDM">
                                                        <i class="icon-plus"></i>
                                                        Dados Mercantis
                                                    </a>
                                                </div>
                                                <div id="collapseDM" class="accordion-body collapse">
                                                    @include('cadastro.pessoa_juridica')
                                                    {{-- @include('cadastro.emconstrucao') --}}
                                                </div>
                                            </div>
                                        @endif
                                
                                        {{-- 
                                        ***********************************
                                        *** Informações de Contato
                                        ***********************************
                                        --}}
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseTwo2">
                                                    <i class="icon-plus"></i> Informações de Contato
                                                </a>
                                            </div>
                                            <div id="collapseTwo2" class="accordion-body collapse">
                                                @include('cadastro.informacoes_contato')
                                                {{-- @include('cadastro.emconstrucao') --}}
                                            </div>
                                        </div>

                                        {{-- 
                                        ***********************************
                                        *** Endereço
                                        ***********************************
                                        --}}
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree1">
                                                    <i class="icon-plus"></i> Endereço
                                                </a>
                                            </div>
                                            <div id="collapseThree1" class="accordion-body collapse">
                                                @include('cadastro.endereco')
                                                {{-- @include('cadastro.emconstrucao') --}}
                                            </div>
                                        </div>

                                        {{-- 
                                        ***********************************
                                        *** Cadastro de Imóveis
                                        ***********************************
                                        --}}
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree2">
                                                    <i class="icon-plus"></i> Cadastro de Imóveis (Preencher se for proprietário ou possuidor de imóvel no município)
                                                </a>
                                            </div>
                                            <div id="collapseThree2" class="accordion-body collapse">
                                                @include('cadastro.cadastro_imoveis')
                                                {{-- @include('cadastro.emconstrucao') --}}
                                            </div>
                                        </div>
                                    @else

                                    @endguest
                                @else
                                    {{--                                     
                                    *********************************************************************
                                    *********************************************************************
                                    ************ IPTU 
                                    *********************************************************************
                                    *********************************************************************
                                    --}}
                                    {{-- 
                                    ***********************************
                                    *** Informações Pessoais 
                                    ***********************************
                                    --}}
                                    
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseOne1">
                                                <i class="icon-minus"></i>
                                                Informações Pessoais do Beneficiário
                                            </a>
                                        </div>
                                        <div id="collapseOne1" class="accordion-body collapse in">
                                            @include('cadastro.pessoa_fisica')
                                        </div>
                                    </div>
                                    {{-- 
                                    ***********************************
                                    *** Informações de Contato
                                    ***********************************
                                    --}}
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseTwo2">
                                                <i class="icon-plus"></i> Informações de Contato
                                            </a>
                                        </div>
                                        <div id="collapseTwo2" class="accordion-body collapse">
                                            @include('cadastro.informacoes_contato')
                                            {{-- @include('cadastro.emconstrucao') --}}
                                        </div>
                                    </div>

                                    {{-- 
                                    ***********************************
                                    *** Endereço
                                    ***********************************
                                    --}}
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree1">
                                                <i class="icon-plus"></i> Endereço do Beneficiário
                                            </a>
                                        </div>
                                        <div id="collapseThree1" class="accordion-body collapse">
                                            @include('cadastro.endereco')
                                            {{-- @include('cadastro.emconstrucao') --}}
                                        </div>
                                    </div>
                                    {{-- 
                                    ***********************************
                                    *** Cadastro de Imóveis
                                    ***********************************
                                    --}}
                                    <div class="accordion-group">
                                        <div class="accordion-heading">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree2">
                                                <i class="icon-plus"></i> Cadastro de Imóveis
                                            </a>
                                        </div>
                                        <div id="collapseThree2" class="accordion-body collapse">
                                            @include('cadastro.cadastro_imoveis')
                                            {{-- @include('cadastro.emconstrucao') --}}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="span6 text-left">
                                    @guest
                                        @if($vencimentoIPTU == 0)
                                            <a href="{{ url('atualizaCGM')  }}">
                                        @else
                                            <a href="{{ url('atualizaCGMIPTU')  }}">
                                        @endif
                                    @else
                                        @if($vencimentoIPTU == 0)
                                            <a href="{{ route('servicos', [1 ,1 ] )  }}">
                                        @else
                                            <a href="{{ route('servicos', [1 ,4 ] )  }}">
                                        @endif
                                    @endguest
                                        <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                                            {{ __('Voltar') }}
                                        </button>
                                    <a>
                                </div>
                                <div class="span5 text-right">
                                    <button type="button" class="btn btn-theme e_wiggle" id="gravarInformacoes">
                                        {{ __('Gravar Informações') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
</section>
@endsection

@section('post-script')

<script type="text/javascript">

    var infoEnviada = false;

    var $arq01 = false;
    var $arq02 = false;
    var $arq03 = false;
    var $arq04 = false;
    var $arq05 = false;
    var $arq06 = false;
    var $arq07 = false;
    var $arq08 = false;
    var $arq09 = false;


    $("#telefone").mask("(00)0000-0000");
    $("#celular").mask("(00)00000-0000");
    $("#dtnasc").mask("00/00/0000");
    $("#dtEmiss").mask("00/00/0000");
    $("#dtAbertura").mask("00/00/0000");
    $("#cpfRespLegal").mask("000.000.000-00");
    $("#dtEmissRespLegal").mask("00/00/0000");
    $("#cep").mask("00.000-000");
    $("#matriculaImovel").mask("#####0",{reverse: true});
    $("#numero").mask("############0",{reverse: true});
    $("#inscrEstadual").mask("#######0",{reverse: true});

    jQuery(document).ready(function(){
        $("#collapseReq").collapse('show');

        @if (session('status'))
            @if (session('status') == 1 || session('status') == 3)
                $("#mensagem").css({
                    "opacity": "0"
                });
            @endif
            @if (session('status') == 2 || session('status') == 3)
                $("#mensagem2").css({
                    "opacity": "0"
                });
            @endif
        @endif
    });

    $("#gravarInformacoes").click(function(){
        // ************************************************
        // *** Validações
        // ************************************************
        if($("#respPreenchimento").val() == "" ){
            alert("Por favor informe o Responsável pelo Preenchimento");
            $("#collapseReq").collapse('show');
            $("#respPreenchimento").focus();
            return false;
        }
        // *************** Representante Legal
        @if($vencimentoIPTU == 0)
            if($("#respPreenchimento").val() == "2" ){

                if($("#nomeRespLegal").val() == "" ){
                    alert("Por favor informe o Nome do Representante Legal");
                    $("#collapseReq").collapse('show');
                    $("#nomeRespLegal").focus();
                    return false;
                }
                if($("#idRespLegal").val() == "" ){
                    alert("Por favor informe a Identidade do Representante Legal");
                    $("#collapseReq").collapse('show');
                    $("#idRespLegal").focus();
                    return false;
                }
                if($("#orgEmRespLegal").val() == "" ){
                    alert("Por favor informe o Órgão Emissor da Identidade do Representante Legal");
                    $("#collapseReq").collapse('show');
                    $("#orgEmRespLegal").focus();
                    return false;
                }
                if($("#dtEmissRespLegal").val() == "" ){
                    alert("Por favor informe a Data de Emissão da Identidade do Representante Legal");
                    $("#collapseReq").collapse('show');
                    $("#dtEmissRespLegal").focus();
                    return false;
                }
                else{
                    if(!validadataNascimento3($("#dtEmissRespLegal").val())){
                        alert("Data de Emissão da Identidade do Representante Legal Inválida")
                        $("#collapseReq").collapse('show');
                        $("#dtEmissRespLegal").focus();
                        return false;
                    }
                }
                if($("#cpfRespLegal").val() == "" ){
                    alert("Por favor informe o CPF do Representante Legal");
                    $("#collapseReq").collapse('show');
                    $("#cpfRespLegal").focus();
                    return false;
                }
                else{
                    if(!validarCPF($("#cpfRespLegal").val())){
                        alert("CPF Inválido!");
                        $("#collapseReq").collapse('show');
                        $("#cpfRespLegal").focus();
                        return false;
                    }
                }
                if($("#emailRespLegal").val() == "" ){
                    alert("Por favor informe o E-Mail do Representante Legal");
                    $("#collapseReq").collapse('show');
                    $("#emailRespLegal").focus();
                    return false;
                }
                else{
                    if(!validaEmail($("#emailRespLegal").val())){
                        alert("Email Inválido!");
                        $("#collapseReq").collapse('show');
                        $("#emailRespLegal").focus();
                        return false;
                    }                    
                }
                if( documentosLancadosReq.rows().count()  == 0 ){
                alert("Anexe o documento de Representação Legal e faça o lançamento");
                $("#collapseReq").collapse('show');
                $("#arquivoCpfReq").focus();
                return false;
            }
            }
        @endif

        // *************** Pessoa Física
        @if(strlen($cpf) == 14)
            if($("#nome").val() == "" ){
                alert("Por favor informe o seu Nome");
                $("#collapseOne1").collapse('show');
                $("#nome").focus();
                return false;
            }

            if($("#filiacao1").val() == "" ){
                alert("Por favor informe o nome da sua Mãe");
                $("#collapseOne1").collapse('show');
                $("#filiacao1").focus();
                return false;
            }

            if($("#dtnasc").val() == "" ){
                alert("Por favor informe a sua Data de Nascimento");
                $("#collapseOne1").collapse('show');
                $("#dtnasc").focus();
                return false;
            }
            else{
                if(!validadataNascimento3($("#dtnasc").val())){
                    alert("Data de Nascimento Inválida")
                    $("#collapseOne1").collapse('show');
                    $("#dtnasc").focus();
                    return false;
                }
            }

            if($("#estCivil").val() == "" ){
                alert("Por favor informe o seu Estado Civil");
                $("#collapseOne1").collapse('show');
                $("#estCivil").focus();
                return false;
            }

            if($("#nacionalidade").val() == "" ){
                alert("Por favor informe a sua Nacionalidade");
                $("#collapseOne1").collapse('show');
                $("#nacionalidade").focus();
                return false;
            }

            if($("#sexo").val() == "" ){
                alert("Por favor informe o seu Sexo");
                $("#collapseOne1").collapse('show');
                $("#sexo").focus();
                return false;
            }

            if($("#naturalidade").val() == "" ){
                alert("Por favor informe a sua Naturalidade");
                $("#collapseOne1").collapse('show');
                $("#naturalidade").focus();
                return false;
            }

            if($("#identidade").val() == "" ){
                alert("Por favor informe o número do seu Documento de Identidade");
                $("#collapseOne1").collapse('show');
                $("#identidade").focus();
                return false;
            }

            if($("#orgEmi").val() == "" ){
                alert("Por favor informe o Orgão do Emissão do sue documento de identidade");
                $("#collapseOne1").collapse('show');
                $("#orgEmi").focus();
                return false;
            }

            if($("#dtEmiss").val() == "" ){
                alert("Por favor informe a Data de Emissão do seu documento de identidade");
                $("#collapseOne1").collapse('show');
                $("#dtEmiss").focus();
                return false;
            }
            else{
                if(!validadataNascimento3($("#dtEmiss").val())){
                    alert("Data de Emissão do Documento de Identidade é inválida")
                    $("#collapseOne1").collapse('show');
                    $("#dtEmiss").focus();
                    return false;
                }
            }
            if(!$arq02){
                alert("É necessário incluir a sua IDENTIDADE em formato digital");
                $("#collapseOne1").collapse('show');
                $("#arquivoId").focus();
                return false;
            }

            @if($vencimentoIPTU == 0)
            if(!$arq08){
                alert("É necessário incluir a  Selfie de Identificação em formato digital");
                $("#collapseOne1").collapse('show');
                $("#arquivoSelfie").focus();
                return false;
            }
            @endif

            if(!$arq01){
                alert("É necessário incluir o seu CPF em formato digital");
                $("#collapseOne1").collapse('show');
                $("#arquivoCpf").focus();
                return false;
            }
        @else
            if($("#razaoSocial").val() == "" ){
                alert("Por favor informe a Razão Social da Empresa");
                $("#collapseDM").collapse('show');
                $("#razaoSocial").focus();
                return false;
            }


            if($("#dtAbertura").val() == "" ){
                alert("Por favor informe a Data de Abertura da Empresa");
                $("#collapseDM").collapse('show');
                $("#dtAbertura").focus();
                return false;
            }
            else{
                if(!validadataNascimento3($("#dtAbertura").val())){
                    alert("Data Inválida")
                    $("#collapseDM").collapse('show');
                    $("#dtAbertura").focus();
                    return false;
                }
            }

            // if($("#inscrEstadual").val() == "" ){
            //     alert("Por favor informe a Inscrição Estadual da Empresa");
            //     $("#collapseDM").collapse('show');
            //     $("#inscrEstadual").focus();
            //     return false;
            // }

            if(!$arq05){
                alert("É necessário incluir o Contrato Social da Empresa");
                $("#collapseDM").collapse('show');
                $("#arquivoCSocial").focus();
                return false;
            }
            if(!$arq06){
                alert("É necessário incluir o Documento de Identidade do Sócio");
                $("#collapseDM").collapse('show');
                $("#arquivoRGSocio").focus();
                return false;
            }
            if(!$arq07){
                alert("É necessário incluir o CPF do Sócio");
                $("#collapseDM").collapse('show');
                $("#arquivoCPFSocio").focus();
                return false;
            }
        @endif


        if($("#email").val() == "" ){
            alert("Por favor informe o seu E-Mail");
            $("#collapseTwo2").collapse('show');
            $("#email").focus();
            return false;
        }
        else{
            if(!validaEmail($("#email").val())){
                alert("Email Inválido!");
                $("#collapseTwo2").collapse('show');
                $("#email").focus();
                return false;
            }                    
        }

        if($("#email-confirm").val() == "" ){
            alert("Por favor confirme o seu E-Mail");
            $("#collapseTwo2").collapse('show');
            $("#email-confirm").focus();
            return false;
        }
        else{
            if(!validaEmail($("#email-confirm").val())){
                alert("Email Inválido!");
                $("#collapseTwo2").collapse('show');
                $("#email-confirm").focus();
                return false;
            }                    
        }

        if($("#email-confirm").val() != $("#email").val() ){
            alert("O seu E-Mail e a Confirmação não são iguais");
            $("#collapseTwo2").collapse('show');
            $("#email-confirm").focus();
            return false;
        }

        if($("#celular").val() == ""){
            alert("Por favor informe o seu Celular");
            $("#collapseTwo2").collapse('show');
            $("#celular").focus();
            return false;
        }

        if($("#cep").val() == "" ){
            alert("Por favor informe o seu CEP");
            $("#collapseThree1").collapse('show');
            $("#cep").focus();
            return false;
        }

        if($("#cidade").val() == "" ){
            alert("Por favor informe o seu Município");
            $("#collapseThree1").collapse('show');
            $("#cidade").focus();
            return false;
        }

        if($("#logradouro").val() == "" ){
            alert("Por favor informe o seu Logradouro");
            $("#collapseThree1").collapse('show');
            $("#logradouro").focus();
            return false;
        }

        if($("#numero").val() == "" ){
            alert("Por favor informe o número do seu Endereço");
            $("#collapseThree1").collapse('show');
            $("#numero").focus();
            return false;
        }

        if(!$arq09){
            alert("É necessário incluir o seu COMPROVANTE DE RESIDÊNCIA em formato digital");
            $("#collapseThree1").collapse('show');
            $("#arquivoEndereco").focus();
            return false;
        }

        @if($vencimentoIPTU != 0)
            if( documentosVinculo.rows().count()  == 0 ){
                alert("Por favor preencha as informações do seu imóvel, anexe o documento de comprovação de vínculo e faça o lançamento");
                $("#collapseThree2").collapse('show');
                $("#matriculaImovel").focus();
                return false;
            }
        @endif


        var $arq = "";
        documentosLancadosPF.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            if($arq.length > 0 ){
                $arq += "|"
            }
            $arq += JSON.stringify(this.data());
        });

        var $arq2 = "";
        documentosVinculo.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            if($arq2.length > 0 ){
                $arq2 += "|"
            }
            $arq2 += JSON.stringify(this.data());
        });

        var $arq3 = "";
        documentosEnderecoTbl.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            if($arq3.length > 0 ){
                $arq3 += "|"
            }
            $arq3 += JSON.stringify(this.data());
        });
        var $arq4 = "";
        documentosPJTbl.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            if($arq4.length > 0 ){
                $arq4 += "|"
            }
            $arq4 += JSON.stringify(this.data());
        });
        var $arq5 = "";
        documentosLancadosReq.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            if($arq5.length > 0 ){
                $arq5 += "|"
            }
            $arq5 += JSON.stringify(this.data());
        });

        $("#ArquivosPF").val($arq);
        $("#ArquivosVI").val($arq2);
        $("#ArquivosCR").val($arq3);
        $("#ArquivosPJ").val($arq4);
        $("#ArquivosReq").val($arq5);

        $("#uf").prop('disabled', false);
        $("#respPreenchimento").prop('disabled', false);

        $("#formDocumentos").submit();

    });


    $("#respPreenchimento").change(function(){

        console.log( $("#respPreenchimento").val());

        if( $("#respPreenchimento").val() == "2" ){
            $("#responsavelLegal").show();
            documentosLancadosReq.columns.adjust().draw();
            $("#nomeRespLegal").focus();
        }
        else{
            $("#responsavelLegal").hide();
        }
    });

    $("#postergacao").click(function(){
        if( $("#postergacao").is(':checked') ){
            $("#imoveisUsuario").show();
            matriculaImoveis.columns.adjust().draw();
            documentosVinculo.columns.adjust().draw();
        }
        else{
            $("#imoveisUsuario").hide();
        }
    });
    
    var documentosLancadosReq = $('#documentosLancadosReq').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "bLengthChange" : false,
        "pageLength"    : 5,
        "searching"     : false,
        "ordering"      : false,
        "scrollY"       : 150,
        "info"          : false,
    });
    
    var documentosPJTbl = $('#documentosPJTbl').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "bLengthChange" : false,
        "pageLength"    : 5,
        "searching"     : false,
        "ordering"      : false,
        "scrollY"       : 150,
        "info"          : false,
    });
    
    var documentosEnderecoTbl = $('#documentosEnderecoTbl').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "bLengthChange" : false,
        "pageLength"    : 5,
        "searching"     : false,
        "ordering"      : false,
        "scrollY"       : 150,
        "info"          : false,
    });

    var documentosVinculo = $('#documentosVinculo').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "bLengthChange" : false,
        "pageLength"    : 5,
        "searching"     : false,
        "ordering"      : false,
        "scrollY"       : 200,
        "info"          : false,
    });

    var documentosLancadosPF = $('#documentosLancadosPF').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "bLengthChange" : false,
        "pageLength"    : 5,
        "searching"     : false,
        "ordering"      : false,
        "scrollY"       : 100,
        "info"          : false,
    });

    var matriculaImoveis = $('#matriculaImoveis').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "bLengthChange" : false,
        "pageLength"    : 5,
        "searching"     : false,
        "ordering"      : false,
        "scrollY"       : 100,
        "info"          : false,
    });

    $("#lancarArquivoCpfReq").click(function () {
        if ($("#arquivoCpfReq").val() == "") {
            alert("Por favor selecione o documento de Representação Legal para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCpfReq');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];


        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='cad_doc_req']")[0]);
        var $descricao = dados.get("DescrDoc");
        console.log($descricao);
        console.log(dados);

        $.ajax({
            type: 'POST',
            url: "{{ url('/cadastro_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {

            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                documentosLancadosReq.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                documentosLancadosReq.columns.adjust().draw();
                $("#arquivoCpfReq").val("");
                $arq10 = true;
            }
            else {
                alert("Não foi possivel fazer o upload do seu arquivo");
                return false;
            }
        })
        .fail(function ( data ) {
            $("#mdlAguarde").modal('toggle');
            alert("Não foi possivel fazer o upload do seu arquivo");
            return false;
        })
    });

    $("#lancarArquivoCPFSocio").click(function () {
        if ($("#arquivoCPFSocio").val() == "") {
            alert("Por favor selecione CPF do Sócio para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCPFSocio');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];


        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='formCPFSocio']")[0]);
        var $descricao = dados.get("DescrDoc");
        console.log($descricao);
        console.log(dados);

        $.ajax({
            type: 'POST',
            url: "{{ url('/cadastro_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {

            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                documentosPJTbl.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                documentosPJTbl.columns.adjust().draw();
                $("#arquivoCPFSocio").val("");
                $arq07 = true;
            }
            else {
                alert("Não foi possivel fazer o upload do seu arquivo");
                return false;
            }
        })
        .fail(function ( data ) {
            $("#mdlAguarde").modal('toggle');
            alert("Não foi possivel fazer o upload do seu arquivo");
            return false;
        })
    });

    $("#lancarArquivoRGSocio").click(function () {
        if ($("#arquivoRGSocio").val() == "") {
            alert("Por favor selecione O RG do Sócio para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoRGSocio');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];


        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='formRGSocio']")[0]);
        var $descricao = dados.get("DescrDoc");
        console.log($descricao);
        console.log(dados);

        $.ajax({
            type: 'POST',
            url: "{{ url('/cadastro_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {

            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                documentosPJTbl.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                documentosPJTbl.columns.adjust().draw();
                $("#arquivoRGSocio").val("");
                $arq06 = true;
            }
            else {
                alert("Não foi possivel fazer o upload do seu arquivo");
                return false;
            }
        })
        .fail(function ( data ) {
            $("#mdlAguarde").modal('toggle');
            alert("Não foi possivel fazer o upload do seu arquivo");
            return false;
        })
    });

    $("#lancarArquivoCSocial").click(function () {
        if ($("#arquivoCSocial").val() == "") {
            alert("Por favor selecione o Contrato Social para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCSocial');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];


        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='formCSocial']")[0]);
        var $descricao = dados.get("DescrDoc");
        console.log($descricao);
        console.log(dados);

        $.ajax({
            type: 'POST',
            url: "{{ url('/cadastro_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {

            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                documentosPJTbl.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                documentosPJTbl.columns.adjust().draw();
                $("#arquivoCSocial").val("");
                $arq05 = true;
            }
            else {
                alert("Não foi possivel fazer o upload do seu arquivo");
                return false;
            }
        })
        .fail(function ( data ) {
            $("#mdlAguarde").modal('toggle');
            alert("Não foi possivel fazer o upload do seu arquivo");
            return false;
        })
    });

    @if($vencimentoIPTU == 0)
        $("#lancarArquivoSelfie").click(function () {
            if ($("#arquivoSelfie").val() == "") {
                alert("Por favor selecione a Selfie de Identificação para enviar");
                return false;
            }

            var $input, file, $arquivo, $tamanho, $ext;
            
            if (!window.FileReader) {
                return false;
            }
            
            $input = document.getElementById('arquivoSelfie');
            file = $input.files[0];
            // $ext = /\..*$/g.exec(file.name);
            
            $ext = file.name.split('.');

            $ext = "." + $ext[$ext.length-1];


            if (file.size > 2048000) {
                alert("O arquivo deve ter no máximo 2Mb");
                return false;
            }

            if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
                alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
                return false;
            }

            $("#mdlAguarde").modal('toggle');
            var dados = new FormData($("form[name='cad_selfie_id']")[0]);
            var $descricao = dados.get("DescrDoc");
            console.log($descricao);
            console.log(dados);

            $.ajax({
                type: 'POST',
                url: "{{ url('/cadastro_documentos') }}",
                data: dados,
                processData: false,
                contentType: false

            }).done(function (resposta) {

                $("#mdlAguarde").modal('toggle');

                if (resposta.statusArquivoTransacao == 1) {
                    documentosLancadosPF.row.add([
                        $descricao,
                        resposta.nome_original,
                        resposta.nome_novo,
                        '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                    ]).draw(false);
                    documentosLancadosPF.columns.adjust().draw();
                    $("#arquivoSelfie").val("");
                    $arq08 = true;
                }
                else {
                    alert("Não foi possivel fazer o upload do seu arquivo");
                    return false;
                }
            })
            .fail(function ( data ) {
                if( data.status === 422 ) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        console.log(key+ " " +value);
                        $('#response').addClass("alert alert-danger");

                        if($.isPlainObject(value)) {
                            $.each(value, function (key, value) {                       
                                console.log(key+ " " +value);
                            $('#response').show().append(value+"<br/>");

                            });
                        }else{
                        $('#response').show().append(value+"<br/>"); //this is my div with messages
                        }
                    });
                }
            })
        });
    @endif

    $("#lancarArquivoId").click(function () {
        if ($("#arquivoId").val() == "") {
            alert("Por favor selecione o Documento de Identidade para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoId');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];


        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='cad_doc_id']")[0]);
        var $descricao = dados.get("DescrDoc");
        console.log($descricao);
        console.log(dados);

        $.ajax({
            type: 'POST',
            url: "{{ url('/cadastro_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {

            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                documentosLancadosPF.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                documentosLancadosPF.columns.adjust().draw();
                $("#arquivoId").val("");
                $arq02 = true;
            }
            else {
                alert("Não foi possivel fazer o upload do seu arquivo");
                return false;
            }
        })
        .fail(function ( data ) {
            if( data.status === 422 ) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(key+ " " +value);
                    $('#response').addClass("alert alert-danger");

                    if($.isPlainObject(value)) {
                        $.each(value, function (key, value) {                       
                            console.log(key+ " " +value);
                        $('#response').show().append(value+"<br/>");

                        });
                    }else{
                    $('#response').show().append(value+"<br/>"); //this is my div with messages
                    }
                });
            }
        })
    });

    // $("#btn_lancarImovel").click(function () {
    //     if ($("#matriculaImovel").val() == "") {
    //         alert("Por favor informe a matrícula do Imóvel");
    //         return false;
    //     }

    //     matriculaImoveis.row.add([
    //         $("#cpfPF").val(),
    //         $("#matriculaImovel").val(),
    //         '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
    //     ]).draw(false);
    //     matriculaImoveis.columns.adjust().draw();
    //     $("#matriculaImovel").val("");

    // });

    $("#lancarArquivoCpf").click(function () {
        if ($("#arquivoCpf").val() == "") {
            alert("Por favor selecione o CPF para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCpf');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];


        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='cad_doc_cpf']")[0]);
        var $descricao = dados.get("DescrDoc");
        console.log($descricao);
        console.log(dados);

        $.ajax({
            type: 'POST',
            url: "{{ url('/cadastro_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                documentosLancadosPF.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                documentosLancadosPF.columns.adjust().draw();
                $("#arquivoCpf").val("");
                $arq01 = true;
            }
            else {
                alert("Não foi possivel fazer o upload do seu arquivo");
                return false;
            }
        })
        .fail(function ( data ) {
            if( data.status === 422 ) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(key+ " " +value);
                    $('#response').addClass("alert alert-danger");

                    if($.isPlainObject(value)) {
                        $.each(value, function (key, value) {                       
                            console.log(key+ " " +value);
                        $('#response').show().append(value+"<br/>");

                        });
                    }else{
                    $('#response').show().append(value+"<br/>"); //this is my div with messages
                    }
                });
            }
        })
    });

    $("#lancarArquivoVinculo").click(function () {
        if ($("#matriculaImovel").val() == "") {
            alert("Por favor Informe a matrícula do Imóvel");
            return false;
        }

        if ($("#tipoVinculo").val() == "") {
            alert("Por favor Informe o tipo de vínculo com o Imóvel");
            return false;
        }

        if ($("#tipoDocImovel").val() == "") {
            alert("Por favor Informe o tipo de documento para comprovação de vínculo com o imóvel");
            return false;
        }

        if ($("#arquivoVinculo").val() == "") {
            alert("Por favor selecione o Comprovante de Vínculo para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoVinculo');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];


        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='formVinculo']")[0]);
        var $descricao = dados.get("DescrDoc");
        console.log("desc: " + $descricao);
        console.log(dados);

        $.ajax({
            type: 'POST',
            url: "{{ url('/cadastro_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                documentosVinculo.row.add([
                    $("#matriculaImovel").val(),
                    $("#tipoVinculo").val(),
                    $("#tipoDocImovel").val(),
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                documentosVinculo.columns.adjust().draw();
                $("#arquivoVinculo").val("");
                $("#matriculaImovel").val(""),
                $("#tipoVinculo").val(""),
                $("#tipoDocImovel").val(""),                
                $arq04 = true;
            }
            else {
                alert("Não foi possivel fazer o upload do seu arquivo");
                return false;
            }
        })
        .fail(function ( data ) {
            if( data.status === 422 ) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(key+ " " +value);
                    $('#response').addClass("alert alert-danger");

                    if($.isPlainObject(value)) {
                        $.each(value, function (key, value) {                       
                            console.log(key+ " " +value);
                        $('#response').show().append(value+"<br/>");

                        });
                    }else{
                    $('#response').show().append(value+"<br/>"); //this is my div with messages
                    }
                });
            }
        })
    });

    $("#lancarArquivoEndereco").click(function () {
        if ($("#arquivoEndereco").val() == "") {
            alert("Por favor selecione o Comprovante Residência para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoEndereco');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];


        if (file.size > 2048000) {
            alert("O arquivo deve ter no máximo 2Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='formEndereco']")[0]);
        var $descricao = dados.get("DescrDoc");
        console.log("desc: " + $descricao);
        console.log(dados);

        $.ajax({
            type: 'POST',
            url: "{{ url('/cadastro_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                documentosEnderecoTbl.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                documentosEnderecoTbl.columns.adjust().draw();
                $("#arquivoEndereco").val("");
                $arq09 = true;
            }
            else {
                alert("Não foi possivel fazer o upload do seu arquivo");
                return false;
            }
        })
        .fail(function ( data ) {
            if( data.status === 422 ) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    console.log(key+ " " +value);
                    $('#response').addClass("alert alert-danger");

                    if($.isPlainObject(value)) {
                        $.each(value, function (key, value) {                       
                            console.log(key+ " " +value);
                        $('#response').show().append(value+"<br/>");

                        });
                    }else{
                    $('#response').show().append(value+"<br/>"); //this is my div with messages
                    }
                });
            }
        })
    });

    $('#documentosLancadosPF').on("click", "button", function () {
        $("#mdlAguarde").modal('toggle');

        var row = $(this).parents('tr').data();
        var tipo = documentosLancadosPF.row($(this).parents('tr')).data()[0];
        var nomeArquivo = documentosLancadosPF.row($(this).parents('tr')).data()[2];
        documentosLancadosPF.row($(this).parents('tr')).remove().draw(false);

        switch(tipo) {
            case "CPF":
                $arq01=false;
                break;
            case "Identidade":
                $arq02=false;
                break;
            case "Comprovante de Vínculo":
                $arq04=false;
                break;
            case "Selfie de Identificação":
                $arq07=false;
                break;
        }
        $.get("{{ url('/cadastro_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

            $("#mdlAguarde").modal('toggle');

        })
    });

    $('#documentosLancadosReq').on("click", "button", function () {
        $("#mdlAguarde").modal('toggle');

        var row = $(this).parents('tr').data();
        var tipo = documentosLancadosReq.row($(this).parents('tr')).data()[0];
        var nomeArquivo = documentosLancadosReq.row($(this).parents('tr')).data()[2];
        documentosLancadosReq.row($(this).parents('tr')).remove().draw(false);

        $.get("{{ url('/cadastro_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

            $("#mdlAguarde").modal('toggle');

        })
    });

    $('#documentosPJTbl').on("click", "button", function () {
        $("#mdlAguarde").modal('toggle');

        var row = $(this).parents('tr').data();
        var tipo = documentosPJTbl.row($(this).parents('tr')).data()[0];
        var nomeArquivo = documentosPJTbl.row($(this).parents('tr')).data()[2];
        documentosPJTbl.row($(this).parents('tr')).remove().draw(false);

        switch(tipo) {
            case "Contrato Social":
                $arq05=false;
                break;
            case "Documento de Identidade do Sócio":
                $arq06=false;
                break;
            case "CPF do Sócio":
                $arq07=false;
                break;
        }
        $.get("{{ url('/cadastro_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

            $("#mdlAguarde").modal('toggle');

        })
    });

    $('#documentosEnderecoTbl').on("click", "button", function () {
        $("#mdlAguarde").modal('toggle');

        var row = $(this).parents('tr').data();
        var tipo = documentosEnderecoTbl.row($(this).parents('tr')).data()[0];
        var nomeArquivo = documentosEnderecoTbl.row($(this).parents('tr')).data()[2];
        documentosEnderecoTbl.row($(this).parents('tr')).remove().draw(false);

        switch(tipo) {
            case "Comprovante de Endereço":
                $arq09=false;
                break;
        }
        $.get("{{ url('/cadastro_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

            $("#mdlAguarde").modal('toggle');

        })
    });

    $('#documentosVinculo').on("click", "button", function () {
        $("#mdlAguarde").modal('toggle');

        var row = $(this).parents('tr').data();
        var tipo = documentosVinculo.row($(this).parents('tr')).data()[0];
        var nomeArquivo = documentosVinculo.row($(this).parents('tr')).data()[2];
        documentosVinculo.row($(this).parents('tr')).remove().draw(false);

        switch(tipo) {
            case "CPF":
                $arq01=false;
                break;
            case "Identidade":
                $arq02=false;
                break;
            case "Comprovante de Endereço":
                $arq03=false;
                break;
            case "Comprovante de Vínculo":
                $arq04=false;
                break;
        }
        $.get("{{ url('/cadastro_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

            $("#mdlAguarde").modal('toggle');

        })
    });

    $('#matriculaImoveis').on("click", "button", function () {
        matriculaImoveis.row($(this).parents('tr')).remove().draw(false);
    });

    
    
    $("#btn_consultar").click(function(){
        if ($("#cep").val() == ""){
            alert("Informe o CEP");
            return false;
        }
        else{
            $("#mdlAguarde").modal('toggle');
            var cep = $("#cep").val().replace(/[^0-9]/, '');
            var cep = $("#cep").val().replace(/[^0-9]/g, '');
            if(cep){


                var url = 'https://viacep.com.br/ws/' + cep + '/json/';
                
                $.get( url,  function(resposta){
                    // var obj = jQuery.parseJSON(resposta);
                    if(resposta.logradouro){
                        // if (obj.localidade.toUpperCase() == "MARICÁ" || obj.localidade.toUpperCase() == "MARICA"){
                            $("#numero").focus();
    
                            $("#logradouro").val(resposta.logradouro);
                            $("#bairro").val(resposta.bairro);
                            $("#cidade").val(resposta.localidade);
                            $("#uf").val(resposta.uf);
                            
                            $("#logradouro").prop('readonly', false);
                            $("#bairro").prop('readonly', true);
                            $("#cidade").prop('readonly', true);
                            $("#uf").prop('disabled', true);
                        // }
                        // else{
                        //     $("#logradouro").val("");
                        //     $("#bairro").val("");
                        //     $("#cidade").val("");
                        //     $("#uf").val("");

                        //     alert("Só é possível cadastrar CEP de Maricá!");
                        // }
                    }
                    else if(resposta.erro){
                        alert("CEP não encontrado ou inválido!");
                    }
                })
                .fail(function() {
                    alert("CEP não encontrado ou inválido!");
                })
                .always(function() {
                    $("#mdlAguarde").modal('toggle');
                });
               
            }					
        }
    });	

    function validadataNascimento3(valor){
        var date=valor;
        var ardt=new Array;
        var ExpReg=new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
        ardt=date.split("/");
        erro=false;
        if ( date.search(ExpReg)==-1){
            erro = true;
            }
        else if (((ardt[1]==4)||(ardt[1]==6)||(ardt[1]==9)||(ardt[1]==11))&&(ardt[0]>30))
            erro = true;
        else if ( ardt[1]==2) {
            if ((ardt[0]>28)&&((ardt[2]%4)!=0))
                erro = true;
            if ((ardt[0]>29)&&((ardt[2]%4)==0))
                erro = true;
        }
        if (erro) {
            return false;
        }

        var hoje = new Date();

        datan = valor.replace(/\//g, "-"); // substitui eventuais barras (ex. IE) "/" por hífen "-"
        var data_array = datan.split("-"); // quebra a data em array
        datan = data_array[2]+"-"+data_array[1]+"-"+data_array[0];

        var nasc  = new Date(datan);

        if(nasc >= hoje){
            return false;
        }

        return true;
    }
    
    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');

        if (cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        var tamanho = cnpj.length - 2
        var numeros = cnpj.substring(0, tamanho);
        var digitos = cnpj.substring(tamanho);
        var soma = 0;
        var pos = tamanho - 7;
        for (var i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (var i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;
    }

    function validarCPF(cpf) {
        var add;
        var rev;
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf == '') return false;
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
        for (var i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return false;
        // Valida 2o digito	
        add = 0;
        for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
            return false;
        return true;
    }
    
    
    function validaEmail(email){

        var usuario = email.substring(0, email.indexOf("@"));
        var dominio = email.substring(email.indexOf("@")+ 1, email.length);

        if ((usuario.length >=1) &&
            (dominio.length >=3) && 
            (usuario.search("@")==-1) && 
            (dominio.search("@")==-1) &&
            (usuario.search(" ")==-1) && 
            (dominio.search(" ")==-1) &&
            (dominio.search(".")!=-1) &&      
            (dominio.indexOf(".") >=1)&& 
            (dominio.lastIndexOf(".") < dominio.length - 1)) {
            return true;
        }
        else{
            return false;
        }
    }



</script>
@endsection