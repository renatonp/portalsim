@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('Lançamento de ITBI') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Lançamento de ITBI') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card" style="border: 0">
                        <div class="card-body">


                            <div class="accordion" id="accordion4">
                                {{-- 
                                ***********************************
                                *** Dados do Imóvel
                                ***********************************
                                --}}
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseOne2">
                                            <i class="icon-minus"></i> Dados do Imóvel
                                        </a>
                                    </div>
                                    <div id="collapseOne2" class="accordion-body collapse in">
                                        @include('itbi.cadastro')
                                    </div>
                                </div>

                                {{-- 
                                ***********************************
                                *** Transação
                                ***********************************
                                --}}
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseTwo2">
                                        <i class="icon-plus"></i> Transação
                                    </a>
                                </div>
                                <div id="collapseTwo2" class="accordion-body collapse">
                                    @include('itbi.transacao')
                                </div>

                                {{-- 
                                ***********************************
                                *** Transmitente
                                ***********************************
                                --}}
                                @if(!$edicao)
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4"
                                        href="#collapseThree2">
                                        <i class="icon-plus"></i> Transmitentes
                                    </a>
                                </div>
                                <div id="collapseThree2" class="accordion-body collapse">
                                    @include('itbi.transmitente')
                                </div>
                                @endif
                                {{-- 
                                ***********************************
                                *** Adquirentes
                                ***********************************
                                --}}
                                @if(!$edicao)
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4"
                                        href="#collapseFour2">
                                        <i class="icon-plus"></i> Adquirentes
                                    </a>
                                </div>
                                <div id="collapseFour2" class="accordion-body collapse">
                                    @include('itbi.adquirente')
                                </div>
                                @endif
                                {{-- 
                                ***********************************
                                *** Intermediadores
                                ***********************************
                                --}}
                                {{-- <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4"
                                        href="#collapseFive2">
                                        <i class="icon-plus"></i> Intermediadores
                                </div>
                                <div id="collapseFive2" class="accordion-body collapse">
                                    @include('itbi.emconstrucao')
                                </div> --}}
                                {{-- 
                                ***********************************
                                *** Documentação em Anexo
                                ***********************************
                                --}}
                                {{-- <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4"
                                        href="#collapseSix2">
                                        <i class="icon-plus"></i> Documentação em Anexo
                                    </a>
                                </div>
                                <div id="collapseSix2" class="accordion-body collapse">
                                    @include('itbi.documentos')
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="border: 0">
                <div class="card-body">
                    <div class="span5 text-left">
                        <a href="{{ url('/lancamentoITBI') }}">
                            <button type="button" class="btn btn-theme e_wiggle" id="voltar">
                                {{ __('Voltar') }}
                            </button>
                        <a>
                    </div>

                    <div class="span6 text-right">
                        <button type="button" class="btn btn-theme e_wiggle" id="lancarITBI">
                            {{ __('Lançar ITBI') }}
                        </button>
                    </div>
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

    var cpf_adq_options = {
        onKeyPress: function (cpf, e, field, cpf_adq_options) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = (cpf.length > 14 || cpf.length == 0) ? masks[1] : masks[0];
            $('#adqCPF').mask(mask, cpf_adq_options);
        }
    };

    if (typeof ($("#adqCPF")) !== "undefined") {
        $("#adqCPF").mask('00.000.000/0000-00', cpf_adq_options);
    }
    
    $("#adqNum").mask("#####0");
    $("#adqTel").mask('(00)0000-0000');
    $("#adqCel").mask("(00)00000-0009");
    $("#adqCEP").mask("00.000-000");
    $("#imovelCep").mask("00.000-000");
    $("#percentualTransferido").mask("990", {reverse: true});
    $("#valorDeclarado").mask('#.##0,00', {reverse: true});
    if($("#valorDeclarado").val().charAt(0)=="."){
        $("#valorDeclarado").val( $("#valorDeclarado").val().replace(".", ""));
    }
    // $("#valorFinanciado").mask("000.000.000.000,00", {reverse: true});


    // $("#natureza").change(function(){
        
    //     $("#mdlAguarde").modal('toggle');


    //     var url = "{{ url('/listaFormasPagamento')}}" + "/" + $("#natureza").val() + "/" + $("#matricula").val();

    //     $.get( url,  function(resposta){
    //         var obj = jQuery.parseJSON(resposta);
    //         console.log(obj);
                
    //         $("#mdlAguarde").modal('toggle');
    //     });

    // });

    $("#transacaoParcial").click(function(){
        if ($("#transacaoParcial").is(":checked")) {
            $("#percentualTransferido").val("");
            $("#percentualTransferido").prop("readonly", false);
        }
        else{
            $("#percentualTransferido").val("100");
            $("#percentualTransferido").prop("readonly", true);
        }
    });
    
    $("#adqCPF").focusin(function(){
        $("#adqCPF").val("");
        $("#adqNome").prop('readonly', true);
        $("#adqTel").prop('readonly', true);
        $("#adqCel").prop('readonly', true);
        $("#adqCEP").prop('readonly', true);
        $("#adqEndereco").prop('readonly', true);
        $("#adqNum").prop('readonly', true);
        $("#adqCompl").prop('readonly', true);
        $("#adqBairro").prop('readonly', true);
        $("#adqMunicipio").prop('readonly', true);
        $("#adqEstado").prop('readonly', true);
        $("#adqEmail").prop('readonly', true);
        $("#buscaCep").prop('disabled', true);
        $("#adqPrincipal").prop('checked', false);

        $("#adqNome").val('');
        $("#adqTel").val('');
        $("#adqCel").val('');
        $("#adqCGM").val('');
        $("#adqCEP").val('');
        $("#adqEndereco").val('');
        $("#adqNum").val('');
        $("#adqCompl").val('');
        $("#adqBairro").val('');
        $("#adqMunicipio").val('');
        $("#adqEstado").val('');
        $("#adqEmail").val('');
        $("#adqCPF").val("");
        $("#dadosAdq").show();
    });
        
    var lancarITBIEnviado = false;

    $("#lancarITBI").click(function(){
        console.log(lancarITBIEnviado);
        if(!lancarITBIEnviado){
            lancarITBIEnviado = true;
            $("#lancarITBI").prop('disabled', true);

            if( !$("#edicao").val() ){
            
                var adq = "";
                var principal = false;
                tbladquirentes.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    this.data().forEach(function(column, $posicao) {
                        if ($posicao == 13){
                            if(column == "SIM"){
                                principal = true;
                            }
                        }
                    });
                    if(adq.length > 0 ){
                        adq += "|"
                    }
                    adq += JSON.stringify(this.data());
                });
                if( adq.length == 0){
                    alert("Por favor informe o(s) adquirente(s) do imóvel");
                    lancarITBIEnviado = false;
                    $("#lancarITBI").prop('disabled', false);
                    
                    $("#collapseFour2").collapse('show');
                    $("#adqCPF").val("");
                    $("#adqCPF").focus();
                    return false;
                }
                if(!principal){
                    alert("Não existe nenhum adquirente marcado como principal. \nPor favor Informe quem é o Adquirente Principal");
                    lancarITBIEnviado = false;
                    $("#lancarITBI").prop('disabled', false);
                    $("#collapseFour2").collapse('show');
                    return false;
                }
                $("#adquirentes").val(adq);
                var docsadq = "";
                documentosAdquirente.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    if(docsadq.length > 0 ){
                        docsadq += "|"
                    }
                    docsadq += JSON.stringify(this.data());
                });
                if( docsadq.length == 0){
                    alert("Por favor faça o upload dos documentos do Adquirente.");
                    lancarITBIEnviado = false;
                    $("#lancarITBI").prop('disabled', false);
                    $("#collapseFour2").collapse('show');
                    $("#descricaoAdquirente").val("");
                    $("#descricaoAdquirente").focus();
                    return false;
                }		
                $("#documentosAdquirentes").val(docsadq);

                var trans = "";
                tbltransmitentes.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    if(trans.length > 0 ){
                        trans += "|"
                    }
                    trans += JSON.stringify(this.data());
                });
                $("#transmitentes").val(trans);

                var docstrans = "";
                documentosTransmitente.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    if(docstrans.length > 0 ){
                        docstrans += "|"
                    }
                    docstrans += JSON.stringify(this.data());
                });
                if( docstrans.length == 0){
                    alert("Por favor faça o upload dos documentos do Transmitente.");
                    lancarITBIEnviado = false;
                    $("#lancarITBI").prop('disabled', false);
                    $("#collapseThree2").collapse('show');
                    $("#descricaoTransmitente").val("");
                    $("#descricaoTransmitente").focus();
                    return false;
                }		
                $("#documentostransmitentes").val(docstrans);

                var docsImovel = "";
                documentosImovel.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    if(docsImovel.length > 0 ){
                        docsImovel += "|"
                    }
                    docsImovel += JSON.stringify(this.data());
                });
                $("#txtdocumentosimovel").val(docsImovel);
            }

            // alert("1");
            // return false;

            var docstransacao = "";
            documentosTransacao.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                if(docstransacao.length > 0 ){
                    docstransacao += "|"
                }
                docstransacao += JSON.stringify(this.data());
            });
            if( docstransacao.length == 0){
                alert("Por favor faça o upload dos documentos da Transação.");
                lancarITBIEnviado = false;
                $("#lancarITBI").prop('disabled', false);
                $("#collapseTwo2").collapse('show');
                $("#descricaoTransacao").val("");
                $("#descricaoTransacao").focus();
                return false;
            }		
            $("#txtdocumentosTransacao").val(docstransacao);


            if( $("#transacao").val().length == 0){
                alert("Por favor Informe o Tipo da Transação.");
                lancarITBIEnviado = false;
                $("#lancarITBI").prop('disabled', false);
                $("#collapseTwo2").collapse('show');
                $("#transacao").val("");
                $("#transacao").focus();
                return false;
            }	

            if( $("#natureza").val().length == 0){
                alert("Por favor Informe a Natureza da Transação.");
                lancarITBIEnviado = false;
                $("#lancarITBI").prop('disabled', false);
                $("#collapseTwo2").collapse('show');
                $("#natureza").val("");
                $("#natureza").focus();
                return false;
            }	

            if( $("#valorDeclarado").val().length == 0){
                alert("Por favor Informe o Valor Declarado da Transação.");
                lancarITBIEnviado = false;
                $("#lancarITBI").prop('disabled', false);
                $("#collapseTwo2").collapse('show');
                $("#valorDeclarado").val("");
                $("#valorDeclarado").focus();
                return false;
            }

            if( $("#percentualTransferido").val().length == 0){
                alert("Por favor Informe o Percentual a ser transferido na Transação.");
                lancarITBIEnviado = false;
                $("#lancarITBI").prop('disabled', false);
                $("#collapseTwo2").collapse('show');
                $("#percentualTransferido").val("");
                $("#percentualTransferido").focus();
                return false;
            }

            $("#cadtransacao").val($("#transacao").val());
            $("#cadnatureza").val($("#natureza").val());
            $("#cadnumGuia").val($("#numGuia").val());
            $("#cadpercentualTransferido").val($("#percentualTransferido").val());
            $("#cadvalorDeclarado").val($("#valorDeclarado").val());
            // $("#cadvalorFinanciado").val($("#valorFinanciado").val());
            $("#cadobservacoes").val($("#observacoes").val());

            if ($("#transacaoParcial").is(":checked")) { 
                $("#cadtransacaoParcial").val("TRUE"); 
            }
            else{
                $("#cadtransacaoParcial").val(""); 
            }
            
            $("#mdlAguarde").modal('toggle');

            $("#formITBI").submit();
        }
        else{
            console.log("Segundo envio");
        }

    });

    $("#percentualTransferido").focusout(function(){
        if($("#percentualTransferido").val() != ""){
            if($("#percentualTransferido").val() > 100){
                alert("O percentual a ser transferido não pode ser superior a 100%");
                $("#percentualTransferido").val("");
                $("#percentualTransferido").focus();
            }
        }
    });

    $("#incluirAdquirente").click(function(){
        if ($("#adqNome").val() == ""){
            alert("Por favor, informe o nome");
            $("#adqNome").focus();
            return false;
        }
        if (!$("#adqCEP").prop('readonly')){
            if ($("#adqCEP").val() == ""){
                alert("Por favor, informe o CEP");
                $("#adqCEP").focus();
                return false;
            }
        }
        if (!$("#adqEndereco").prop('readonly')){
            if ($("#adqEndereco").val() == ""){
                alert("Por favor, informe o endereço");
                $("#adqEndereco").focus();
                return false;
            }
        }
        if (!$("#adqTel").prop('readonly')){
            if ($("#adqTel").val() == "" && !$("#adqCel").prop('readonly')){
                alert("Por favor, informe o número do seu telefone");
                $("#adqTel").focus();
                return false;
            }
        }
        if (!$("#adqCel").prop('readonly')){
            if ($("#adqCel").val() == "" && !$("#adqCel").prop('readonly')){
                alert("Por favor, informe o número do seu celular");
                $("#adqCel").focus();
                return false;
            }
        }
        if (!$("#adqEmail").prop('readonly')){
            if ($("#adqEmail").val() == ""){
                alert("Por favor, informe o e-mail");
                $("#adqEmail").focus();
                return false;
            }
            if (!IsEmail($("#adqEmail").val())){
                alert("Email Inválido.  Por favor, informe o e-mail corretamente.");
                $("#adqEmail").focus();
                return false;
            }
        }

        if($("#adqPrincipal").is(":checked")){
            var principal = false
            tbladquirentes.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                this.data().forEach(function(column, $posicao) {
                    if ($posicao == 13){
                        console.log('row ' + rowIdx + ' column ' + $posicao + ' value ' + column);
                        if(column == "SIM"){
                            principal = true;
                        }
                    }
                });
            });
            if(principal){
                alert("Já existe um adquirente marcado como principal");
                return false;
            }
        }

        tbladquirentesDisplay.row.add([
            $("#adqCPF").val(),
            $("#adqNome").val(),
            $("#adqCGM").val(),
            ($("#adqPrincipal").is(":checked")?"SIM":"NÃO"),
            '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
        ]).draw(false);
        tbladquirentesDisplay.columns.adjust().draw();

        tbladquirentes.row.add([
            $("#adqCPF").val(),
            $("#adqNome").val(),
            $("#adqTel").val(),
            $("#adqCel").val(),
            $("#adqCGM").val(),
            $("#adqCEP").val(),
            $("#adqEndereco").val(),
            $("#adqNum").val(),
            $("#adqCompl").val(),
            $("#adqBairro").val(),
            $("#adqMunicipio").val(),
            $("#adqEstado").val(),
            $("#adqEmail").val(),
            ($("#adqPrincipal").is(":checked")?"SIM":"NÃO"),
            '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
        ]).draw(false);
        tbladquirentes.columns.adjust().draw();

        $("#adqNome").prop('readonly', true);
        $("#adqTel").prop('readonly', true);
        $("#adqCel").prop('readonly', true);
        $("#adqCEP").prop('readonly', true);
        $("#adqEndereco").prop('readonly', true);
        $("#adqNum").prop('readonly', true);
        $("#adqCompl").prop('readonly', true);
        $("#adqBairro").prop('readonly', true);
        $("#adqMunicipio").prop('readonly', true);
        $("#adqEstado").prop('readonly', true);
        $("#adqEmail").prop('readonly', true);
        $("#buscaCep").prop('disabled', true);
        $("#adqPrincipal").prop('checked', false);

        $("#adqNome").val('');
        $("#adqTel").val('');
        $("#adqCel").val('');
        $("#adqCGM").val('');
        $("#adqCEP").val('');
        $("#adqEndereco").val('');
        $("#adqNum").val('');
        $("#adqCompl").val('');
        $("#adqBairro").val('');
        $("#adqMunicipio").val('');
        $("#adqEstado").val('');
        $("#adqEmail").val('');
        $("#adqCPF").val("");
        $("#dadosAdq").show();
        $("#adqCPF").focus();
    });

    $('#tbladquirentesDisplay').on("click", "button", function () {
        var cpfAdq = tbladquirentesDisplay.row( $(this).parents('tr') ).data()[0];
        tbladquirentes.rows( function ( idx, data, node ) {
            return data[0] ===  cpfAdq;
        } )
        .remove()
        .draw();
        tbladquirentesDisplay.row($(this).parents('tr')).remove().draw(false);
    });
    
    $("#pesquisarAdquirente").click(function(){

        $("#mdlAguarde").modal('toggle');

        if ($("#adqCPF").val().length == 14) {

            if (validarCPF($("#adqCPF").val())) {
            // 
            }
            else {
                $("#mdlAguarde").modal('toggle');
                alert("CPF Inválido!  Favor informar um CPF válido.");
                $("#adqCPF").focus()
                return false
            }
        }
        else if ($("#adqCPF").val().length == 18) {
            if (validarCNPJ($("#adqCPF").val())) {
            //    
            }
            else {
                $("#mdlAguarde").modal('toggle');
                alert("CNPJ Inválido!  Favor informar um CNPJ válido.");
                $("#adqCPF").focus()
                return false
            }
        }
        else {
            $("#mdlAguarde").modal('toggle');
            alert("Por favor, Favor informar um CPF ou CNPJ válido.");
            $("#adqCPF").focus()
            return false
        }

        var url = "{{  url('/itbiconsultaCGM') }}" + "/" + $("#adqCPF").val().replace("/", '');
        
        $.get(url, function (resposta) {
            // console.log(resposta);
            var obj = jQuery.parseJSON(resposta);
            if (obj.cgm.iStatus == 1) {
                if( !obj.cgm.sSqlerro ){ // O CPF do Adquirente está cadastro no CGM
                    $("#adqNome").val(unescape(obj.cgm.aCgmPessoais.z01_nome).replace(/[+]/g, " ") );
                    $("#adqTel").val(unescape(obj.cgm.aCgmContato.z01_telef).replace(/[+]/g, " "));
                    $("#adqCel").val(unescape(obj.cgm.aCgmContato.z01_telcel).replace(/[+]/g, " "));
                    $("#adqCGM").val(unescape(obj.cgm.cgm).replace(/[+]/g, " "));
                    $("#adqCEP").val(unescape(obj.endereco.endereco.iCep).replace(/[+]/g, " "));
                    $("#adqEndereco").val(unescape(obj.endereco.endereco.sRua).replace(/[+]/g, " "));
                    $("#adqNum").val(unescape(obj.endereco.endereco.sNumeroLocal).replace(/[+]/g, " "));
                    $("#adqCompl").val(unescape(obj.endereco.endereco.sComplemento).replace(/[+]/g, " "));
                    $("#adqBairro").val(unescape(obj.endereco.endereco.sBairro).replace(/[+]/g, " "));
                    $("#adqMunicipio").val(unescape(obj.endereco.endereco.sMunicipio).replace(/[+]/g, " "));
                    $("#adqEstado").val(converteEstadoSigla(unescape(obj.endereco.endereco.sEstado).replace(/[+]/g, " ")));
                    $("#adqEmail").val(unescape(obj.cgm.aCgmContato.z01_email).replace(/[+]/g, " "));
                    
                    $("#adqNome").prop('readonly', true);
                    $("#adqTel").prop('readonly', true);
                    $("#adqCel").prop('readonly', true);
                    $("#adqCEP").prop('readonly', true);
                    $("#adqEndereco").prop('readonly', true);
                    $("#adqNum").prop('readonly', true);
                    $("#adqCompl").prop('readonly', true);
                    $("#adqBairro").prop('readonly', true);
                    $("#adqMunicipio").prop('readonly', true);
                    $("#adqEstado").prop('readonly', true);
                    $("#adqEmail").prop('readonly', true);
                    $("#buscaCep").prop('disabled', true);
                    $("#buscaCep").addClass("btn-theme");

                    $("#dadosAdq").hide();

                }
                else {
                    $("#mdlAguarde").modal('toggle');
                    alert("Não foi possivel fazer a consulta do CPF do adquirente");
                    $("#adqCPF").focus();
                    return false;
                }
            }
            else{ // Adquirente não Cadastrado - Liberar para efetuar o cadastro manual

                $("#adqNome").val('');
                $("#adqTel").val('');
                $("#adqCel").val('');
                $("#adqCGM").val('');
                $("#adqCEP").val('');
                $("#adqEndereco").val('');
                $("#adqNum").val('');
                $("#adqCompl").val('');
                $("#adqBairro").val('');
                $("#adqMunicipio").val('');
                $("#adqEstado").val('');
                $("#adqEmail").val('');
                $("#dadosAdq").show();

                $("#adqNome").prop('readonly', false);
                $("#adqTel").prop('readonly', false);
                $("#adqCel").prop('readonly', false);
                $("#adqCEP").prop('readonly', false);
                $("#adqEndereco").prop('readonly', false);
                $("#adqNum").prop('readonly', false);
                $("#adqCompl").prop('readonly', false);
                $("#adqBairro").prop('readonly', false);
                $("#adqMunicipio").prop('readonly', false);
                $("#adqEstado").prop('readonly', false);
                $("#adqEmail").prop('readonly', false);
                $("#buscaCep").prop('disabled', false);
                $("#buscaCep").addClass("btn-theme");


                $("#dadosAdq").show();
                $("#adqNome").focus();
            }
            $("#incluirAdquirente").prop('disabled', false);

            $("#mdlAguarde").modal('toggle');
        });



    });

    
    $("#buscaCep").click(function(){
        if ($("#adqCEP").val() == ""){
            alert("Informe o CEP");
            return false;
        }
        else{
            $("#mdlAguarde").modal('toggle');
            var cep = $("#adqCEP").val().replace(/[^0-9]/, '');
            if(cep){
                var url = "{{  url('consultaCEPcgm/') }}" + '/' + cep;
                
                $.get( url,  function(resposta){
                    var obj = jQuery.parseJSON(resposta);
                    console.log(obj);
                    if(obj.logradouro){
                        $("#mdlAguarde").modal('toggle');
                        $("#adqEndereco").val(obj.logradouro);
                        $("#adqBairro").val(obj.bairro);
                        $("#adqMunicipio").val(obj.localidade);
                        $("#adqEstado").prop('readonly', true);
                        $("#adqEndereco").prop('readonly', true);
                        $("#adqBairro").prop('readonly', true);
                        $("#adqMunicipio").prop('readonly', true);
                        $("#adqEstado").prop('readonly', true);
                        $("#adqNum").focus();
                    }
                    else{
                        $("#mdlAguarde").modal('toggle');
                        alert("O CEP informado não é válido!");
                        return false;
                    }
                });
            }					
        }
    });	

    var lancarArquivoImovelEnviado = false;

    $("#lancarArquivoImovel").click(function () {
        console.log(lancarArquivoImovelEnviado);
        if(!lancarArquivoImovelEnviado){
            lancarArquivoImovelEnviado = true;
            $("#lancarArquivoImovel").prop('disabled', true);

            if ($("#descricaoImovel").val() == "") {
                alert("Por favor informe a descrição deste documento");
                lancarArquivoImovelEnviado = false;
                $("#lancarArquivoImovel").prop('disabled', false);

                $("#descricaoImovel").focus();
                return false;
            }
            if ($("#fileImovel").val() == "") {
                alert("Por favor escolha um documento para enviar");
                lancarArquivoImovelEnviado = false;
                $("#lancarArquivoImovel").prop('disabled', false);

                $("#fileImovel").focus();
                return false;
            }
            
            var $input, file, $arquivo, $tamanho, $ext;

            $input = document.getElementById('fileImovel');

            if (!window.FileReader) {
                lancarArquivoImovelEnviado = false;
                $("#lancarArquivoImovel").prop('disabled', false);
                return false;
            }

            $input = document.getElementById('fileImovel');
            file = $input.files[0];
            // $nome_arquivo.innerHTML = file.name;
            // $tamanho.innerHTML = file.size + " bytes";
            $ext = /\..*$/g.exec(file.name);

            if (file.size > 2048000) {
                alert("O arquivo deve ter no máximo 2Mb");
                lancarArquivoImovelEnviado = false;
                $("#lancarArquivoImovel").prop('disabled', false);
                return false;
            }

            if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf' && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
                alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
                lancarArquivoImovelEnviado = false;
                $("#lancarArquivoImovel").prop('disabled', false);
                return false;
            }
            
            $("#mdlAguarde").modal('toggle');
            var dadosImovel = new FormData($("form[name='formDocumentosimovel']")[0]);
            
            $.ajax({
                type: 'POST',
                url: "{{ url('/itbi_documentos_imovel') }}",
                data: dadosImovel,
                processData: false,
                contentType: false

            }).done(function (resposta) {
                $("#mdlAguarde").modal('toggle');

                if (resposta.statusArquivoTransacao == 1) {
                    documentosImovel.row.add([
                        resposta.descricao,
                        resposta.nome_original,
                        resposta.nome_novo,
                        '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                    ]).draw(false);
                    documentosImovel.columns.adjust().draw();
                    $("#descricaoImovel").val("");
                    $("#fileImovel").val("");
                    lancarArquivoImovelEnviado = false;
                    $("#lancarArquivoImovel").prop('disabled', false);

                }
                else {
                    alert("Não foi possivel fazer o upload do seu arquivo");
                    lancarArquivoImovelEnviado = false;
                    $("#lancarArquivoImovel").prop('disabled', false);
                    return false;
                }
            })
            .fail(function () {
                $("#mdlAguarde").modal('toggle');
                alert("Não foi possivel fazer o upload do seu arquivo");
                lancarArquivoImovelEnviado = false;
                $("#lancarArquivoImovel").prop('disabled', false);
            })
        }
        else{
            console.log("Segundo envio");
        }
    });

var tbltransmitentes = $('#tbltransmitentes').DataTable({
    "paging": false,
    "ordering": false,
    "info": false,
    "searching": false,
    "scrollX": true,
    "scrollY": 300,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
    }
});

