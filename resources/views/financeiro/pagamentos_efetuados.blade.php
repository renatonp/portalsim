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
                    <form action="{{ Route('integracaoPagamentosEfetuados') }}" method="post" id="formulario">
                        @csrf
                        <input type="hidden" name="tipo" id="tipo">
                        <div class="container">
                            <div class="row col-lg-12 mb-3">
                                <div class="col-lg-6 form-group">
                                    @if(strlen(Auth::user()->cpf ) == 14)
                                    <label for="cpf">CPF</label>
                                    @else
                                    <label for="cpf">CNPJ</label>
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
                                            <input type="button" id="btn_pesquisar_inscricao" class="btn btn-primary btn-sm" value="Pesquisar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <h5>Informe o tipo</h5>
                            </div>
                            <div class="row col-md-12 mb-3">
                                <span id="periodoB" class="btn btn-primary btn-sm">Período</span>
                                &nbsp;&nbsp;&nbsp;
                                <span id="exercicioB" class="btn btn-success btn-sm">Exercício</span>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="periodo">{{ __('Período') }}</label>
                                    <input type="date" class="form-control form-control-sm" id="periodo_inicial" name="periodo_inicial" disabled>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" class="form-control form-control-sm" id="periodo_final" name="periodo_final" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exercicio">{{ __('Exercício') }}</label>
                                    <input type="text" class="form-control form-control-sm" id="exercicio" name="exercicio" maxlength="4" disabled>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="exercicio" id="select_exercicio" class="form-control form-control-sm" disabled>
                                        <option value="">Selecione o ano de exercício</option>
                                        @for($i=date('Y'); $i >= (date('Y')-5); $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
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
        </form>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
        $(document).ready(function(){
            $("#incricaoB").click(function (){
                $("#matricula").prop("disabled", true);
                $("#incricao").prop("disabled", false);
            });

            $("#matriculaB").click(function (){
                $("#incricao").prop("disabled", true);
                $("#matricula").prop("disabled", false);
            });

            $("#periodoB").click(function (){
                $("#exercicio").prop("disabled", true);
                $("#select_exercicio").prop("disabled",true);
                $("#periodo_inicial").prop("disabled", false);
                $("#periodo_final").prop("disabled", false);
            });

            $("#exercicioB").click(function (){
                $("#exercicio").prop("disabled", false);
                $("#select_exercicio").prop("disabled",false);
                $("#periodo_inicial").prop("disabled", true);
                $("#periodo_final").prop("disabled", true);
            });

            $('#exercicio').keyup(function(){
                if($('#exercicio').val().length == 4){
                    $("#select_exercicio").prop("disabled",true);
                }
                else{
                    $("#select_exercicio").prop("disabled",false);
                }
            });

            $("#select_exercicio").change(function(){
                if($("#select_exercicio").val() != ""){
                    $("#exercicio").prop("disabled", true);
                }
                else{
                    $("#exercicio").prop("disabled", false);
                }
            });

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

            $('#btn_pesquisar_matricula').click(function(){
                $('#aTiposDebitosEncontradas').html('');

                $(".modal-title").html("Pesquisar Matrícula");
                $(".modal-body").html("<div class='callout-white'><div class'table_head'><div class='row'><div class='col-lg-3'><p><strong>Matrícula</strong></p></div><div class='col-lg-3'><p><strong>Tipo</strong></p></div><div class='col-lg-3'><p><strong>Planta/Quadra/Lote</strong></p></div><div class='col-lg-3'><p><strong>Ações</strong></p></div></div></div><div class='table_body'></div></div>");
                $('.table_body').html('');

                if($('#cpf').val().length == 14){
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

            $('#btn_avancar').click(function(){
                if($('#tipo').val() == 'm'){
                    if($('#matricula').val() != '' && ($('#exercicio').val() != "" || $('#select_exercicio').val()) || ($('#periodo_inicial').val() != "" &&  $('#periodo_final').val() != "")){
                        if($('#exercicio').val() != "" && $('#exercicio').val().length == 4){
                            var exercicio = $('#exercicio').val();
                        }
                        if($('#select_exercicio').val() != ""){
                            var exercicio = $('#select_exercicio').val();
                        }
                        $.post("{{ route('integracaoPagamentosEfetuados') }}",{
                            '_token':'{{ csrf_token() }}',
                            'cpf': $('#cpf').val(),
                            'matricula': $('#matricula').val(),
                             'exercicio': exercicio,
                             'periodo_inicial': $('#periodo_inicial').val(),
                             'periodo_final': $('#periodo_final').val() },function(data){
                            if(data == ''){
                                alert("Não será possível gerar o relatório de Pagamentos Efetuados à partir dos dados fornecidos.");
                            }
                            else{
                                $('#formulario').submit();
                            }
                        });
                    }
                    else{
                        alert("Não será possível gerar o relatório de Pagamentos Efetuados sem o dado da Matrícula e os dados do período ou exercício.");
                    }
                }
                else{
                    if($('#inscricao').val() != '' && ($('#exercicio').val() != "" || $('#select_exercicio').val()) || ($('#periodo_inicial').val() != "" &&  $('#periodo_final').val() != "")){
                        if($('#exercicio').val() != "" && $('#exercicio').val().length == 4){
                            var exercicio = $('#exercicio').val();
                        }
                        if($('#select_exercicio').val() != ""){
                            var exercicio = $('#select_exercicio').val();
                        }
                        $.post("{{ route('integracaoPagamentosEfetuados') }}",{
                            '_token':'{{ csrf_token() }}',
                            'cpf': $('#cpf').val(),
                            'inscricao': $('#inscricao').val(),
                            'exercicio': exercicio,
                            'periodo_inicial': $('#periodo_inicial').val(),
                            'periodo_final': $('#periodo_final').val() },function(data){
                            if(data == ''){
                                alert("Não será possível gerar o relatório de Pagamentos Efetuados à partir dos dados fornecidos.");
                            }
                            else{
                                $('#formulario').submit();
                            }
                        });
                    }
                    else{
                        alert("Não será possível gerar o relatório de Pagamentos Efetuados sem o dado da Inscrição e os dados do período ou exercício.");
                    }
                }
            });
        });
        function selectionaPesquisa(matricula){
            $('#tipo').val('m');
            $('#inscricao').val('');
            $.post("{{ route('integracaoRelatorioPagamentosEfetuados') }}",{
                '_token':'{{ csrf_token() }}',
                'cpf': $('#ro_cpf').val(),
                'matricula': matricula },function(data){
                if(data == ''){
                    alert("Esse imóvel não possui Pagamentos para a geração do relatório.");
                }
                else{
                    $("#matricula").val(matricula);
                    $('hd_matricula').val(matricula);
                    $("#default-modal").modal('hide');
                    $('#btn_avancar').css('visibility','visible');
                }
            });
        }

        function selecionaPesquisaInscricao(inscricao){
            $('#tipo').val('i');
            $('#matricula').val('');
            $.post("{{ route('integracaoRelatorioPagamentosEfetuados') }}",{
                '_token':'{{ csrf_token() }}',
                'cpf': $('#ro_cpf').val(),
                'inscricao': inscricao },function(data){
                if(data == ''){
                    alert("Essa Inscrição Municipal está baixada e não possui débitos em aberto.");
                }
                else{
                    $("#inscricao").val(inscricao);
                    $('#hd_inscricao').val(inscricao);
                    $("#default-modal").modal('hide');
                    $('#btn_avancar').css('visibility','visible');
                }
            });
        }
</script>
@endsection
