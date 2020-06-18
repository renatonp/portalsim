@extends('layouts.tema01')
@section('content')
<section id="inner-headline">
    <div class="container">
		<div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{$pagina}}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
<section id="content">
    <div class="container">
        <form action="{{ route('salvarCartaoGratuidadeEstacionamento') }}" id="formDocumentos" method="post" enctype="multipart/form-data">
        @csrf
        <!--
        <div class="card">
            <div class="card-body">
                <div class="accordion" id="accordion1">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="accordion1">
                                <i class="icon-plus"></i>
                                INFORMAÇÕES PESSOAIS
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->

        <div class="row">
            <div class="col-md-11"><h4 class="heading">INFORMAÇÕES PESSOAIS</h4></div>
        </div>
        <div class="row">
            <div class="col-md-3 form-label"></div>
            <div class="col-md-7" style="text-align: justify;text-justify: inter-word;">Atendimento da Solicitação:<br /><br />O prazo de atendimento da solicitação é de 72h, sendo que toda comunicação se dará via E-mail, inclusive o resultado (Cartão de Gratuidade).<br />Caso o beneficiário não possua e-mail, deverá comparecer neste local para mais informações.</div>
        </div>
        <br />
        <div class="row">
        	<div class="col-md-3 form-label"><strong>CPF</strong></div>
            <div class="col-md-7"><input type="text" readonly="readonly" class="form-input" value="{{$cpf}}"><input type="hidden" name="cpf" id="cpf" value="{{$cpf}}"></div>
            <div class="col-md-1"><input type="hidden" class="form-input" name="prazo_atendimento"></div>
		</div>
        <div class="row">
        	<div class="col-md-3 form-label"><strong>Nome</strong></div>
            <div class="col-md-7"><input type="text" readonly="readonly" class="form-input" value="{{$nome}}"><input type="hidden" name="nome" value="{{$nome}}"></div>
        </div>
        <div class="row">
            <div class="col-md-3 form-label"><strong>RG</strong></div>
            <div class="col-md-2"><input type="text" readonly="readonly" class="form-input" value="{{$rg}}"><input type="hidden" name="rg" value="{{$rg}}"></div>
            <div class="col-md-3 form-label"><strong>Órgão</strong></div>
            <div class="col-md-2"><input type="text" readonly="readonly" class="form-input" value="{{$orgao}}"><input type="hidden" name="orgao" value="{{$orgao}}"></div>
        </div>
        <div class="row">
            <div class="col-md-3 form-label"><strong>Bairro</strong></div>
            <div class="col-md-2"><input type="text" readonly="readonly" class="form-input" value="{{$bairro}}"><input type="hidden" name="bairro" value="{{$bairro}}"></div>
            <div class="col-md-3 form-label"><strong>Cidade</strong></div>
            <div class="col-md-2"><input type="text" readonly="readonly" class="form-input" value="{{$cidade}}"><input type="hidden" name="cidade" value="{{$cidade}}"></div>
        </div>
        <div class="row">
            <div class="col-md-3 form-label"><strong>Celular</strong></div>
            <div class="col-md-2"><input type="text" readonly="readonly" class="form-input" value="{{$celular}}"><input type="hidden" name="celular" value="{{$celular}}"></div>
            <div class="col-md-3 form-label"><strong>Profissão</strong></div>
            <div class="col-md-2"><input type="text" readonly="readonly" class="form-input" value="{{$profissao}}"><input type="hidden" name="profissao" value="{{$profissao}}"></div>
        </div>
        <div class="row">
            <div class="col-md-3 form-label"><strong>E-mail</strong></div>
            <div class="col-md-7"><input type="text" readonly="readonly" class="form-input" value="{{$email}}"><input type="hidden" name="email" value="{{$email}}"></div>
        </div>
        <div class="row">
            <div class="col-md-3 form-label"><strong>Solicitação</strong></div>
            <div class="col-md-7">
                <select name="solicitacao" class="form-input" id="solicitacao">
                    <option value="">Selecione uma opção</option>
                    <option value="Cartão de Estacionamento para Idoso" @php if(!is_null($solicitacao) && $solicitacao == 'Cartão de Estacionamento para Idoso'){ print('selected');} else{ print(''); } @endphp>Cartão de Estacionamento para Idoso</option>
                    <option value="Cartão de Estacionamento para Deficiente Físico" @php if(!is_null($solicitacao) && $solicitacao == 'Cartão de Estacionamento para Deficiente Físico'){  print('selected');} else{ print(''); } @endphp>Cartão de Estacionamento para Deficiente Físico</option>
                    <option value="Cartão de Estacionamento para Gestante" @php if(!is_null($solicitacao) && $solicitacao == 'Cartão de Estacionamento para Gestante'){ print('selected');} else{ print(''); } @endphp>Cartão de Estacionamento para Gestante</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5"><input type="hidden" class="form-input" name="prazos"></div>
            <div class="col-md-3 form-label"><span class="data_validade" @php if(!is_null($solicitacao) && $solicitacao == 'Cartão de Estacionamento para Gestante'){ print("style='display: block;'");} else{ print("style='display: none;'"); } @endphp><strong>Data de Validade</strong></span></div>
            <div class="col-md-2"><span class="data_validade" @php if(!is_null($solicitacao) && $solicitacao == 'Cartão de Estacionamento para Gestante'){ print("style='display: block;'");} else{ print("style='display: none;'"); } @endphp><input type="date" class="form-input input_data_validade" name="data_validade" @php if(!is_null($data_validade)){ print("value='".$data_validade."'");} else{ print("value=''"); } @endphp ></span><span id="msg"></span></div>
        </div>
        <div class="row">
            <div class="col-md-3 form-label"></div>
            <div class="col-md-7" style="text-align: justify;text-justify: inter-word;">Informação sobre prazos de validade:<br /><br />Gestantes: Período da gestação - Informar no campo acima [ DATA DE VALIDADE]<br />Deficientes Físicos: Benefício por tempo indeterminado devendo ser renovado a cada 2 (dois) anos<br />Idosos: - Benefício por tempo indeterminado devendo ser renovado a cada 2 (dois) anos</div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-3"><h4 class="heading">DOCUMENTAÇÃO</h4></div>
        </div>
        <div class="row">
            <div class="col-md-3 form-label"></div>
            <div class="col-md-7">Documentos Gerais:<br />Documento de Identidade (que conste o CPF) ou CNH<br />Comprovante de Residência atualizado em nome do Beneficiário;<br /><br />Documentos Específicos:<br />Gestantes: Atestado Médico ou cartão pré-natal<br />Deficientes Físicos: Atestado Médico indicando CID<br />Representantes legais: Procuração</div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-11"><h4 class="heading">Anexar Documentos</h4></div>
        </div>
        <div id="documentacao">
            <input type="hidden" class="form-input" name="documentacao_obrigatoria">
            <div class="row">
                <div class="col-md-3 form-label"><strong>Documento do Processo</strong></div>
                <div class="col-md-7">
                    <select name="documento_processo" class="form-input" id="documento_processo">
                        <option value="">Selecione um documento</option>
                        <option value="Carteira de Identidade">Carteira de Identidade</option>
                        <option value="CNH">CNH</option>
                        <option value="Comprovante de Residência (beneficiário)">Comprovante de Residência (beneficiário)</option>
                        <option value="Boletim de Ocorrência">Boletim de Ocorrência</option>
                        <option value="Atestado médico">Atestado médico</option>
                        <option value="Cartão Pré-Natal">Cartão Pré-Natal</option>
                        <option value="Procuração">Procuração</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-label"><span class="linha_outros_documentos"><strong>Outros Documentos</strong></span></div>
                <div class="col-md-7"><span class="linha_outros_documentos"><input type="text" name="outros_documentos" id="outros_documentos" class="form-input" maxlength="50"></span></div>
            </div>
            <div class="row">
                <div class="col-md-3 form-label"><strong>Anexo</strong></div>
                <div class="col-md-7"><input type="file" class="form-input" name="anexo" id="anexo" class="form-input"></div>
                <div class="col-md-2" align="center"><input type="button" class="btn btn-small btn-blue e_wiggle align-left" value="adicionar anexo" id="lancarArquivo"></div>
            </div>
            <br />
            <input type="hidden" name="cpf_requerente" value="{{$cpf}}">
            <input type="hidden" name="requerente_beneficiario" value="1">
            <input type="hidden" name="nome_requerente" value="{{$nome}}">
            <input type="hidden" name="telefone_requerente" value="{{$telefone}}">
            <input type="hidden" name="email_requerente" value="{{$email}}">
            </form>
        </div>
        <div class="row">
            <div class="col-md-11"><h4 class="heading">Documentos Lançados</h4></div>
        </div>
        @if(isset($solicitacao))
            {{ $solicitacao }}
        @endif
        <div class="col-lg-12">
            <input type="hidden" id="qtd_registros" value="{{ $qtd_registros }}">
            <table id="documentosLancados" width="100%">
                <thead>
                    <tr>
                        <th width="30%"><strong>Anexo</strong></th>
                        <th width="30%"><strong>Documento do Processo</strong></th>
                        <th width="30%"><strong>Outros Documentos</strong></th>
                        <th width="10%"><strong>Ações</strong></th>
                    </tr>
                </thead>
                <tbody id="body_table">
                    @foreach($registros as $registro)
                        <form action="{{ route('removerCartaoGratuidadeDocumento') }}" method="post" id="form{{ $registro->id }}">
                            @csrf
                        <tr id="linha{{ $registro->id }}">
                            <td>{{ $registro->anexo }}</td><td>{{ $registro->documento_processo }}</td><td>{{ $registro->outros_documentos }}</td><td><input type="button" class="btn btn-danger" value="REMOVER" onclick="removerRegistro({{ $registro->id }})"><input type="hidden" name="id" value="{{ $registro->id }}"><input type="hidden" name="file" id="file{{ $registro->id }}" value="{{ $registro->anexo }}"><input type="hidden" id="documento_processo{{ $registro->id }}" value="{{ $registro->documento_processo }}"><input type="hidden" id="uid{{ $registro->id }}" value="{{ $registro->uniqid }}"></td>
                        </tr>
                        </form>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br />
        <div class="row">
            <div class="col-md-6" align="left"><input type="button" class="btn btn-theme e_wiggle" value="voltar" id="voltar"></div>
            <div class="col-md-6" align="right"><input type="button" class="btn btn-warning e_wiggle btn-100" value="enviar solicitação" id="enviarSolicitacao"></div>
        </div>
    </form>
	</div>