@isset($dadosImovel2->aOutrosProprietariosEncontradas)
    @foreach ($dadosImovel2->aOutrosProprietariosEncontradas as $proprietarios)

        var url = "{{  url('/itbiconsultaCGM') }}" + "/{{$proprietarios->s_cpfcnpj}}";
    
        $.get(url, function (resposta) {
            // console.log(resposta);
            var obj = jQuery.parseJSON(resposta);
            if (obj.cgm.iStatus == 1) {

                if( !obj.cgm.sSqlerro ){ // O CPF do Adquirente está cadastro no CGM
                    tbltransmitentes.row.add([
                        {{$proprietarios->s_cpfcnpj}} ,
                        unescape(obj.cgm.aCgmPessoais.z01_nome).replace(/[+]/g, " ") ,
                        unescape(obj.cgm.aCgmContato.z01_telef).replace(/[+]/g, " "),
                        unescape(obj.cgm.aCgmContato.z01_telcel).replace(/[+]/g, " "),
                        unescape(obj.cgm.cgm).replace(/[+]/g, " "),
                        unescape(obj.endereco.endereco.iCep).replace(/[+]/g, " "),
                        unescape(obj.endereco.endereco.sRua).replace(/[+]/g, " "),
                        unescape(obj.endereco.endereco.sNumeroLocal).replace(/[+]/g, " "),
                        unescape(obj.endereco.endereco.sComplemento).replace(/[+]/g, " "),
                        unescape(obj.endereco.endereco.sBairro).replace(/[+]/g, " "),
                        unescape(obj.endereco.endereco.sMunicipio).replace(/[+]/g, " "),
                        converteEstadoSigla(unescape(obj.endereco.endereco.sEstado).replace(/[+]/g, " ")),
                        unescape(obj.cgm.aCgmContato.z01_email).replace(/[+]/g, " "),
                        "NÃO"
                    ]).draw(false);
                    tbltransmitentes.columns.adjust().draw();
                }
            }
            else {
                return false;
            }
        });            
    @endforeach
