@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container-fluid">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('Averbação de Imóveis') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Averbação de Imóveis') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="modal hide fade" id="loadingAdquirente" tabindex="-1" role="dialog" data-backdrop="static"
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

<form method="POST" action="{{ route('averbacao_gravar') }}" id="averbacao_gravar">
@csrf
    <section id="content">
        <div class="container-fluid">
            <div class="row-fluid">
                @if (session('status'))
                @if (session('status') == 1 || session('status') == 3)
                <div class="alert alert-success" role="alert" id="mensagem" style="transition: 10s; opacity: 1;">
                    As suas informações foram gravadas com sucesso
                </div>
                @endif
                @if (session('status') == 2 || session('status') == 3)
                <div class="alert alert-info" role="alert" id="mensagem2" style="transition: 20s; opacity: 1;">
                    Um e-mail foi enviado para o endereço anteriormente cadastrado.<br>
                    Para efetivar a alteração do seu e-mail confirme a sua locitação neste e-mail.
                </div>
                @endif

                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h4>Formulário destinado a transações por meio de ITBI (Inter vivos).</h4>
                            <p><a href="{{url('/download/RGI_fundo_branco.pdf')}}" target="_blank">Clique aqui</a> para identificar no Registro do Imóvel no Cartório (RGI) onde se encontram as informações para preenchimento do formulário abaixo.</p>
                            <p><b>IMPORTANTE:</b> PREENCHER OS DADOS COM CUIDADO, POIS QUAISQUER DIVERGÊNCIAS ENTRE OS DADOS CADASTRADOS E O DOCUMENTO APRESENTADO SERÃO ANALISADAS E APONTADAS.</p>
                        </div>
                        <div class="accordion" id="accordion4">
                            {{--
                            ***********************************
                            *** Averbação
                            ***********************************
                            --}}
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseOne2">
                                        <i class="icon-minus"></i> Averbação
                                    </a>
                                </div>
                                <div id="collapseOne2" class="accordion-body collapse in">
                                    @include('imovel.averbacao1')
                                </div>
                            </div>
                            {{--
                            ***********************************
                            *** Adquirente
                            ***********************************
                            --}}
                            @if (!count($pendencias))
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseTwo2">
                                        <i class="icon-plus"></i> Adquirente
                                    </a>
                                </div>
                                <div id="collapseTwo2" class="accordion-body collapse">
                                    @include('imovel.averbacao2')
                                </div>
                            </div>
                            @endif
                            {{--
                            ***********************************
                            *** Documentação em anexo
                            ***********************************
                            --}}
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseSix2">
                                        <i class="icon-plus"></i> Documentação em anexo
                                    </a>
                                </div>
                                <div id="collapseSix2" class="accordion-body collapse">
                                    @include('imovel.averbacao3')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span6 text-left">
                            <a href="{{ url('/servicos/1#tab-2')  }}" class="btn btn-theme e_wiggle" id="autenticar">
                                {{ __('Voltar') }}
                            </a>
                        </div>
                        <div class="span6 text-right">
                            @if (!count($pendencias))
                            <button type="button" class="btn btn-warning e_wiggle" id="solicitar">
                                {{ __('Solicitar') }}
                            </button>
                            @else
                            <button type="button" class="btn btn-warning e_wiggle" id="solicitar-pendencias">
                                {{ __('Encaminhar') }}
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection

