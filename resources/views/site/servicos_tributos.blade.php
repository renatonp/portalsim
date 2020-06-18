@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>TRIBUTOS E FINANÇAS</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">Tributos e Finanças</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section id="content">
    <div class="container">
        <div class="tabbable tabs-left">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#topone" data-toggle="tab"> IPTU</a></li>
                <li><a href="#toptwo" data-toggle="tab">INSS</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="topone">
                    <div class="tab-interna">
                        <div class="titulo-servico">
                            <h2>
                                IPTU
                            </h2>
                        </div>
                        <p>
                            Escolha o seu <strong>Serviço</strong> e clique no botão "Continuar":
                        </p>
                        <p>
                            <select id="servico_03-doc" class="servico-opcoes">
                                <option value="iptu_abatimento">Abatimento</option>
                                <option value="iptu_cadastramento">Cadastramento CPF/CNPJ</option>
                            </select>
                        </p>
                        <div class="align-right" >
                            <button type="button" class="btn btn-theme e_wiggle" id="continuar-iptu">
                                {{ __('Continuar') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="toptwo">
                    <div class="tab-interna">
                        <div class="titulo-servico">
                            <h2>
                                ISS
                            </h2>
                        </div>
                        <p>
                            Escolha o seu <strong>Serviço</strong> e clique no botão "Continuar":
                        </p>
                        <p>
                            <select id="servico_04-doc" class="servico-opcoes">
                                <option value="iss_guia">Guia: Alterações</option>
                                <option value="iss_pagamento">Pagamento: Prazos</option>
                            </select>
                        </p>
                        <div class="align-right" >
                            <button type="button" class="btn btn-theme e_wiggle" id="continuar-iss">
                                {{ __('Continuar') }}
                            </button>
                        </div>                    
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Serviços
                </div>
                <div class="card-body card-servicos">
                    <button type="button" class="btn bnt-servicos" id="btn-doc">
                        {{ __('Documentos e Processos') }}
                    </button>
                    <button type="button" class="btn bnt-servicos" id="btn-fin">
                        {{ __('Tributos e Finanças') }}
                    </button>
                </div>
            </div>
        </div>


        <div class="col-md-8">
            <div class="card" id="doc-proc" style="display: none;">
                <div class="card-header">Documentos e Processos</div>
                   
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <select id="assunto-doc" class="servico">
                                <option value="">Escolha o Assunto</option>
                                <option value="alvara">Alvará</option>
                                <option value="Cert">Certidão</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <select id="servico_01-doc" style="display: none;" class="servico">
                                <option value="">Escolha o Serviço</option>
                                <option value="alvara_consulta">Consulta de Alvará</option>
                                <option value="alvara_certidao">Certidão de Ausência de Atividade Econômica</option>
                            </select>

                            <select id="servico_02-doc" style="display: none;" class="servico">
                                <option value="">Escolha o Serviço</option>
                                <option value="certidao">Certidão Negativa de Débito</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12 right-align" >
                        <button type="button" class="btn bnt-cadastro" id="continuar-doc" style="display: none;">
                            {{ __('Continuar') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="card" id="trib-fin" style="display: none;">
                <div class="card-header">Tributos e Financas</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <select id="assunto" class="servico">
                                <option value="">Escolha o Assunto</option>
                                <option value="iptu">IPTU</option>
                                <option value="iss">ISS</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <select id="servico_01" style="display: none;" class="servico">
                                <option value="">Escolha o Serviço</option>
                                <option value="iptu_abatimento">Abatimento</option>
                                <option value="iptu_cadastramento">Cadastramento CPF/CNPJ</option>
                            </select>
                            <select id="servico_02" style="display: none;" class="servico">
                                <option value="">Escolha o Serviço</option>
                                <option value="iss_guia">Guia: Alterações</option>
                                <option value="iss_pagamento">Pagamento: Prazos</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12 right-align">
                        <button type="submit" class="btn bnt-cadastro" id="continuar" style="display: none;">
                            {{ __('Continuar') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<br>
<br>
<br>
<br>
{{-- <script type="text/javascript">
    jQuery(document).ready(function(){
        var escolha = "";

        $("#btn-doc").click(function(){
            $("#doc-proc").show();
            $("#trib-fin").hide();
        });

        $("#btn-fin").click(function(){
            $("#doc-proc").hide();
            $("#trib-fin").show();
        });

        $("#continuar-doc").click(function(){
            
            var url = "{{URL::to(':route')}}";
            if(escolha == 1){
                url = url.replace(':route', $("#servico_01-doc").val());
            }
            else{
                url = url.replace(':route', $("#servico_02-doc").val());
            }
            window.location.href = url;
        })

        $("#servico_01-doc").change(function(){
            if($("#servico_01-doc").val()!=""){
                $("#continuar-doc").show();
                escolha = 1;
            }
            else{
                $("#continuar-doc").hide();
                escolha = "";
            }
        });
        $("#servico_02-doc").change(function(){
            if($("#servico_02").val()!=""){
                $("#continuar-doc").show();
                escolha = 2;
            }
            else{
                $("#continuar-doc").hide();
                escolha = "";
            }
        });
        $("#assunto-doc").change(function(){
            if($("#assunto-doc").val()==""){
                $("#servico_01-doc").hide();
                $("#servico_02-doc").hide();
            }
            else if($("#assunto-doc").val()=="alvara"){
                $("#servico_02-doc").hide();
                $("#servico_01-doc").show();
            }
            else if($("#assunto-doc").val()=="Cert"){
                $("#servico_01-doc").hide();
                $("#servico_02-doc").show();
            }
        });


        $("#continuar").click(function(){
            
            var url = "{{URL::to(':route')}}";
            if(escolha == 3){
                url = url.replace(':route', $("#servico_01").val());
            }
            else{
                url = url.replace(':route', $("#servico_02").val());
            }
            window.location.href = url;
        })

        $("#servico_01").change(function(){
            if($("#servico_01").val()!=""){
                $("#continuar").show();
                escolha = 3;
            }
            else{
                $("#continuar").hide();
                escolha = "";
            }
        });
        $("#servico_02").change(function(){
            if($("#servico_02").val()!=""){
                $("#continuar").show();
                escolha = 4;
            }
            else{
                $("#continuar").hide();
                escolha = "";
            }
        });
        $("#assunto").change(function(){
            if($("#assunto").val()==""){
                $("#texto_servico").hide();
                $("#servico_01").hide();
                $("#servico_02").hide();
            }
            else if($("#assunto").val()=="iptu"){
                $("#texto_servico").show();
                $("#servico_02").hide();
                $("#servico_01").show();
            }
            else if($("#assunto").val()=="iss"){
                $("#texto_servico").show();
                $("#servico_01").hide();
                $("#servico_02").show();
            }
        });
    });
</script> --}}
@endsection