@endisset

var tbladquirentesDisplay = $('#tbladquirentesDisplay').DataTable({
    "paging": false,
    "ordering": false,
    "info": false,
    "searching": false,
    "scrollX": true,
    "scrollY": 300,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
    }
});

var tbladquirentes = $('#tbladquirentes').DataTable({
    "paging": false,
    "ordering": false,
    "info": false,
    "searching": false,
    "scrollX": true,
    "scrollY": 300,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
    }
});

var documentosImovel = $('#documentosImovel').DataTable({
    "paging": false,
    "ordering": false,
    "info": false,
    "searching": false,
    "scrollY": 150,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
    }
});

var documentosTransacao = $('#documentosTransacao').DataTable({
    "paging": false,
    "ordering": false,
    "info": false,
    "searching": false,
    "scrollY": 150,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
    }
});


$("#lancarArquivoTransacao").click(function () {
    if ($("#descricaoTransacao").val() == "") {
        alert("Por favor informe a descrição deste documento");
        $("#descricaoTransacao").focus();
        return false;
    }
    if ($("#fileTransacao").val() == "") {
        alert("Por favor escolha um documento para enviar");
        $("#fileTransacao").focus();
        return false;
    }

    var $input, file, $arquivo, $tamanho, $ext;

    $input = document.getElementById('fileTransacao');

    if (!window.FileReader) {
        return false;
    }

    $input = document.getElementById('fileTransacao');
    file = $input.files[0];
    // $nome_arquivo.innerHTML = file.name;
    // $tamanho.innerHTML = file.size + " bytes";
    $ext = /\..*$/g.exec(file.name);

    if (file.size > 2048000) {
        alert("O arquivo deve ter no máximo 2Mb");
        return false;
    }

    if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
        alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
        return false;
    }
    
    $("#mdlAguarde").modal('toggle');
    var dadosTransacao = new FormData($("form[name='formDocumentosTransacao']")[0]);
    $.ajax({
        type: 'POST',
        url: "{{ url('/itbi_documentos_transacao')}}",
        data: dadosTransacao,
        processData: false,
        contentType: false

    }).done(function (resposta) {
        $("#mdlAguarde").modal('toggle');

        if (resposta.statusArquivoTransacao == 1) {
            documentosTransacao.row.add([
                resposta.descricao,
                resposta.nome_original,
                resposta.nome_novo,
                '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
            ]).draw(false);
            documentosTransacao.columns.adjust().draw();
            $("#descricaoTransacao").val("");
            $("#fileTransacao").val("");
        }
        else {
            alert("Não foi possivel fazer o upload do seu arquivo");
            return false;
        }
    })
    .fail(function () {
        $("#mdlAguarde").modal('toggle');
        alert("Não foi possivel fazer o upload do seu arquivo");
    })
});