@section('post-script')
<script type="text/javascript">
    var tblAdquirente;

    var tmpcpf = $("#cpf").val();

    jQuery(document).ready(function(){

        $("#dataAverbacao").mask("00/00/0000");
        $("#data_pendencias").mask("00/00/0000");
        $("#cep_adquirente").mask("99.999-999");
        $("#telefone_adquirente").mask("(00)0000-0009");
        $("#celular_adquirente").mask("(00)00000-0009");
        $("#imovel_pendencias").mask("000000009");
        $("#protocolo_pendencias").mask("00000000000000009");
        $("#protocolo").mask("00000000000000009");

        localStorage.removeItem("adquirente");
        localStorage.removeItem("anexos");

        if($("#cpf").val() != undefined) {
            $('#cpf').mask('00.000.000/0000-00');
            var cpf_opt = {
                onKeyPress: function (cpf, e, field, cpf_opt) {
                    console.log("Keypress: " + cpf.length)
                    var masks = ['00.000.000/0000-00', '000.000.000-00'];
                    var mask = (cpf.length > 14 || cpf.length == 0) ? masks[0] : masks[1];
                    $('#cpf').mask(mask, cpf_opt);
                }
            };

            if (typeof ($("#cpf")) !== "undefined") {
                var masks = ['00.000.000/0000-00', '000.000.000-00'];
                var mask = ($("#cpf").val().length > 14 || $("#cpf").val().length == 0) ? masks[0] : masks[1];
                $("#cpf").mask(mask, cpf_opt);
            }

            $("#cpf").val(tmpcpf) ;
        }

        tblAdquirente = $('#tblAdquirente').DataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            "scrollY": 200,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            }
        });

        var tablePesquisaImovel = $('#pesquisaTaxa').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "bLengthChange": false,
            "ordering": false,
            "info": false,
            "pageLength": 4,
            "scrollY": 200,
            "searching": false,
        });

        $("#pesquisar").click(function(){
            $("#mdlAguarde").modal("toggle");
            var url = 'listaImoveis/{{ Auth::user()->cpf }}/' + $("#inscricao").val();

            $.get(url, function (resposta) {
                console.log('resposta ', resposta);
                var obj = jQuery.parseJSON(resposta);
                if (obj.iStatus == 1) {
                    console.log('obj ', obj);
                    $('#pesquisaTaxa').dataTable().fnClearTable();

                    $.each(obj.aMatriculasCgmEncontradas, function(i, item) {
                        tablePesquisaImovel.row.add( [
                            item.matricula,
                            item.tipo,
                            unescape(item.bairro).replace(/[+]/g, " "),
                            unescape(item.logradouro).replace(/[+]/g, " "),
                            item.numero,
                            unescape(item.complemento).replace(/[+]/g, " "),
                            unescape(item.planta + " / " + item.quadra + " / " + item.lote).replace(/[+]/g, " "),
                            '<button type="button" class="btn e_wiggle" onClick="selectionaPesquisa(' + item.matricula + ');"  >Selecionar</button>'
                        ] ).draw( false );
                    });
                    $('#pesquisaTaxa').css('display', 'none' );
                    $("#pesquisa").modal('toggle');
                    $('#pesquisaTaxa').css('display', 'block' );
                    tablePesquisaImovel.columns.adjust().draw();
                }
                else {
                    alert("Não foi possivel consultar a matrícula dos seus imóveis");
                    return false;
                }
            });
            $("#mdlAguarde").modal("toggle");
        });

        $("#pesquisar-adquirente").click(function(){
            $("#mdlAguarde").modal("toggle");
            let cpf = $("#cpf").val();

            if (cpf.length == 14) {
                if (!validarCPF(cpf)) {
                    alert("CPF inválido! Favor informar um CPF válido.");
                    $("#mdlAguarde").modal("toggle");
                    return false;
                }
            } else if (cpf.length == 18) {
                if (!validarCNPJ(cpf)) {
                    alert("CNPJ inválido! Favor informar um CNPJ válido.");
                    $("#mdlAguarde").modal("toggle");
                    return false;
                }
            } else {
                alert("Por favor, informe corretamente o número do seu CPF ou CNPJ.");
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            cpf = cpf.replace("/", "");

            var url = 'recupera_cgm_endereco/' + cpf;

            if($("#cpf").val() != '')
            $.get(url, function (resposta) {
                console.log('adquirente ', resposta);
                if(!resposta.error) {

                    $("#nome_adquirente").val(resposta.cgm.nome);
                    // $("#cpf").val(resposta.cgm.cpf);
                    $("#telefone_adquirente").val(unescape(resposta.cgm.telefone).replace(/[+]/g, " "));
                    $("#celular_adquirente").val(unescape(resposta.cgm.celular).replace(/[+]/g, " "));
                    $("#cgm_adquirente").val(resposta.cgm.cgm);
                    $("#email_adquirente").val(resposta.cgm.email);
                    $("#cep_adquirente").val(resposta.cgm.cep);
                    $("#endereco_adquirente").val(resposta.cgm.endereco);
                    $("#numero_adquirente").val(resposta.cgm.numero);
                    $("#complemento_adquirente").val(resposta.cgm.complemento);
                    $("#bairro_adquirente").val(resposta.cgm.bairro);
                    $("#municipio_adquirente").val(resposta.cgm.municipio);
                    $("#estado_adquirente").val(resposta.cgm.estado);

                    document.querySelector("#dadosAdq").style.display = 'none';

                    $("#cpf").prop('readonly', true);
                    $("#nome_adquirente").prop('readonly', true);

                    $("#adicionar-adquirente").prop('disabled', false);
                    $("#alert-doc-adquirente").hide();
                    $("#mdlAguarde").modal("toggle");
                }else {
                    delete resposta.error;
                    console.log('Não achou');
                    document.querySelector("#dadosAdq").style.display = 'block';

                    $("#adicionar-adquirente").prop('disabled', false);
                    $("#nome_adquirente").focus();
                    limparCamposAdquirente();
                    abrirCamposAdquirente();
                    $("#cgm_adquirente").prop('readonly', true);
                    var newAlert = document.createElement("P");
                    newAlert.setAttribute('class', 'alert alert-danger');
                    newAlert.innerHTML = "Dados não encontrados!";
                    document.getElementById("alert-doc-adquirente").appendChild(newAlert);
                    $("#mdlAguarde").modal("toggle");
                }
            });
        });

        $('#adicionar-adquirente').click(()=> adicionarAdquirente());

        const adicionarAdquirente = () => {

            if($("#nome_adquirente").val() === "")  {
                alert("Por favor informe o nome do adquirente");
                $("#nome_adquirente").focus();
                return false;
            }else if($("#cpf").val() === "") {
                alert("Por favor informe o CPF do adquirente");
                $("#cpf").focus();
                return false;
            }/* else if($("#telefone_adquirente").val() === "") {
                alert("Por favor informe o telefone do adquirente");
                $("#telefone_adquirente").focus();
                return false;
            }else if($("#celular_adquirente").val() === "") {
                alert("Por favor informe o celular do adquirente");
                $("#celular_adquirente").focus();
                return false;
            }else if($("#cep_adquirente").val() === "") {
                alert("Por favor informe o CEP do adquirente");
                $("#cep_adquirente").focus();
                return false;
            }else if($("#endereco_adquirente").val() === "") {
                alert("Por favor informe o endereço do adquirente");
                $("#endereco_adquirente").focus();
                return false;
            }else if($("#numero_adquirente").val() === "") {
                alert("Por favor informe o número do adquirente");
                $("#numero_adquirente").focus();
                return false;
            }else if($("#bairro_adquirente").val() === "") {
                alert("Por favor informe o bairro do adquirente");
                $("#bairro_adquirente").focus();
                return false;
            }else if($("#municipio_adquirente").val() === "") {
                alert("Por favor informe o município do adquirente");
                $("#municipio_adquirente").focus();
                return false;
            }else if($("#estado_adquirente").val() === "") {
                alert("Por favor informe o estado do adquirente");
                $("#estado_adquirente").focus();
                return false;
            }else if($("#email_adquirente").val() === "") {
                alert("Por favor informe o e-mail do adquirente");
                $("#email_adquirente").focus();
                return false;
            } */

            const adquirenteStorage = localStorage.getItem("adquirente");

            let adquirente = adquirenteStorage ? JSON.parse(adquirenteStorage) : [];

            if(adquirente != []) {
                console.log('hahahaha');
                let adquirentesPrincipais = 0;

                for (const key in adquirente) {
                    if (adquirente[key].principal === "Sim") {
                        adquirentesPrincipais++;
                    }
                }

                if(adquirentesPrincipais > 0) {
                    $("#adquirente_principal").prop('disabled', true);
                    var elem = document.querySelector('#label_adquirente_principal p');

                    if(!elem) {
                        var newDiv = document.createElement("P");
                        newDiv.setAttribute('class', 'alert alert-danger');
                        newDiv.innerHTML = "Não é possível adicionar mais de um adquirente principal!";
                        document.getElementById("label_adquirente_principal").appendChild(newDiv);
                    }
                }else {
                    $("#adquirente_principal").prop('disabled', false);
                    var elem = document.querySelector('#label_adquirente_principal p');
                    elem ? elem.style.display = "none" : '';
                }


            }

            adquirente.push({
                nome: $("#nome_adquirente").val(),
                cpf: $("#cpf").val(),
                telefone: $("#telefone_adquirente").val(),
                celular: $("#celular_adquirente").val(),
                cgm: $("#cgm_adquirente").val(),
                cep: $("#cep_adquirente").val(),
                endereco: $("#endereco_adquirente").val(),
                numero: $("#numero_adquirente").val(),
                complemento: $("#complemento_adquirente").val(),
                bairro: $("#bairro_adquirente").val(),
                municipio: $("#municipio_adquirente").val(),
                estado: $("#estado_adquirente").val(),
                email: $("#email_adquirente").val(),
                principal: $("#adquirente_principal").is(":checked") ? 'Sim' : 'Não'
            });

            localStorage.setItem("adquirente", JSON.stringify(adquirente));

            tblAdquirente.row.add([
                adquirente[adquirente.length-1].nome,
                adquirente[adquirente.length-1].cpf,
                adquirente[adquirente.length-1].cgm,
                adquirente[adquirente.length-1].principal,
                '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
            ]).draw(false);
            tblAdquirente.columns.adjust().draw();
            limparCamposAdquirente();
            bloquearCamposAdquirente();
            $("#cpf").val("");
            $("#adicionar-adquirente").prop('disabled', true);
            $("#cpf").prop('readonly', false);
        };

        const bloquearCamposAdquirente = () => {
            $("#alert-doc-adquirente").hide();
            $("#nome_adquirente").prop('readonly', true);
            $("#telefone_adquirente").prop('readonly', true);
            $("#celular_adquirente").prop('readonly', true);
            $("#cgm_adquirente").prop('readonly', true);
            $("#email_adquirente").prop('readonly', true);
            $("#cep_adquirente").prop('readonly', true);
            $("#endereco_adquirente").prop('readonly', true);
            $("#numero_adquirente").prop('readonly', true);
            $("#complemento_adquirente").prop('readonly', true);
            $("#bairro_adquirente").prop('readonly', true);
            $("#municipio_adquirente").prop('readonly', true);
            $("#estado_adquirente").prop('disabled', true);
        }

        const limparCamposAdquirente = () => {
            $("#nome_adquirente").val("");
            $("#adquirente_principal").removeAttr('checked');
            $("#telefone_adquirente").val("");
            $("#celular_adquirente").val("");
            $("#cgm_adquirente").val("");
            $("#email_adquirente").val("");
            $("#cep_adquirente").val("");
            $("#endereco_adquirente").val("");
            $("#numero_adquirente").val("");
            $("#complemento_adquirente").val("");
            $("#bairro_adquirente").val("");
            $("#municipio_adquirente").val("");
            $("#estado_adquirente").val("");
        }

        const abrirCamposAdquirente = () => {
            $("#nome_adquirente").prop('readonly', false);
            $("#telefone_adquirente").prop('readonly', false);
            $("#celular_adquirente").prop('readonly', false);
            $("#cgm_adquirente").prop('readonly', false);
            $("#email_adquirente").prop('readonly', false);
            $("#cep_adquirente").prop('readonly', false);
            $("#numero_adquirente").prop('readonly', false);
            $("#complemento_adquirente").prop('readonly', false);
        }

        // alert(moment().subtract(90, 'days').format("DD/MM/YYYY"));

        $("#solicitar-pendencias").click(function() {
            $("#mdlAguarde").modal('toggle');

            dataAverbacao = moment($("#data_pendencias").val(), "DD/MM/YYYY", true);
            let dataLimite = moment().subtract(90, 'days');

            if ( dataAverbacao.isValid() ){
                if(dataAverbacao.isAfter()){
                    alert("Data Inválida! A data não deve ser maior que a data atual.");
                    $("#collapseOne2").collapse('show');
                    $("#data_pendencias").focus();
                    $("#mdlAguarde").modal("toggle");
                    return false;
                }else if(dataAverbacao < dataLimite) {
                    alert("Data Inválida! A data não deve ter menos de 90 dias da data atual.");
                    $("#collapseOne2").collapse('show');
                    $("#data_pendencias").focus();
                    $("#mdlAguarde").modal("toggle");
                    return false;
                }
            }
            else{
                alert("Data Inválida! Por favor informe uma data válida.");
                $("#collapseOne2").collapse('show');
                $("#data_pendencias").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }


            if($("#imovel_pendencias").val() == ""){
                alert("Por favor informe o Número do Registro");
                $("#collapseOne2").collapse('show');
                $("#imovel_pendencias").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            if($("#protocolo_pendencias").val() == ""){
                alert("Por favor informe o Protocolo");
                $("#collapseOne2").collapse('show');
                $("#protocolo_pendencias").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            anexos = localStorage.getItem("anexos");

            if(!anexos) {
                alert("Favor adicionar os anexos necessários.");
                $("#collapseSix2").collapse('show');
                $("#descricao").focus();
                $("#mdlAguarde").modal('toggle');
                return false;
            }
            console.log(anexos);


            document.getElementById('listaAnexos').innerHTML = `<input  type="hidden" id="anexos" name="anexos" value='${anexos}'> `;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData();
            formData.append("processo_pendencias", $('#processo_pendencias').val());
            formData.append('etapa_pendencias',$("#etapa_pendencias").val());
            formData.append('ciclo_pendencias',$("#ciclo_pendencias").val());
            formData.append('guia_pendencias',$("#guia_pendencias").val());
            formData.append('imovel_pendencias',$("#imovel_pendencias").val());
            formData.append('protocolo_pendencias',$("#protocolo_pendencias").val());
            formData.append('data_pendencias',$("#data_pendencias").val());
            formData.append('anexos',$("#anexos").val());

            // console.log(formData);

            $.ajax({
                url: '{{url("/pendencias_gravar")}}',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    $('body').html(response.html);
                    // $("#mdlAguarde").modal('toggle');
                },
            });

        });

        $("#solicitar").click(function(){
            $("#mdlAguarde").modal("show");

            console.log("mudou o modal");
            if($("#tipoSolicitacao").val() == 0){
                alert("Por favor informe o Tipo de Solicitação");
                $("#tipoSolicitacao").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            dataAverbacao = moment($("#dataAverbacao").val(), "DD/MM/YYYY", true);
            // console.log(dataAverbacao._i);

            let dataLimite = moment().subtract(90, 'days');

            if ( dataAverbacao.isValid() ){
                if(dataAverbacao.isAfter()){
                    alert("Data Inválida! A data não deve ser maior que a data atual.");
                    $("#collapseOne2").collapse('show');
                    $("#dataAverbacao").focus();
                    $("#mdlAguarde").modal("toggle");
                    return false;
                }else if(dataAverbacao < dataLimite) {
                    alert("Data Inválida! A data não deve ter menos de 90 dias da data atual.");
                    $("#collapseOne2").collapse('show');
                    $("#dataAverbacao").focus();
                    $("#mdlAguarde").modal("toggle");
                    return false;
                }
            }
            else{
                alert("Data Inválida! Por favor informe uma data válida.");
                $("#collapseOne2").collapse('show');
                $("#dataAverbacao").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            if($("#registro").val() == ""){
                alert("Por favor informe o Número do Registro");
                $("#collapseOne2").collapse('show');
                $("#registro").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            if($("#protocolo").val() == ""){
                alert("Por favor informe o Protocolo");
                $("#collapseOne2").collapse('show');
                $("#protocolo").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            let adquirentes = JSON.parse(localStorage.getItem("adquirente"));

            let adquirentesPrincipais = 0;

            for (const key in adquirentes) {
                if (adquirentes[key].principal === "Sim") {
                    adquirentesPrincipais++;
                }
            }

            if(adquirentesPrincipais === 0) {
                alert("É necessário ter um adquirente principal!");
                $("#collapseTwo2").collapse('show');
                $("#mdlAguarde").modal("toggle");
                return false;
            }else if(adquirentesPrincipais > 1) {
                alert("Não é possível adicionar mais de um adquirente principal!");
                $("#collapseTwo2").collapse('show');
                $("#mdlAguarde").modal("toggle");
                return false;
            }


            let novosAdquirentes = '';

            if(adquirentes) {
                adquirentes.forEach((element, index) => {
                    if(index > 0) {
                        novosAdquirentes += ",";
                    }
                    novosAdquirentes += JSON.stringify(element);
                });
            }else {
                alert("Favor adicionar adquirentes.");
                $("#collapseTwo2").collapse('show');
                $("#cpf").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            document.getElementById('listaAdquirentes').innerHTML = `<input  type="hidden" name="adquirentes" value='${novosAdquirentes}'> `;

            anexos = localStorage.getItem("anexos");

            if(!anexos) {
                alert("Favor adicionar os anexos necessários.");
                $("#collapseSix2").collapse('show');
                $("#descricao").focus();
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            document.getElementById('listaAnexos').innerHTML = `<input  type="hidden" name="anexos" value='${anexos}'> `;


            $("#averbacao_gravar").submit();
            // $("#mdlAguarde").modal("toggle");
        })

        $("#lancarArquivo").click(function () {
            $("#mdlAguarde").modal("toggle");
            // if ($("#processo").val() == "" || $("#processo").val() == null) {
            //     alert("Por favor escolha um processo para anexar um documento");
            //     return false;
            // }
            $("#solicitar").prop('disabled', true);
            document.querySelector("#alert-anexo-averbacao-success").style.display = 'none';

            alertTxtAnexoAverbacao = document.querySelector('#text-alert-anexo');
            if ($("#descricao").val() == "") {
                // alert("Por favor informe a descrição deste documento");
                document.querySelector("#alert-anexo-averbacao-fail").style.display = 'block';
                alertTxtAnexoAverbacao.innerHTML = 'Por favor informe a descrição deste documento';
                $("#collapseSix2").collapse('show');
                $("#mdlAguarde").modal("toggle");
                return false;
            }
            if ($("#arquivo").val() == "") {
                // alert("Por favor escolha um documento para enviar");
                document.querySelector("#alert-anexo-averbacao-fail").style.display = 'block';
                alertTxtAnexoAverbacao.innerHTML = 'Por favor escolha um documento para enviar';
                $("#collapseSix2").collapse('show');
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            $input = document.getElementById('arquivo');
            file = $input.files[0];
            // $nome_arquivo.innerHTML = file.name;
            // $tamanho.innerHTML = file.size + " bytes";
            /* $ext = /\..*$/g.exec(file.name);

            console.log('ext => ', $ext); */

            $ext = file.name.split('.');

            $ext = $ext[$ext.length-1];

            if (file.size > 2048000) {
                document.querySelector("#alert-anexo-averbacao-fail").style.display = 'block';
                alertTxtAnexoAverbacao.innerHTML = 'O arquivo deve ter no máximo 2MB';
                $("#collapseSix2").collapse('show');
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            if ($ext != 'jpeg' && $ext != 'jpg' && $ext != 'png' && $ext != 'pdf' && $ext != 'JPEG' && $ext != 'JPG' && $ext != 'PNG' && $ext != 'PDF' ) {
                document.querySelector("#alert-anexo-averbacao-fail").style.display = 'block';
                alertTxtAnexoAverbacao.innerHTML = "'O arquivo deve ser do tipo 'jpeg', 'jpg', 'png' ou 'pdf'";
                $("#collapseSix2").collapse('show');
                $("#mdlAguarde").modal("toggle");
                return false;
            }

            alertTxtAnexoAverbacao.innerHTML = '';
            document.querySelector("#alert-anexo-averbacao-fail").style.display = 'none';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData();
            formData.append("arquivo", $('#arquivo')[0].files[0]);
            formData.append('descricao',$("#descricao").val());
            formData.append('outroAnexo',$("#outroAnexo").val());

            alertTxtAnexoAverbacaoSuccess = document.querySelector('#text-alert-anexo-success');


            $.ajax({
                type: 'POST',
                url: "{{ url('/averbacao_documentos') }}",
                data: formData,
                processData: false,
                contentType: false,

            }).done(function (response) {
                    if(response.statusArquivoTransacao == 1){
                        alertTxtAnexoAverbacaoSuccess.innerHTML = 'Arquivo enviado com sucesso!';
                        document.querySelector("#alert-anexo-averbacao-success").style.display = 'block';

                        tableAnexos.row.add([
                            response.descricao,
                            response.nome_original,
                            response.nome_novo,
                            '<button type="button" class="btn btn-red e_wiggle">Remover</button>'
                        ]).draw(false);
                        tableAnexos.columns.adjust().draw();

                        const anexosStorage = localStorage.getItem("anexos");

                        let anexos = anexosStorage ? JSON.parse(anexosStorage) : [];

                        // anexos += $("#outroAnexo").val() ? response.nome_novo+';'+$("#outroAnexo").val()+';' : response.nome_novo+';'+response.descricao+';';

                        anexos.push({
                            nome: response.nome_novo,
                            descricao: response.descricao,
                            outroAnexo: $("#outroAnexo").val(),
                        });

                        $("#outroAnexo").val("")

                        localStorage.setItem("anexos", JSON.stringify(anexos));
                    }else{
                        document.querySelector("#alert-anexo-averbacao-fail").style.display = 'block';
                        alertTxtAnexoAverbacao.innerHTML = 'Falha ao enviar o arquivo! Tente Novamente em alguns instantes.';
                        $("#outroAnexo").val("")
                    }
                    $("#solicitar").prop('disabled', false);
                    $("#mdlAguarde").modal("toggle");
            })
            .fail(function (response) {
                document.querySelector("#alert-anexo-averbacao-fail").style.display = 'block';
                alertTxtAnexoAverbacao.innerHTML = 'Falha ao enviar o arquivo! Tente Novamente em alguns instantes.';
                $("#outroAnexo").val("")
                $("#solicitar").prop('disabled', false);
                $("#mdlAguarde").modal("toggle");
            })


            /* $.ajax({
                    url: '{{url("/averbacao_documentos")}}',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        console.log('arquivos ', response);

                        if(response.statusArquivoTransacao == 1){
                            alertTxtAnexoAverbacaoSuccess.innerHTML = 'Arquivo enviado com sucesso!';
                            document.querySelector("#alert-anexo-averbacao-success").style.display = 'block';

                            tableAnexos.row.add([
                                response.descricao,
                                response.nome_original,
                                response.nome_novo,
                                '<button type="button" class="btn btn-red e_wiggle">Remover</button>'
                            ]).draw(false);
                            tableAnexos.columns.adjust().draw();

                            const anexosStorage = localStorage.getItem("anexos");

                            let anexos = anexosStorage ? JSON.parse(anexosStorage) : [];

                            // anexos += $("#outroAnexo").val() ? response.nome_novo+';'+$("#outroAnexo").val()+';' : response.nome_novo+';'+response.descricao+';';

                            anexos.push({
                                nome: response.nome_novo,
                                descricao: response.descricao,
                                outroAnexo: $("#outroAnexo").val(),
                            });

                            $("#outroAnexo").val("")

                            localStorage.setItem("anexos", JSON.stringify(anexos));
                        }else{
                            document.querySelector("#alert-anexo-averbacao-fail").style.display = 'block';
                            alertTxtAnexoAverbacao.innerHTML = 'Falha ao enviar o arquivo! Tente Novamente em alguns instantes.';
                            $("#outroAnexo").val("")
                        }
                        $("#solicitar").prop('disabled', false);
                        $("#mdlAguarde").modal("toggle");
                    },
            }); */

            limparCamposAnexo();

        });

        const limparCamposAnexo = () => {
            $("#descricao").val('');
            $("#arquivo").val('');
        }

        $("#lancarComprovante").click(function () {
            $("#solicitar").prop('disabled', true);

            alertTxtComprovante = document.querySelector('#text-alert-comprovante-fail');
            if ($("#anexo_itbi").val() == "") {
                // alert("Por favor escolha um documento para enviar");
                document.querySelector("#alert-comprovante-averbacao-fail").style.display = 'block';
                alertTxtComprovante.innerHTML = 'Por favor escolha um comprovante de ITBI para enviar';
                return false;
            }

            alertTxtComprovante.innerHTML = '';
            document.querySelector("#alert-comprovante-averbacao-fail").style.display = 'none';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData();
            formData.append("descricao", 'comprovante_itbi');
            formData.append("arquivo", $('#anexo_itbi')[0].files[0]);

            alertTxtComprovanteSuccess = document.querySelector('#text-alert-comprovante-success');
            $.ajax({
                    url: '{{url("/averbacao_documentos")}}',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        console.log('arquivos ', response);

                        if(response.statusArquivoTransacao == 1){
                            alertTxtComprovanteSuccess.innerHTML = 'Arquivo enviado com sucesso!';
                            document.querySelector("#alert-comprovante-averbacao-success").style.display = 'block';

                            const anexosStorage = localStorage.getItem("anexos");

                            let anexos = anexosStorage ? JSON.parse(anexosStorage) : '';

                            anexos += response.nome_novo+';'+response.descricao+';';

                            localStorage.setItem("anexos", JSON.stringify(anexos));
                        }else{
                            document.querySelector("#alert-comprovante-averbacao-fail").style.display = 'block';
                            alertTxtComprovante.innerHTML = 'Falha ao enviar o arquivo! Tente Novamente em alguns instantes.';
                        }
                        $("#solicitar").prop('disabled', false);
                    },
            });

            limparCampoComprovante();

        });

        const limparCampoComprovante = () => {
            $("#anexo_itbi").val('');
        }

    });

    const verificaStatusLecom = (matricula) => {
        console.log('aff');

        var url = 'verifica_status_lecom/' + matricula;

        $.get(url, function (resposta) {
            console.log('lecom ', resposta);
            if(resposta) {
                return true;
            }else {
                return false;
            }
        });
    }

    const selectionaPesquisa = (matricula) =>{
        // $("#mdlAguarde").modal("toggle");
        $("#inscricao").val(matricula);
        $("#pesquisa").modal('toggle');

        /* let urlUm = `verifica_status_lecom/${matricula}`;

        $.get(urlUm, function (resposta) {
            if(!resposta.status) {
                alert("O processo para este imóvel ainda não foi finalizado!");
                $("#inscricao").val("");
                $("#mdlAguarde").modal("toggle");
                return false;
            }
        }); */

        let urlDois = `verifica_debitos/${matricula}`;

        $.get(urlDois, function (response) {
            if(response.bDebitoimovel) {
                alert(response.sMessage);
                // $("#mdlAguarde").modal("toggle");
                return false;
            }
        });

        var url = 'listaItbiImovel/' + $("#inscricao").val();

        $.get(url, function (resposta) {
            var obj = jQuery.parseJSON(resposta);
            if (obj.iStatus == 1) {
                $('#ListagemItbi').dataTable().fnClearTable();

                $.each(obj.aListaItbiQuitado, function(i, item) {
                    tableListaItbi.row.add( [
                        item.it01_guia,
                        moment(item.it01_data).format("DD/MM/YYYY"),
                        '<button type="button" class="btn e_wiggle" onClick="selecionaItbi(' + item.it01_guia + ');"  >Selecionar</button>'
                    ] ).draw( false );
                });
                $('#ListagemItbi').css('display', 'none' );
                $("#ListaItbi").modal('toggle');
                $('#ListagemItbi').css('display', 'block' );
                $("#alert-imovel-averbacao-fail").css('display', 'none');
                tableListaItbi.columns.adjust().draw();
                // $("#mdlAguarde").modal("toggle");
            }else {
                $("#guiaItbi").val("")
                $("#dataItbi").val("")
                $("#tipoSolicitacao").prop('disabled', true);
                $("#dataAverbacao").prop('readonly', true);
                $("#registro").prop('readonly', true);
                $("#protocolo").prop('readonly', true);
                $("#observacao").prop('readonly', true);
                $("#registro").prop('readonly', true);
                $("#inscricao").val("");
                $("#alert-imovel-averbacao-fail").css('display', 'block');
                alertTxtImovelFail = document.querySelector('#text-alert-imovel-fail');
                // alert(unescape(obj.sMessage).replace(/[+]/g, " ").replace(/[\u0300-\u036f]/g, ''));
                alertTxtImovelFail.innerHTML = "Não localizada ITBI quitada para imóvel!";
                return false;
                // $("#mdlAguarde").modal("toggle");
            }
        });
    }

    const selecionaItbi = (guia) => {
        $("#ListaItbi").modal('toggle');

        localStorage.removeItem("adquirente")

        tblAdquirente.clear().draw();

        $("#guiaItbi").val(guia);
        $("#tipoSolicitacao").prop('disabled', false);
        $("#dataAverbacao").prop('readonly', false);
        $("#registro").prop('readonly', false);
        $("#protocolo").prop('readonly', false);
        $("#observacao").prop('readonly', false);
        $("#registro").prop('readonly', false);

        $("#tipoSolicitacao").focus();

        var url = 'recupera_adquirentes_imovel/' + guia;

        $.get(url, function (resposta) {

            if(!resposta.bqlerro) {
                var obj = jQuery.parseJSON(resposta);

                console.log('adquirentes ', obj);


                const adquirenteStorage = localStorage.getItem("adquirente");

                let adquirente = adquirenteStorage ? JSON.parse(adquirenteStorage) : [];

                if(obj) {
                    Object.keys(obj.aListaAdquiriteTransmitente).map((key, index) => {
                        adquirente.push({
                            nome: unescape(obj.aListaAdquiriteTransmitente[key].nome).replace(/[+]/g, " "),
                            cpf: obj.aListaAdquiriteTransmitente[key].cgccpf,
                            telefone: unescape(obj.aListaAdquiriteTransmitente[key].telef).replace(/[+]/g, " "),
                            celular: unescape(obj.aListaAdquiriteTransmitente[key].telcel).replace(/[+]/g, " "),
                            cgm: obj.aListaAdquiriteTransmitente[key].numcgm,
                            cep: obj.aListaAdquiriteTransmitente[key].cep,
                            endereco: unescape(obj.aListaAdquiriteTransmitente[key].ender).replace(/[+]/g, " "),
                            numero: obj.aListaAdquiriteTransmitente[key].numero,
                            complemento: unescape(obj.aListaAdquiriteTransmitente[key].compl).replace(/[+]/g, " "),
                            bairro: unescape(obj.aListaAdquiriteTransmitente[key].bairro).replace(/[+]/g, " "),
                            municipio: unescape(obj.aListaAdquiriteTransmitente[key].munic).replace(/[+]/g, " "),
                            estado: unescape(obj.aListaAdquiriteTransmitente[key].uf).replace(/[+]/g, " "),
                            email: obj.aListaAdquiriteTransmitente[key].email,
                            principal: obj.aListaAdquiriteTransmitente[key].princ,
                        });
                    });
                }

                $.each(adquirente, function(i, item) {
                    if(item.principal == "Sim") {
                        $("#adquirente_principal").prop('disabled', true);

                        var elem = document.querySelector('#label_adquirente_principal p');
                        console.log('elem 3 ', elem);

                        if(!elem) {
                            var newDiv = document.createElement("P");
                            newDiv.setAttribute('class', 'alert alert-danger');
                            newDiv.innerHTML = "Não é possível adicionar mais de um adquirente principal!";
                            document.getElementById("label_adquirente_principal").appendChild(newDiv);
                        }
                    }
                    tblAdquirente.row.add( [
                        unescape(item.nome).replace(/[+]/g, " "),
                        item.cpf,
                        item.cgm,
                        item.principal,
                        '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                    ] ).draw( false );
                });
                tblAdquirente.columns.adjust().draw();

                localStorage.setItem("adquirente", JSON.stringify(adquirente));
            }

        });
    }

    var tableListaItbi = $('#ListagemItbi').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "bLengthChange": false,
        "ordering": false,
        "info": false,
        "pageLength": 4,
        "scrollY": 200,
        "searching": false,
    });

    const limpaFormularioEndereco = () => {
        //Limpa valores do formulário de cep.
        document.getElementById('endereco_adquirente').value=("");
        document.getElementById('bairro_adquirente').value=("");
        document.getElementById('municipio_adquirente').value=("");
        document.getElementById('estado_adquirente').value=("");
    }

    function preencheEndereco(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('endereco_adquirente').value=(conteudo.logradouro);
            document.getElementById('bairro_adquirente').value=(conteudo.bairro);
            document.getElementById('municipio_adquirente').value=(conteudo.localidade);
            document.getElementById('estado_adquirente').value=(conteudo.uf);
            /* $("#endereco_adquirente").prop('readonly', true);
            $("#bairro_adquirente").prop('readonly', true);
            $("#municipio_adquirente").prop('readonly', true);
            $("#estado_adquirente").prop('readonly', true); */
        } //end if.
        else {
            //CEP não Encontrado.
            limpaFormularioEndereco();
            alert("CEP não encontrado.");
        }
    }

    const pesquisaCep = (valor) => {
        $("#mdlAguarde").modal("toggle");

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');
        console.log('cep ', cep);

        //Verifica se campo cep possui valor informado.
        if (cep !== '') {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('endereco_adquirente').value="...";
                document.getElementById('bairro_adquirente').value="...";
                document.getElementById('municipio_adquirente').value="...";
                document.getElementById('estado_adquirente').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=preencheEndereco';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);
                $("#mdlAguarde").modal("toggle");

            } else {
                //cep é inválido.
                limpaFormularioEndereco();
                alert("Formato de CEP inválido.");
                $("#mdlAguarde").modal("toggle");
            }
        } else {
            //cep sem valor, limpa formulário.
            limpaFormularioEndereco();
            $("#mdlAguarde").modal("toggle");
        }
    };

    let selectAnexo = document.querySelector('#descricao');
    selectAnexo.addEventListener('change', function () {
        let value = this.value;
        console.log(value);
        if(value === "Outros") {
            $('#outroAnexo').css('display', 'block');
        }else {
            $('#outroAnexo').css('display', 'none');
        }

    });

    $('#tblAdquirente').on("click", "button", function(){
        const adquirenteStorage = localStorage.getItem("adquirente");

        let adquirente = adquirenteStorage ? JSON.parse(adquirenteStorage) : [];

        let adquirenteExcluido = '';

        tblAdquirente.row($(this).parents('tr')).data().forEach(function(column, $posicao) {
            if($posicao === 1) {
                adquirenteExcluido = column;
            }
        });

        tblAdquirente.row($(this).parents('tr')).remove().draw(false);

        let novosAdquirentes = [];

        if(adquirente != []) {
            for (const key in adquirente) {
                if (adquirente[key].cpf != adquirenteExcluido) {
                    novosAdquirentes.push({
                        nome: unescape(adquirente[key].nome).replace(/[+]/g, " "),
                        cpf: adquirente[key].cpf,
                        telefone: unescape(adquirente[key].telefone).replace(/[+]/g, " "),
                        celular: unescape(adquirente[key].celular).replace(/[+]/g, " "),
                        cgm: adquirente[key].cgm,
                        cep: adquirente[key].cep,
                        endereco: unescape(adquirente[key].endereco).replace(/[+]/g, " "),
                        numero: adquirente[key].numero,
                        complemento: unescape(adquirente[key].complemento).replace(/[+]/g, " "),
                        bairro: unescape(adquirente[key].bairro).replace(/[+]/g, " "),
                        municipio: unescape(adquirente[key].municipio).replace(/[+]/g, " "),
                        estado: unescape(adquirente[key].estado).replace(/[+]/g, " "),
                        email: adquirente[key].email,
                        principal: adquirente[key].principal,
                    });
                }
            }
        }

        if(novosAdquirentes != []) {
            console.log('hahahaha');
            let adquirentesPrincipais = 0;

            for (const key in novosAdquirentes) {
                if (novosAdquirentes[key].principal === "Sim") {
                    adquirentesPrincipais++;
                }
            }

            if(adquirentesPrincipais > 0) {
                $("#adquirente_principal").prop('disabled', true);
                var elem = document.querySelector('#label_adquirente_principal p');
                console.log('elem 1 ', elem);

                if(!elem) {
                    var newDiv = document.createElement("P");
                    newDiv.setAttribute('class', 'alert alert-danger');
                    newDiv.innerHTML = "Não é possível adicionar mais de um adquirente principal!";
                    document.getElementById("label_adquirente_principal").appendChild(newDiv);
                }
            }else {
                $("#adquirente_principal").prop('disabled', false);
                var elem = document.querySelector('#label_adquirente_principal p');
                console.log('elem 2 ', elem);

                elem ? elem.style.display = "none" : '';
            }
        }

        localStorage.setItem("adquirente", JSON.stringify(novosAdquirentes));
    });

    $("#cpf").on("input", function(){
        if($(this).val() != '') {
            $("#pesquisar-adquirente").prop('disabled', false);
        }else {
            $("#pesquisar-adquirente").prop('disabled', true);
        }
    });

    $('#documentosLancados').on("click", "button", function(){
        console.log($(this).parent());
        tableAnexos.row($(this).parents('tr')).remove().draw(false);
    });

    var tableAnexos = $('#documentosLancados').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
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

    function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
            });
        });
    }

    setInputFilter(document.getElementById("registro"), function(value) {
        return /^\d*$/.test(value);
    });

;

</script>
@endsection
