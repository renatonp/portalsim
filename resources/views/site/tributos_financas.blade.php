@extends('layouts.marica')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Tributos e Financas</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <select id="assunto" class="servico">
                                <option value="">Escolha o Assunto</option>
                                <option value="iptu">IPTU</option>
                                <option value="iss">ISS</option>
                            </select>
                        </div>
                        <div class="col-md-6">
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
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var escolha = "";

        $("#continuar").click(function(){
            
            var url = "{{URL::to(':route')}}";
            if(escolha == 1){
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
                escolha = 1;
            }
            else{
                $("#continuar").hide();
                escolha = "";
            }
        });
        $("#servico_02").change(function(){
            if($("#servico_02").val()!=""){
                $("#continuar").show();
                escolha = 2;
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
</script>
@endsection