var documentosTransmitente = $('#documentosTransmitente').DataTable({
    "paging": false,
    "ordering": false,
    "info": false,
    "searching": false,
    "scrollY": 150,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
    }
});

$("#lancarArquivoTransmitente").click(function () {
    if ($("#descricaoTransmitente").val() == "") {
        alert("Por favor informe a descrição deste documento");
        return false;
    }
    if ($("#fileTransmitente").val() == "") {
        alert("Por favor escolha um documento para enviar");
        return false;
    }

    var $input, file, $arquivo, $tamanho, $ext;

    $input = document.getElementById('fileTransmitente');


    if (!window.FileReader) {
        return false;
    }

    $input = document.getElementById('fileTransmitente');
    file = $input.files[0];
    // $nome_arquivo.innerHTML = file.name;
    // $tamanho.innerHTML = file.size + " bytes";
    $ext = /\..*$/g.exec(file.name);

    if (file.size > 2048000) {
        alert("O arquivo deve ter no máximo 2Mb");
        return false;
    }

    if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
        alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
        return false;
    }

    $("#mdlAguarde").modal('toggle');
    var dados = new FormData($("form[name='formDocumentosTransmitente']")[0]);
    console.log(dados);
    $.ajax({
        type: 'POST',
        url: "{{ url('/itbi_documentos_transmitente')}}",
        data: dados,
        processData: false,
        contentType: false

    }).done(function (resposta) {
        $("#mdlAguarde").modal('toggle');

        if (resposta.statusArquivoTransacao == 1) {
            documentosTransmitente.row.add([
                resposta.descricao,
                resposta.nome_original,
                resposta.nome_novo,
                '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
            ]).draw(false);
            documentosTransmitente.columns.adjust().draw();
            $("#descricaoTransmitente").val("");
            $("#fileTransmitente").val("");
        }
        else {
            alert("Não foi possivel fazer o upload do seu arquivo");
            return false;
        }
    })
        .fail(function ( data ) {
            $("#mdlAguarde").modal('toggle');
            alert("Não foi possivel fazer o upload do seu arquivo");

            // if( data.status === 422 ) {
            //     var errors = $.parseJSON(data.responseText);
            //     $.each(errors, function (key, value) {
            //         // console.log(key+ " " +value);
            //     $('#response').addClass("alert alert-danger");
    
            //         if($.isPlainObject(value)) {
            //             $.each(value, function (key, value) {                       
            //                 console.log(key+ " " +value);
            //             $('#response').show().append(value+"<br/>");
    
            //             });
            //         }else{
            //         $('#response').show().append(value+"<br/>"); //this is my div with messages
            //         }
            //     });
            // }
        })


});


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



