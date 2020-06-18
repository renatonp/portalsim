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
                    <div class="container">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                @if(strlen(Auth::user()->cpf ) == 14)
                                <label for="cpf">{{ __('CPF') }}</label>
                                @else
                                <label for="cpf">{{ __('CNPJ') }}</label>
                                @endif
                                <input type="text" class="form-control form-control-sm" name="cpf" value="{{ Auth::user()->cpf }}" readonly="readonly" />
                            </div>
                            <div class="col-md-6 mb-3">
                                @if(strlen(Auth::user()->cpf ) == 14)
                                <label for="matricula">{{ __('Matrícula') }}</label>
                                @else
                                <label for="matricula">{{ __('Inscrição') }}</label>
                                @endif
                                <input type="text" class="form-control form-control-sm" name="matricula" value="{{ $matricula_inscricao }}" readonly="readonly" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nome">{{ __('Nome') }}</label>
                                <input type="text" class="form-control form-control-sm" name="nome" value="{{ Auth::user()->name }}" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="formulario" action="{{ route('integracaoReciboDebitos') }}" method="post">
                        @csrf
                        <input type="hidden" name="tipo_pesquisa" id="tipo_pesquisa" name="tipo_pesquisa" value="{{ $tipo_pesquisa }}">
                        <input type="hidden" name="matricula_inscricao" id="matricula_inscricao" name="matricula_inscricao" value="{{ $matricula_inscricao }}">
                        <input type="hidden" name="tipo_debito" id="tipo_debito" name="tipo_debito" value="{{ $tipo_debito }}">
                        <section id="content">
                            <div class="container">
                            	<div class="col-lg-12">
                                    @php
                                    $i=1;
                                    @endphp
                            		<table class="table table-striped table-bordered dataTable dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                            	<th align="center">Inf.</th>
                                            	<th align="center"><strong>Arrecadação</strong></th>
                                                <th align="center"><strong>Parcela</strong></th>
                                                <th align="center"><strong>Vencimento</strong></th>
                                                <th align="center"><strong>Receita</strong></th>
                                                <th align="center"><strong>Valor</strong></th>
                                                <th align="center"><strong>Corrigido</strong></th>
                                                <th align="center"><strong>Juros</strong></th>
                                                <th align="center"><strong>Multa</strong></th>
                                                <th align="center"><strong>Desconto</strong></th>
                                                <th align="center"><strong>Total</strong></th>
                                                <th align="center"><strong>M</strong>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="checkAll" class="checkAll" id="checkAll"></th>
                                			</tr>
                                        </thead>
                            			<tbody>
                                            @if(isset($registros_unicos))
                                                @foreach($registros_unicos as $ru)
                                                    @php
                                                    $k00_receit1 = str_replace('+',' ',$ru->k00_receit);
                                                    $vet_k00_receit1 = explode(' ',$k00_receit1);
                                                    $k00_receit = $vet_k00_receit1[0].$vet_k00_receit1[1].$vet_k00_receit1[2];
                                                    @endphp
                                					<tr @if($i%2 == 0) style="background-color: #DCDCDC" @endif>
                                                        <td><input type="button" class="btn btn-success" value="+" title="Informações Adicionais" inf="&nbsp;_{{ $ru->uvlrhis }}_{{ $ru->k00_numpar }}_{{ $ru->uvlrdesconto }}" onclick="informacoesAdicionais({{ $j }})"></td>
                                						<td align="center">{{ $ru->k00_numpre }}</td>
                                						<td align="center">{{ $ru->k00_numpar }}</td>
                                						@if(date("Ymd",strtotime($ru->dtvencunic)) < date("Ymd"))
                                							<td align="center"><font color="#FF0000"><strong>{{ date("d/m/Y",strtotime($ru->dtvencunic)) }}</strong></font></td>
                                						@else
                                                            @if(date("m",strtotime($ru->dtvencunic)) == date("m"))
                                    							<td align="center"><font color="#FFA500"><strong>{{ date("d/m/Y",strtotime($ru->dtvencunic)) }}</strong></font></td>
                                                            @else
                                                                <td align="center">{{ date("d/m/Y",strtotime($ru->dtvencunic)) }}</td>
                                                            @endif
                                						@endif
                                						<td align="center">{{ $k00_receit }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$ru->uvlrhis) }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$ru->uvlrcor) }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$ru->uvlrjuros) }}</td>
                                						<td align="center">R$ {{ $ru->uvlrmulta }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$ru->uvlrdesconto) }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$ru->utotal) }}</td>
                                                        <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="registros_unicos" class="registros_unicos" value="{{ $ru->k00_numpre }}_{{ $ru->k00_numpar }}_{{ $ru->dtvencunic }}_{{ str_replace('+',' ',$ru->k00_receit) }}_{{ str_replace('.',',',$ru->uvlrhis) }}_{{ str_replace('.',',',$ru->uvlrcor) }}_{{ $ru->uvlrjuros }}_{{ $ru->uvlrmulta }}_{{ str_replace('.',',',$ru->uvlrdesconto) }}_{{ str_replace('.',',',$ru->utotal) }}"></td>
                                                    </tr>
                                                    @php
                                                    $i++;
                                                    @endphp
                                            	@endforeach
                                            @endif
                                            @php
                                            $j=0;
                                            @endphp
                                            @if(isset($registros))
                                                @foreach($registros as $registro)
                                                    @php
                                                    $k00_receit1 = str_replace('+',' ',$registro->k00_receit);
                                                    $vet_k00_receit1 = explode(' ',$k00_receit1);
                                                    $k00_receit = $vet_k00_receit1[0].$vet_k00_receit1[1].$vet_k00_receit1[2];
                                                    @endphp
                                					<tr @if($i%2 == 0) style="background-color: #DCDCDC" @endif>
                                                        <td><input type="button" name="btn_inf_normais[]" class="btn btn-success" id="btn_inf_normais_{{ $j }}" value="+" title="Informações Adicionais" inf="&nbsp;_{{ $registro->valor }}_{{ $registro->k00_numpar }}_{{ $registro->desconto }}" data-toggle="modal" onclick="informacoesAdicionais({{ $j }})"></td>
                                						<td align="center">{{ $registro->k00_numpre }}</td>
                                						<td align="center">{{ $registro->k00_numpar }}</td>
                                                        @if($tipo_debito == 34)
                                                            @if(date("Ymd",strtotime($registro->k00_dtinicial)) < date("Ymd"))
                                                                <td align="center"><font color="#FF0000"><strong>{{ date("d/m/Y",strtotime($registro->k00_dtinicial)) }}</strong></font></td>
                                                            @else
                                                                @if(date("m",strtotime($registro->k00_dtinicial)) == date("m"))
                                                                    <td align="center"><font color="#FFA500"><strong>{{ date("d/m/Y",strtotime($registro->k00_dtinicial)) }}</strong></font></td>
                                                                @else
                                                                    <td align="center">{{ date("d/m/Y",strtotime($registro->k00_dtinicial)) }}<br /></td>
                                                                @endif
                                                            @endif
                                                        @else
                                                            @if(date("Ymd",strtotime($registro->k00_dtvenc)) < date("Ymd"))
                                                                <td align="center"><font color="#FF0000"><strong>{{ date("d/m/Y",strtotime($registro->k00_dtvenc)) }}</strong></font></td>
                                                            @else
                                                                @if(date("m",strtotime($registro->k00_dtvenc)) == date("m"))
                                                                    <td align="center"><font color="#FFA500"><strong>{{ date("d/m/Y",strtotime($registro->k00_dtvenc)) }}</strong></font></td>
                                                                @else
                                                                    <td align="center">{{ date("d/m/Y",strtotime($registro->k00_dtvenc)) }}</td>
                                                                @endif
                                                            @endif
                                                        @endif
                                						<td align="center">{{ $k00_receit }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$registro->valor) }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$registro->valorcorr) }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$registro->juros) }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$registro->multa) }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$registro->desconto) }}</td>
                                						<td align="center">R$ {{ str_replace('.',',',$registro->total) }}</td>
                                                        <td align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="registros_normais[]" class="registros_normais" value="{{ $registro->k00_numpre }}_{{ $registro->k00_numpar }}_{{ $registro->k00_dtvenc }}_{{ str_replace('+',' ',$registro->k00_receit) }}_{{ $registro->valor }}_{{ $registro->valorcorr }}_{{ $registro->juros }}_{{ $registro->multa }}_{{ $registro->desconto }}_{{ $registro->total }}"></td>
                                                    </tr>
                                                    @php
                                                    $i++;
                                                    $j++;
                                                    @endphp
                                            	@endforeach
                                            @endif
                                    	</tbody>
                                	</table>
                            	</div>
                                <br />
                                <div class="row col-md-12" align="center">
                                    <div class="col-md-6"><strong>Data de vencimento do boleto:</strong></div>
                                    <div class="col-md-3"><input type="date" class="form-control form-control-sm" id="dataVencimento" name="dataVencimento"></div>
                                </div>                                    
                                <br />
                                <div class="row col-lg-12" align="center">
                                    <table class="table table-striped table-bordered dataTable dt-responsive nowrap w-100">
                                        <thead>
                                            <th width='15%'><strong>Valor</strong></th>
                                            <th width='15%'><strong>Corrigido</strong></th>
                                            <th width='15%'><strong>Juros</strong></th>
                                            <th width='15%'><strong>Multa</strong></th>
                                            <th width='15%'><strong>Desconto</strong></th>
                                            <th width='15%'><strong>Total</strong></th>
                                        </thead>
                                        <tr id="linha_totais">
                                        </tr>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span id="btn_voltar" class="btn btn-primary form-control mt-3"><i class="fa fa-arrow-left"></i> Voltar</button>
                                    </div>
                                    <div class="col-md-6">
                                        <span id="btn_emitir_boleto" class="btn btn-success form-control mt-3">Emitir Boleto <i class="fa fa-print"></i></button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function informacoesAdicionais(indice){
        var inf = $('#btn_inf_normais_'+indice).attr('inf');
        console.log(inf);
        var vet_inf = inf.split('_');
        var valor = vet_inf[1];
        var parcela = vet_inf[2];
        var desconto = vet_inf[3];

        $(".modal-title").html("Informacoes Adicionais");
        $('.modal-body').html("<div class='callout-white'><div class'table_head'><div class='row'><div class='col-lg-4' align='center'><p><strong>Valor</strong></p></div><div class='col-lg-4' align='center'><p><strong>Número de Parcelas</strong></p></div><div class='col-lg-4' align='center'><p><strong>Desconto</strong></p></div></div></div><div class='table_body'></div></div>");
        
        $('.table_body').append("<div class='row'><div class='col-lg-4' align='center'>R$ "+valor+"</div><div class='col-lg-4' align='center'>"+parcela+"</div><div class='col-lg-4' align='center'>R$ "+desconto+"</div></div>");
        $("#default-modal").modal('show');
    }

    $(document).ready(function(){
        $('#btn_voltar').click(function(){
            history.back();
        });
        var numpre = [];
        var numpar = [];

        $('#checkAll').click(function(){
            $('#linha_totais').html('');
            if($('#checkAll').is(':checked')){
                var checkbox = $('input:checkbox[name^=registros_normais]');
                checkbox.each(function(){
                    checkbox.prop('checked',true);
                });
                var checkbox_checked = $('input:checkbox[name^=registros_normais]:checked');
                if(checkbox_checked.length > 0){
                    var val = [];
                    var valor = 0;
                    var corrigido = 0;
                    var juros = 0;
                    var multa = 0;
                    var desconto = 0;
                    var total = 0;
                    checkbox_checked.each(function(){
                        val.push($(this).val());
                        var colunas = $(this).val().split("_");
                        valor += parseFloat(colunas[4]);
                        corrigido+=parseFloat(colunas[5]);
                        juros+=parseFloat(colunas[6]);
                        multa+=parseFloat(colunas[7]);
                        desconto+=parseFloat(colunas[8]);
                        total+=parseFloat(colunas[9]);
                    });
                    $('#linha_totais').append("<td width='15%'><strong>R$ "+valor.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='valor_total' id='valor_total' value='"+valor.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+corrigido.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='corrigido_total' id='corrigido_total' value='"+corrigido.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+juros.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='juros_total' id='juros_total' value='"+juros.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+multa.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='multa_total' id='multa_total' value='"+multa.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+desconto.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='desconto_total' id='desconto_total' value='"+desconto.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+total.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='total_total' id='total_total' value='"+total.toFixed(2)+"'></strong></td>");
    //                console.log(val);
                }
            }
            else{
                var checkbox = $('input:checkbox[name^=registros_normais]');
                checkbox.each(function(){
                    checkbox.prop('checked',false);
                });
            }
        });

        $('.registros_unicos').click(function(){
   			if($('.registros_unicos').is(':checked')){
        		$('.registros_normais').prop('checked',false);
                $('#checkAll').prop('checked',false);
   			}
		});
        $('.registros_normais').click(function(){
        	if($('.registros_normais').is(':checked')){
        		$('.registros_unicos').prop('checked',false);
        	}
		});
        $('#checkAll').click(function(){
            if($('#checkAll').is(':checked')){
                $('.registros_unicos').prop('checked',false);
            }
        });

        $('#btn_emitir_boleto').click(function(){
            var data_vencimento = $('#dataVencimento').val();

            if($('.registros_unicos').is(':checked')){
                $('.registros_unicos').each(function(){
                    var dados = $(this).val().split("_");
                    $.post("{{ route('integracaoReciboDebitos') }}",{
                    '_token':'{{ csrf_token() }}',
                    'matricula_inscricao':$('#matricula_inscricao').val(),
                    'tipo_pesquisa':$('#tipo_pesquisa').val(),
                    'tipo_debito':$('#tipo_debito').val(),
                    'numpre_unica':dados[0],
                    'numpar_unica':dados[1],
                    'd_data_vencimento':data_vencimento  },function(data){
                        if(data == ''){
                            alert("Não foi possível emitir um boleto à partir deste número de arrecadação.");
                        }
                    });
                });
            }
            if($('.registros_normais').is(':checked')){
                var checkbox = $('input:checkbox[name^=registros_normais]:checked');
                if(checkbox.length > 0){
                    var data = new Date();
                    var data_vencimento = $('#dataVencimento').val();
                    if(data_vencimento != ""){
                        var data_vencimento_vet_numbers = $('#dataVencimento').val().split('-');
                        var data_vencimento_numbers = data_vencimento_vet_numbers[0]+data_vencimento_vet_numbers[1]+data_vencimento_vet_numbers[2];
                        var ano_atual = data.getFullYear();
                        if((data.getMonth()+1) < 10){
                            var mes_atual = (data.getMonth()+1);
                            mes_atual = '0'+mes_atual;
                        }
                        else{
                            var mes_atual = (data.getMonth()+1);
                        }
                        var dia_atual = data.getDate();
                        var data_atual = ano_atual.toString()+mes_atual.toString()+dia_atual.toString();
                        if(data_vencimento_numbers > data_atual){
                            $('#formulario').submit();
                        }
                        else{
                            alert("A data de vencimento não pode ser anterior ou igual ao dia de hoje.");
                        }
                    }
                    else{
                        alert("Por favor, preencha uma data de vencimento.");
                    }
                }
            }
            if(!$('.registros_unicos').is(':checked') && !$('.registros_normais').is(':checked')){
                alert("Por favor, selecione uma arrecadação.");
            }
        });

        $('input:checkbox[name^=registros_normais]').click(function(){
            $('#linha_totais').html('');
            var checkbox = $('input:checkbox[name^=registros_normais]');
            var checkbox_checked = $('input:checkbox[name^=registros_normais]:checked');
            if(checkbox_checked.length > 0){
                var val = [];
                var valor = 0;
                var corrigido = 0;
                var juros = 0;
                var multa = 0;
                var desconto = 0;
                var total = 0;
                checkbox_checked.each(function(){
                    val.push($(this).val());
                    var colunas = $(this).val().split("_");
                    valor += parseFloat(colunas[4]);
                    corrigido+=parseFloat(colunas[5]);
                    juros+=parseFloat(colunas[6]);
                    multa+=parseFloat(colunas[7]);
                    desconto+=parseFloat(colunas[8]);
                    total+=parseFloat(colunas[9]);
                });
                $('#linha_totais').append("<td width='15%'><strong>R$ "+valor.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='valor_total' id='valor_total' value='"+valor.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+corrigido.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='corrigido_total' id='corrigido_total' value='"+corrigido.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+juros.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='juros_total' id='juros_total' value='"+juros.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+multa.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='multa_total' id='multa_total' value='"+multa.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+desconto.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='desconto_total' id='desconto_total' value='"+desconto.toFixed(2)+"'></strong></td><td width='15%'><strong>R$ "+total.toFixed(2).toString().replace(".",",")+"<input type='hidden' name='total_total' id='total_total' value='"+total.toFixed(2)+"'></strong></td>");
//                console.log(val);
            }
            else{
                $('#checkAll').prop('checked', false);
            }
            if(checkbox_checked.length == checkbox.length){
                $('#checkAll').prop('checked', true);
            }
        });

        $('#fechar_informacoes_adicionais').click(function(){
            $('#modal_informacoes_adicionais').modal('hide');
        });
    });
</script>
@endsection