@extends('layouts.tema_principal')
@section('content')
<div class="container-fluid">
    @include('modals.modal_default')
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col-lg-12">
                <h2 class="mb-4"><i class="fa fa-home"></i> Consulta Geral Financeira</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><h4>{{ $pagina }}</h4></div>
                <div class="card-body">
                    <form method="post" id="formulario">
                        @csrf
                        <input type="hidden" name="tipo_pesquisa" id="tipo_pesquisa">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    @if(strlen(Auth::user()->cpf ) == 14)
                                    <label for="ro_cpf">CPF</label>
                                    @else
                                    <label for="ro_cpf">CNPJ</label>
                                    @endif
                                    <input type="hidden"name="cpf" id="cpf" value="{{ $cpf }}">
                                    <input type="text" class="form-control form-control-sm" name="ro_cpf" id="ro_cpf" value="{{ $cpf }}" readonly="readonly">
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label for="matricula">Matrícula:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" name="matricula" id="matricula" readonly="readonly">
                                        <div class="input-group-append">
                                            <input type="button" id="btn_pesquisar_matricula" class="btn btn-primary btn-sm" value="Pesquisar">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label for="ro_nome">Nome:</label>
                                    <input type="hidden"name="nome" id="nome" value="{{ $nome }}">
                                    <input type="text" class="form-control form-control-sm" name="ro_nome" id="ro_nome" value="{{ $nome }}" readonly="readonly">
                                </div>

                                <div class="col-lg-6 form-group">
                                    <label for="inscricao">Inscrição:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" name="inscricao" id="inscricao" readonly="readonly">
                                        <div class="input-group-append">
                                            <input type="button" id="btn_pesquisar_inscricao" class="btn btn-primary btn-sm" value="Pesquisar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 form-group" id="linha_debitos" style="visibility: hidden;">
                                    <label for="tipo_debito">Tipo de Débito:</label>
                                    <select class="form-control form-control-sm" id="tipo_debito" name="tipo_debito"><option value="0">Selecione o tipo de débito</option></select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button id="btn_voltar" class="btn btn-primary form-control mt-3" value="Voltar"><i class="fa fa-arrow-left"></i> Voltar</button>
                </div>
                <div class="col-md-6">
                    <button id="btn_avancar" class="btn btn-success form-control mt-3" style="visibility: hidden;">Avançar <i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        function onlynumber(evt) {
           var theEvent = evt || window.event;
           var key = theEvent.keyCode || theEvent.which;
           key = String.fromCharCode( key );
           //var regex = /^[0-9.,]+$/;
           var regex = /^[0-9.]+$/;
           if( !regex.test(key) ) {
              theEvent.returnValue = false;
              if(theEvent.preventDefault) theEvent.preventDefault();
           }
        }
        $(document).ready(function(){
            if($("#cpf").val().length == 14){
                $('#btn_voltar').click(function(){
                    window.location.replace("servicos/1/financeiro");
                });
            }
            else{
                $('#btn_voltar').click(function(){
                    window.location.replace("servicos/2/financeiro");
                });
            }
            if($('#cpf').val().length == 14){
                var cpf1 = $('#cpf').val();
                var cpf2 = cpf1.replace("/","-");
                $('#cpf').val(cpf2);
            }

            $('#btn_pesquisar_matricula').click(function(){
                $('#aTiposDebitosEncontradas').html('');

                $(".modal-title").html("Pesquisar Matrícula");
                $(".modal-body").html("<div class='callout-white'><div class'table_head'><div class='row'><div class='col-lg-3'><p><strong>Matrícula</strong></p></div><div class='col-lg-3'><p><strong>Tipo</strong></p></div><div class='col-lg-3'><p><strong>P/Q/L</strong></p></div><div class='col-lg-3'><p><strong>Ações</strong></p></div></div></div><div class='table_body'></div></div>");
                $('.table_body').html('');

                if($('#ro_cpf').val().length == 14){
                    var cpf = $('#ro_cpf').val().replace(".","");
                    var cpf1 = cpf.replace("-","");
                    cpf = cpf1;
                }
                else{
                    var cpf = $('#ro_cpf').val().replace(".","");
                    var cpf1 = cpf.replace("/","");
                    var cpf2 = cpf1.replace(".","");
                    var cpf3 = cpf2.replace("-","");
                    cpf = cpf3;
                }

                var url = 'listaImoveis/'+cpf+'/';

                $.get(url, function (resposta) {
                    console.log('resposta ', resposta);
                    var obj = jQuery.parseJSON(resposta);
                    if (obj.iStatus == 1) {
                        console.log('obj ', obj);
                        $('#pesquisaTaxa').dataTable().fnClearTable();
                        if(obj.aMatriculasCgmEncontradas.length > 0){
                            $.each(obj.aMatriculasCgmEncontradas, function(i, item) {
                                $('.table_body').append(
                                    "<div class='row'>"+
                                        "<div class='col-lg-3'>"+item.matricula+"</div>"+
                                        "<div class='col-lg-3'>"+item.tipo+"</div>"+
                                        "<div class='col-lg-3'>"+unescape(item.planta + " / " + item.quadra + " / " + item.lote).replace(/[+]/g, " ")+"</div>"+
                                        "<div class='col-lg-3'><button type='button' class='btn btn-primary' onClick='selectionaPesquisa(" + item.matricula + ");'  >Selecionar</button></div>"+
                                    "</div>");
                            });
                            $("#default-modal").modal('show');
                        }
                        else{
                            alert("Nenhuma matrícula foi encontrada para este usuário.");
                        }
                    }
                    else {
                        alert("Quantidade de imóveis acima do permitido.");
                        return false;
                    }
                });
            });

            $('#btn_pesquisar_inscricao').click(function(){
                $(".modal-title").html("Pesquisar Inscrição");
                $(".modal-body").html("<div class='callout-white'><div class'table_head'><div class='row'><div class='col-lg-3'><p><strong>Inscrição</strong></p></div><div class='col-lg-3'><p><strong>Nome</strong></p></div><div class='col-lg-3'><p><strong>Endereço</strong></p></div><div class='col-lg-3'><p><strong>Ações</strong></p></div></div></div><div class='table_body'></div></div>");
                $('.table_body').html('');

                if($('#ro_cpf').val().length == 14){
                    var cpf = $('#ro_cpf').val().replace(".","");
                    var cpf1 = cpf.replace("-","");
                    cpf = cpf1;
                }
                else{
                    var cpf = $('#ro_cpf').val().replace(".","");
                    var cpf1 = cpf.replace("/","");
                    var cpf2 = cpf1.replace(".","");
                    var cpf3 = cpf2.replace("-","");
                    cpf = cpf3;
                }

                var url = 'taxasconsultainscricao/' + cpf +'/';
                $.get(url, function (resposta) {
                    var obj = jQuery.parseJSON(resposta);
                    if (obj.iStatus == 1) {
                        $('#pesquisaInscricaoTaxaTbl').dataTable().fnClearTable();
                        if(obj.aInscBase.length > 0){
                            $.each(obj.aInscBase, function(i, item) {
                                $('.table_body').append(
                                    "<div class='row'>"+
                                        "<div class='col-lg-3'>"+item.q02_inscr+"</div>"+
                                        "<div class='col-lg-3'>"+unescape(item.z01_nome).replace(/[+]/g, " ")+"</div>"+
                                        "<div class='col-lg-3'>"+unescape(item.z01_ender).replace(/[+]/g, " ")+"</div>"+
                                        "<div class='col-lg-3'><button type='button' class='btn btn-primary' onClick='selecionaPesquisaInscricao(" + item.q02_inscr + ");'  >Selecionar</button></div>"+
                                    "</div>");
                            });
                            $("#default-modal").modal('show');
                        }
                        else{
                            alert("Nenhuma inscrição foi encontrada para este usuário.");
                        }
                    }
                    else {
                        alert("Quantidade de imóveis acima do permitido.");
                        return false;
                    }
                });
            });
        });
        
        function selectionaPesquisa(matricula){
            $('#tipo_pesquisa').val('m');
            $('#inscricao').val('');
            $.post("{{ route('integracaoRelatorioTotalDebitos') }}",{
                '_token':'{{ csrf_token() }}', 
                'cpf': $('#ro_cpf').val(), 
                'nome':$('#ro_nome').val(), 
                'matricula': matricula, 
                'tipo': 'm', 
                'tipo_relatorio': 'r' },function(data){
                if(data == ''){
                    alert("Esse imóvel não possui Débitos em Aberto para a geração do relatório.");
                }
                else{
                    $("#matricula").val(matricula);
                    $('#hd_matricula').val(matricula);
                    $("#pesquisa").modal('hide');
                    $('#tipo_debito').html("");
                    $('#tipo_debito').append("<option value='0'>Selecione o tipo de débito</option>");

                    $('#linha_debitos').css("visibility","visible");
                    var cpf = $('#cpf').val();
                    if(cpf.length == 14){
                        var cpf_new = cpf.replace("/","-");
                        cpf = cpf_new;
                    }
                    console.log($('#tipo_pesquisa').val()+'\n'+cpf+'\n'+$('#matricula').val());
                    $.post("{{ route('integracaoPesquisaTipoDebitos') }}",{
                        '_token':'{{ csrf_token() }}', 
                        'cpf': cpf, 
                        'matricula': $('#matricula').val(),
                        'tipo': 'm' },function(data){
                        if(data == ''){
                            alert("Esse imóvel não possui Débitos em Aberto deste relatório.");
                        }
                        else{
                            console.log(data);
                            var obj = jQuery.parseJSON(data);
                            for(var i=0; i < obj.aTiposDebitosEncontradas.length; i++){
                                var descricao_bebito = obj.aTiposDebitosEncontradas[i].sDescricaoDeb;
                                var new_descricao_bebito = descricao_bebito.replace("+"," ");
                                $('#tipo_debito').append("<option value='"+obj.aTiposDebitosEncontradas[i].iTipoDeb+"'>"+new_descricao_bebito+"</option>")
                            }
                            $("#default-modal").modal('hide');
                        }
                    });
                }
            });
        }

        function selecionaPesquisaInscricao(inscricao){
            $('#tipo_pesquisa').val('i');
            $('#matricula').val('');
            $.post("{{ route('integracaoRelatorioTotalDebitos') }}",{
                '_token':'{{ csrf_token() }}', 
                'cpf': $('#ro_cpf').val(), 
                'nome':$('#ro_nome').val(), 
                'inscricao': inscricao, 
                'tipo': 'i', 
                'tipo_relatorio': 'r' },function(data){
                if(data == ''){
                    alert("Essa Inscrição Municipal está baixada e não possui débitos em aberto.");
                }
                else{
                    $("#inscricao").val(inscricao);
                    $('hd_inscricao').val(inscricao);
                    $("#pesquisaInscricaoTaxa").modal('hide');
                    $('#tipo_debito').html("");
                    $('#tipo_debito').append("<option value='0'>Selecione o tipo de débito</option>");

                    $('#linha_debitos').css("visibility","visible");
                    var cpf = $('#cpf').val();
                    if(cpf.length == 14){
                        var cpf_new = cpf.replace("/","-");
                        cpf = cpf_new;
                    }
                    $.post("{{ route('integracaoPesquisaTipoDebitos') }}",{
                        '_token':'{{ csrf_token() }}', 
                        'cpf': cpf, 
                        'inscricao': inscricao,
                        'tipo': 'i' },function(data){
                        if(data == ''){
                            alert("Essa Inscrição Municipal está baixada e não possui débitos em aberto.");
                        }
                        else{
                            console.log(data);
                            var obj = jQuery.parseJSON(data);
                            for(var i=0; i < obj.aTiposDebitosEncontradas.length; i++){
                                var descricao_bebito = obj.aTiposDebitosEncontradas[i].sDescricaoDeb;
                                var new_descricao_bebito = descricao_bebito.replace("+"," ");
                                $('#tipo_debito').append("<option value='"+obj.aTiposDebitosEncontradas[i].iTipoDeb+"'>"+new_descricao_bebito+"</option>")
                            }
                            $("#default-modal").modal('hide');
                        }
                    });
                }
            });
        }

        $('#tipo_debito').change(function(){
            $('#formulario').attr("action","{{ Route('relatorioDebitosAbertos') }}");
            $('#formulario').submit();
        });
    </script>
@endsection