var documentosAdquirente = $('#documentosAdquirente').DataTable({
    "paging":   false,
    "ordering": false,
    "info":     false,
    "searching": false,
    "scrollY": 150,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
    }
});

$("#lancarArquivoAdquirente").click(function () {
    if ($("#descricaoAdquirente").val() == "") {
        alert("Por favor informe a descrição deste documento");
        return false;
    }
    if ($("#fileAdquirente").val() == "") {
        alert("Por favor escolha um documento para enviar");
        return false;
    }

    var $input, file, $arquivo, $tamanho, $ext;

    $input = document.getElementById('fileAdquirente');


    if (!window.FileReader) {
        return false;
    }

    $input = document.getElementById('fileAdquirente');
    file = $input.files[0];
    // $nome_arquivo.innerHTML = file.name;
    // $tamanho.innerHTML = file.size + " bytes";
    $ext = /\..*$/g.exec(file.name);

    if (file.size > 2048000) {
        alert("O arquivo deve ter no máximo 2Mb");
        return false;
    }

    if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
        alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
        return false;
    }

    $("#mdlAguarde").modal('toggle');
    var dados = new FormData($("form[name='formDocumentosAdquirente']")[0]);
    $.ajax({
        type: 'POST',
        url: "{{ url('/itbi_documentos_adquirente') }}",
        data: dados,
        processData: false,
        contentType: false

    }).done(function (resposta) {
        $("#mdlAguarde").modal('toggle');

        if (resposta.statusArquivoTransacao == 1) {
            documentosAdquirente.row.add([
                resposta.descricao,
                resposta.nome_original,
                resposta.nome_novo,
                '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
            ]).draw(false);
            documentosAdquirente.columns.adjust().draw();
            $("#descricaoAdquirente").val("");
            $("#fileAdquirente").val("");
        }
        else {
            alert("Não foi possivel fazer o upload do seu arquivo");
            return false;
        }
    })
    .fail(function ( data ) {
        // $("#mdlAguarde").modal('toggle');
        // alert("Não foi possivel fazer o upload do seu arquivo");

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

$('#documentosTransacao').on("click", "button", function () {
    $("#mdlAguarde").modal('toggle');

    var row = $(this).parents('tr').data();
    var nomeArquivo = documentosTransacao.row($(this).parents('tr')).data()[2];
    documentosTransacao.row($(this).parents('tr')).remove().draw(false);

    $.get("{{ url('/itbi_documentos_remove') }}/" + nomeArquivo, function (resposta) {

        $("#mdlAguarde").modal('toggle');

    })
});

$('#documentosTransmitente').on("click", "button", function () {
    $("#mdlAguarde").modal('toggle');

    var row = $(this).parents('tr').data();
    var nomeArquivo = documentosTransmitente.row($(this).parents('tr')).data()[2];
    documentosTransmitente.row($(this).parents('tr')).remove().draw(false);

    $.get("{{ url('/itbi_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

        $("#mdlAguarde").modal('toggle');

    })
});

$('#documentosAdquirente').on("click", "button", function () {
    $("#mdlAguarde").modal('toggle');

    var row = $(this).parents('tr').data();
    var nomeArquivo = documentosAdquirente.row($(this).parents('tr')).data()[2];
    documentosAdquirente.row($(this).parents('tr')).remove().draw(false);

    $.get("{{ url('/itbi_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

        $("#mdlAguarde").modal('toggle');

    })
});

$('#documentosImovel').on("click", "button", function () {
    $("#mdlAguarde").modal('toggle');

    var row = $(this).parents('tr').data();
    var nomeArquivo = documentosImovel.row($(this).parents('tr')).data()[2];
    documentosImovel.row($(this).parents('tr')).remove().draw(false);

    $.get("{{ url('/itbi_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

        $("#mdlAguarde").modal('toggle');

    })
});