</section>
<style type="text/css">
    a:hover {
        text-decoration: none;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    function mostraData(){
        $('#msg').html("<strong><font color='#FF0000'>A Data de Validade não pode ser anterior a data atual.</font></strong>");
        $('#msg').fadeIn("slow");
    }
    function someData(){
        $('#msg').fadeOut("slow");
    }

    function removerRegistro(id){
        $.post("{{ route('removerCartaoGratuidadeDocumento') }}",{'_token': '{{ csrf_token() }}', 'id': id, 'file': $('#file'+id).val(),'cpf': $('#cpf').val(),'documento_processo': $('#documento_processo'+id).val(),'uid': $('#uid'+id).val() },function(data){
            $('#linha'+id).html('');
        })
    }

    $(document).ready(function(){
        $('#msg').css("display", "none");

        $('#solicitacao').change(function(){
            if($('#solicitacao').val() == "Cartão de Estacionamento para Gestante"){
                $('.data_validade').css("display", "block");
            }
            else{
                $('.data_validade').css("display", "none");
            }
        });

        $('.linha_outros_documentos').css("display", "none");
        $('#documento_processo').change(function(){
            if($('#documento_processo').val() == "Outros"){
                $('.linha_outros_documentos').css("display", "block");
            }
            else{
                $('.linha_outros_documentos').css("display", "none");
            }
        });

        $('.input_data_validade').blur(function(){
            if($('.input_data_validade').val() == ""){
                alert('A Data de Validade deve ser preenchida.');
            }
            var str_data_validade = $('.input_data_validade').val();
            var vet_data_validade = str_data_validade.split('-');
            var vet_data_validade_timestamp = vet_data_validade[0]+vet_data_validade[1]+vet_data_validade[2];

            var data_atual = new Date();
            var dia = data_atual.getDate();
            var mes = (data_atual.getMonth()+1);
            if(dia < 10){
                dia = '0'+dia;
            }

            if(mes < 10){
                mes = '0'+mes;
            }

            var data_atual_timestamp = data_atual.getFullYear()+''+mes+''+dia;

            if(vet_data_validade_timestamp <= data_atual_timestamp){
                alert('A Data de Validade não pode ser anterior a data atual.');
            }
        });

        var infoArqEnviada = false;

        $("#lancarArquivo").click(function () {
            if($('#documento_processo').val() != ''){
                if(!infoArqEnviada){
                    infoArqEnviada = true;
                    $("#lancarArquivo").prop('disabled', true);
                     
                    
                    if ($("#anexo").val() == "") {
                        alert("Por favor escolha um documento para enviar");
                        infoArqEnviada = false;
                        $("#lancarArquivo").prop('disabled', false);            
                        return false;
                    }

                    var $input, file, $arquivo, $tamanho, $ext;
                        
                    $input = document.getElementById('anexo');


                    if (!window.FileReader) {
                        infoArqEnviada = false;
                        $("#lancarArquivo").prop('disabled', false);
                        return false;
                    }
                
                    $input = document.getElementById('anexo');
                    file = $input.files[0];
                    var filename = file.name;
                    var vet_filename = filename.split('.');
                    var qtd_pontos = vet_filename.length;
                    var newfilename = "";
                    if(qtd_pontos > 2){
                        var i=0;
                        while(i < qtd_pontos){
                            if(i < (qtd_pontos-1)){
                                newfilename += vet_filename[i]+'';
                            }
                            if(i == (qtd_pontos-1)){
                                newfilename += '.'+vet_filename[i];
                            }
                            i++;
                        }
                    }
                    else{
                        var newfilename = file.name;
                    }

                    // $nome_arquivo.innerHTML = file.name;
                    // $tamanho.innerHTML = file.size + " bytes";
                    $ext = /\..*$/g.exec(newfilename);
                    
                    if (file.size > 2048000) {
                        alert("O arquivo deve ter no máximo 2Mb");
                        infoArqEnviada = false;
                        $("#lancarArquivo").prop('disabled', false);
                        return false;
                    }

                    if ($ext != '.JPEG' && $ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf' && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF' ) {
                        alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
                        infoArqEnviada = false;
                        $("#lancarArquivo").prop('disabled', false);
                        return false;
                    }

                    $("#mdlAguarde").modal('toggle');
                    $("#formDocumentos").attr("action","{{ route('imageUploadPost') }}")
                    $("#formDocumentos").submit();
                }
                else{
                    console.log("Segundo envio");
                }
            }
            else{
                alert('Um tipo de documento deve ser selecionado no campo \"Documento do Processo\".')
            }
        });

        $('#enviarSolicitacao').click(function(){
            if($('#solicitacao').val() == ''){
                alert('O campo \"Solicitação\" deve ser preenchido.');
            }
            else{
                if($('#solicitacao').val() == 'Cartão de Estacionamento para Gestante'){
                    if($('.input_data_validade').val() == ""){
                        alert('A Data de Validade deve ser preenchida.');
                    }
                    else{
                        var str_data_validade = $('.input_data_validade').val();
                        var vet_data_validade = str_data_validade.split('-');
                        var vet_data_validade_timestamp = vet_data_validade[0]+vet_data_validade[1]+vet_data_validade[2];

                        var data_atual = new Date();
                        var dia = data_atual.getDate();
                        var mes = (data_atual.getMonth()+1);
                        if(dia < 10){
                            dia = '0'+dia;
                        }

                        if(mes < 10){
                            mes = '0'+mes;
                        }

                        var data_atual_timestamp = data_atual.getFullYear()+''+mes+''+dia;

                        if(vet_data_validade_timestamp < data_atual_timestamp){
                            alert('A Data de Validade não pode ser anterior a data atual.');
                        }
                        else{
                            if($('#qtd_registros').val() == 0){
                                alert('Favor anexar a documentação para prosseguir');
                            }
                            else{
                                $("#mdlAguarde").modal('toggle');
                                $("#formDocumentos").attr("action","{{ route('salvarCartaoGratuidadeEstacionamento') }}")
                                $("#formDocumentos").submit();
                            }
                        }
                    }
                }
                else{
                    if($('#qtd_registros').val() == 0){
                        alert('Favor anexar a documentação para prosseguir');
                    }
                    else{
                        $("#mdlAguarde").modal('toggle');
                        $("#formDocumentos").attr("action","{{ route('salvarCartaoGratuidadeEstacionamento') }}")
                        $("#formDocumentos").submit();
                    }
                }
            }
        })

        $('#voltar').click(function(){
            window.location.replace("servicos/1");
        })
        
        var table = $('#documentosLancados').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false,
        });
    });
</script>
@endsection