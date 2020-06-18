@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>Boletos de Taxas</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{  url('/servicos/1') }}">Cidadão </a><i class="fa fa-angle-right"></i></li>
                    <li class="active">Boletos de Taxas</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="aligncenter">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="alert alert-info" role="alert">
                                <h4>Formulário destinado a emissão de boletos de taxas</h4>
                            <p>
                                Serviço/item que possibilita ao cidadão a retirada/impressão de boleto da Taxa de requerimento para fins de abertura de processo administrativo.  <br>
                                Processos que NÃO necessitam de pagamento de Taxa de requerimento:
                                Revisão de Área Construída (Imóvel); 
                                Baixa de Débitos/Baixa por Pagamento; 
                                Compensação; 
                                Impugnação de ITBI/Suspensão de débitos para emissão de ITBI e Ouvidoria; 
                                Requerimento Funcional (RH); 
                                e Elogios, Denúncias e Reclamações.
                            </p>
                    </div>
                    <br>
                    <form class="form-horizontal topo-pagina" method="POST" action="{{ route('emitirboletotaxa') }}"
                        id="formEmitirBoleto">
                        @csrf
                        <div class="row formrow">
                            <div class="controls span2 form-label">
                                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                    Serviços
                                </label>
                            </div>

                            <div class="span8">
                                <select id="grupo" class="form-input" name="grupo">
                                    <option value="">Escolha o serviço para o qual deseja emitir o boleto</option>
                                    @foreach ($registros->aGrupoTaxa as $registro)
                                    <option value="{{ $registro->k06_taxagrupo}}|{{$registro->k06_tipo}}">
                                        {{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $registro->k06_descr)))}}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="row formrow">
                            <div class="controls span2 form-label">
                                <label for="inscricao" id="tituloPesquisa" class="col-md-4 col-form-label text-md-right">
                                    Inscrição
                                </label>
                            </div>

                            <div class="span2">
                                <input id="inscricao" type="text" name="inscricao" value="" class="form-input" readonly>
                            </div>

                            <div class="span2">
                                {{--  <a href="#pesquisa" data-toggle="modal">  --}}
                                <button type="button" class="btn e_wiggle" id="pesquisar" disabled>
                                    Pesquisar
                                </button>
                                {{--  </a>  --}}
                            </div>
                        </div>

                        <div class="row formrow">
                            <div class="controls span2 form-label">
                                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                    Nome
                                </label>
                            </div>

                            <div class="span8">
                                <input id="profissao" type="text" name="profissao" value="" class="form-input" readonly>
                            </div>
                        </div>

                        <div class="row formrow">
                            <div class="controls span2 form-label">
                                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                    Data de Vencimento
                                </label>
                            </div>

                            <div class="span2">
                                <input id="data" type="text" name="data" value="" class="form-input" readonly>
                            </div>
                            {{-- Separação --}}
                            <div class="controls span1 form-label">
                                <label for="" class="col-md-4 col-form-label text-md-right">
                                    &nbsp;
                                </label>
                            </div>
                            <div class="controls span1 form-label">
                                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                    Cidadão
                                </label>
                            </div>

                            <div class="span1">
                                <input id="cidadao" type="text" name="cidadao" value="" class="form-input" readonly>
                            </div>
                        </div>
                        <div class="row formrow">
                            <div class="controls span2 form-label">
                                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                    Valor da Taxa
                                </label>
                            </div>

                            <div class="span2">
                                <input id="vlTaxa" type="text" name="vlTaxa" value="" class="form-input" readonly>
                            </div>
                        </div>
                        <div class="row formrow">
                            <div class="controls span2 form-label">
                                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                    Histórico
                                </label>
                            </div>

                            <div class="span8">
                                <textarea maxlength="100" class="form-input" readonly id="historico" name="historico" readonly>

                            </textarea>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row formrow">
                            <div class="span6 text-left">
                                <a href="{{ url('servicos/1')  }}">
                                    <button type="button" class="btn btn-theme e_wiggle" id="voltar">
                                        {{ __('Voltar') }}
                                    </button>
                                </a>
                            </div>
                            <div class="span6 text-right">
                                <button type="button" class="btn btn-theme e_wiggle" id="gerarBoleto">
                                    {{ __('Gerar Boleto') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
</section>


@endsection


@section('post-script')
<script type="text/javascript">
    jQuery(document).ready(function(){

        var tablePesquisaTaxa = $('#pesquisaTaxa').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "bLengthChange": false,
            "ordering": false,
            "info": false,
            "pageLength": 5,
            "scrollY": 250,
            "searching": false,
        });

        var pesquisaInscricaoTaxaTbl = $('#pesquisaInscricaoTaxaTbl').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "bLengthChange" : false,
            "pageLength"    : 5,
            "searching"     : false,
            "ordering"      : false,
            "scrollY"       : 250,
            "info"          : false,
        });

        $("#pesquisar").click(function(){
            var str = $("#grupo").val();
            var res = str.split("|");
            var cod = '{{ str_replace("/", "_", Auth::user()->cpf)  }}';
            // res[1]="i";

            if(res[1]=="m"){
                var url = 'taxasconsultamatricula/' + cod;
                if($("#inscricao").val() != ""){
                    url = url + '/' + $("#inscricao").val();
                }

                $.get(url, function (resposta) {
                    var obj = jQuery.parseJSON(resposta);
                    if (obj.iStatus == 1) {
                        // $("#profissao").val(obj.nome);
                        // $("#cidadao").val(obj.numcgm);
                        // $("#inscricao").val(obj.numcgm);
                        $('#pesquisaTaxa').dataTable().fnClearTable();
                        $.each(obj.aMatriculasCgmEncontradas, function(i, item) {
                            // alert(item.matricula);
                            tablePesquisaTaxa.row.add( [
                                item.matricula,
                                item.tipo,
                                unescape(item.bairro).replace(/[+]/g, " "),
                                unescape(item.logradouro).replace(/[+]/g, " "),
                                item.numero,
                                unescape(item.complemento).replace(/[+]/g, " "),
                                unescape(item.planta + " / " +
                                item.quadra + " / " +
                                item.lote).replace(/[+]/g, " "),
                                '<button type="button" class="btn e_wiggle" onClick="javascript:selectionaPesquisa(' + item.matricula + ');"  >Selecionar</button>'
                            ] ).draw( false );
                        });
                        $('#pesquisa').css('display', 'none' );
                        $("#pesquisa").modal('toggle');
                        $('#pesquisa').css('display', 'block' );
                        tablePesquisaTaxa.columns.adjust().draw();
                    }
                    else {
                        alert("Não foi possivel consultar a matrícula dos seus imóveis\n\nCódigo: TAX_003");
                        return false;
                    }
                });
            }
            else if(res[1]=="i"){

                // var url = 'taxasconsultainscricao/97323250706';
                // var url = 'taxasconsultainscricao/{{ Auth::user()->cpf }}';
                var url = 'taxasconsultainscricao/' + cod ;
                $.get(url, function (resposta) {
                    var obj = jQuery.parseJSON(resposta);
                    if (obj.iStatus == 1) {
                        $('#pesquisaInscricaoTaxaTbl').dataTable().fnClearTable();
                        $.each(obj.aInscBase, function(i, item) {
                            pesquisaInscricaoTaxaTbl.row.add( [
                                item.q02_inscr,
                                unescape(item.z01_nome).replace(/[+]/g, " "),
                                unescape(item.z01_ender).replace(/[+]/g, " "),
                                item.z01_numero,
                                unescape(item.z01_compl).replace(/[+]/g, " "),
                                '<button type="button" class="btn e_wiggle" onClick="javascript:selectionaPesquisaInscricao(' + item.q02_inscr + ');"  >Selecionar</button>'
                            ] ).draw( true );
                        });
                        $('#pesquisaInscricaoTaxa').css('display', 'none' );
                        $("#pesquisaInscricaoTaxa").modal('toggle');
                        $('#pesquisaInscricaoTaxa').css('display', 'block' );
                        pesquisaInscricaoTaxaTbl.columns.adjust().draw();
                    }
                    else {
                        alert("Não foi possivel consultar a inscrição dos seus imóveis\n\nCódigo: TAX_004");
                        return false;
                    }
                });


            }
        });

        $("#gerarBoleto").click(function(){
            $("#formEmitirBoleto").submit();
        });

        $("#grupo").change(function(){
            $("#profissao").val("");
            $("#cidadao").val("");
            $("#inscricao").val("");
            $("#vlTaxa").val("");
            $("#data").val("");
            $("#historico").val("");
            $("#historico").prop('readonly', true);

            var str = $("#grupo").val();
            var res = str.split("|");

            // res[1]="i";

            if(res[1]=="c"){
                $("#inscricao").prop('readonly', true);
                $("#pesquisar").prop('disabled', true);
                $("#tituloPesquisa").html('CGM');
                $("#pesquisar").removeClass("btn-blue");
                $("#inscricao").val('');

                var cod = '{{ str_replace("/", "_", Auth::user()->cpf)  }}';
                var url = 'taxasconsultacgm/' + cod;
    
                $.get(url, function (resposta) {
                    var obj = jQuery.parseJSON(resposta);
                    if (obj.iStatus == 1) {
                        $("#profissao").val(obj.nome);
                        $("#cidadao").val(obj.numcgm);
                        $("#inscricao").val(obj.numcgm);

                        var url2 = 'taxasconsultavalor/'+ res[1] +'/'+ obj.numcgm+'/'+res[0];
    
                        $.get(url2, function (resposta2) {
                            var obj2 = jQuery.parseJSON(resposta2);

                            if (obj2.iStatus == 1) {

                                $("#vlTaxa").val(obj2.fTotalTaxa.toLocaleString('pt-br', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                // $("#historico").val();
                                $("#data").val(dataAtualFormatada());
                                $("#historico").val(obj2.sMessage)
                                $("#historico").prop('readonly', true);
                                $("#historico").setfocus();

                            }
                            else {
                                alert("Não foi possivel gerar o boleto para o serviço escolhido\n\nCódigo: TAX_002");
                                return false;
                            }
                        });
                    }
                    else {
                        alert("Não foi possivel gerar nenhum boleto para o serviço escolhido\n\nCódigo: TAX_005");
                        return false;
                    }
                });
            }
            else if(res[1]=="m"){
                //****************** Matrícula
                $("#inscricao").val('');
                $("#inscricao").prop('readonly', false);
                $("#pesquisar").prop('disabled', false);
                $("#tituloPesquisa").html('Matrícula');
                $("#pesquisar").addClass("btn-blue");
                $("#inscricao").focus();
            }
            else if(res[1]=="i"){
                $("#inscricao").val('');
                $("#inscricao").prop('readonly', false);
                $("#tituloPesquisa").html('Inscrição');
                $("#pesquisar").prop('disabled', false);
                $("#pesquisar").addClass("btn-blue");            
                $("#inscricao").focus();
            }

        });
        


    });
    function dataAtualFormatada(){
        var data = new Date()
        data.setDate(data.getDate() + 1);
        var dia  = data.getDate().toString(),
            diaF = (dia.length == 1) ? '0'+dia : dia,
            mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
            mesF = (mes.length == 1) ? '0'+mes : mes,
            anoF = data.getFullYear();
        return diaF+"/"+mesF+"/"+anoF;
    }

    function selectionaPesquisa(matricula){
        $("#inscricao").val(matricula);

        var str = $("#grupo").val();
        var res = str.split("|");

        var url2 = 'taxasconsultavalor/'+ res[1] +'/'+ matricula +'/'+res[0];
    
        $.get(url2, function (resposta2) {
            var obj2 = jQuery.parseJSON(resposta2);
            console.log(obj2);

            if (obj2.iStatus == 1) {
                
                $("#profissao").val(obj2.sNomeCgm);
                $("#vlTaxa").val(obj2.fTotalTaxa.toLocaleString('pt-br', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                // $("#historico").val();
                $("#data").val(dataAtualFormatada());
                $("#cidadao").val(obj2.iNumCgm)
                $("#historico").val(obj2.sMessage)
                $("#historico").prop('readonly', true);
                $("#historico").setfocus();                

            }
            else {
                alert("Não foi possivel gerar nenhum boleto para o serviço escolhido\n\nCódigo: TAX_006");
                return false;
            }
        });
        $("#pesquisa").modal('toggle');
    }

    function selectionaPesquisaInscricao(inscricao){
        $("#inscricao").val(inscricao);

        var str = $("#grupo").val();
        var res = str.split("|");

        var url2 = 'taxasconsultavalor/'+ res[1] +'/'+ inscricao +'/'+res[0];
    
        $.get(url2, function (resposta2) {
            var obj2 = jQuery.parseJSON(resposta2);
            console.log(obj2);

            if (obj2.iStatus == 1) {
                
                $("#profissao").val((obj2.sNomeCgm));
                $("#vlTaxa").val(obj2.fTotalTaxa.toLocaleString('pt-br', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                // $("#historico").val();
                $("#data").val(dataAtualFormatada());
                $("#cidadao").val(obj2.iNumCgm)
                //$("#historico").val((obj2.sMessage))
                $("#historico").prop('readonly', false);
                $("#historico").setfocus();
            }
            else {
                alert("Não foi possivel gerar nenhum boleto para o serviço escolhido\n\nCódigo: TAX_006");
                return false;
            }
        });

        $("#pesquisaInscricaoTaxa").modal('toggle');
    }
</script>
@endsection