function IsEmail(email){

    usuario = email.substring(0, email.indexOf("@"));
    dominio = email.substring(email.indexOf("@")+ 1, email.length);
    
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

    // var exclude=/[^@-.w]|^[_@.-]|[._-]{2}|[@.]{2}|(@)[^@]*1/;
    // var check=/@[w-]+./;
    // var checkend=/.[a-zA-Z]{2,3}$/;
    // if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
    // else {return true;}
}

function converteEstadoSigla($estado){
    $estado = $estado.toUpperCase();
    switch ($estado) {
        case 'ACRE':
            return "AC";
            break;
        case 'ALAGOAS':
            return "AL";
            break;
        case 'AMAPÁ':
            return "AP";
            break;
        case 'AMAZONAS':
            return "AM";
            break;
        case 'BAHIA':
            return "BA";
            break;
        case 'CEARÁ':
            return "CE";
            break;
        case 'DISTRITO FEDERAL':
            return "DF";
            break;
        case 'ESPÍRITO SANTO':
            return "ES";
            break;
        case 'GOIÁS':
            return "GO";
            break;
        case 'MARANHÃO':
            return "MA";
            break;
        case 'MATO GROSSO':
            return "MT";
            break;
        case 'MATO GROSSO DO SUL':
            return "MS";
            break;
        case 'MINAS GERAIS':
            return "MG";
            break;
        case 'PARÁ':
            return "PA";
            break;
        case 'PARAÍBA':
            return "PB";
            break;
        case 'PERNAMBUCO':
            return "PE";
            break;
        case 'PIAUÍ':
            return "PI";
            break;
        case 'RIO DE JANEIRO':
            return "RJ";
            break;
        case 'RIO GRANDE DO NORTE':
            return "RN";
            break;
        case 'RIO GRANDE DO SUL':
            return "RS";
            break;
        case 'RONDÔNIA':
            return "RO";
            break;
        case 'RORAIMA':
            return "RR";
            break;
        case 'SANTA CATARINA':
            return "SC";
            break;
        case 'SÃO PAULO':
            return "SP";
            break;
        case 'SERGIPE':
            return "SE";
            break;
        case 'TOCANTINS':
            return "TO";
            break;
    }

}
</script>
@endsection