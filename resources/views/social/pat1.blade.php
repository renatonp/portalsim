@extends('layouts.tema01')

@section('content')

<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('PROGRAMA DE AMPARO AO TRABALHADOR ') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('PROGRAMA DE AMPARO AO TRABALHADOR ') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-12">
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
                
                <form method="POST" action="{{ route('pat_informacoes') }}" id="pat_informacoes">
                    @csrf
                    <input id="recurso" type="hidden" name="recurso" value="{{$recurso}}">
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion" id="accordion3">
                                {{-- 
                                ***********************************
                                *** Informações Pessoais 
                                ***********************************
                                --}}
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                            href="#collapse1">
                                            <i class="icon-minus"></i>
                                            Informações Pessoais
                                        </a>
                                    </div>
                                    <div id="collapse1" class="accordion-body collapse in">
                                        @include('social.informacoes_pessoais')
                                        {{-- @include('social.emconstrucao') --}}
                                    </div>
                                </div>

                                {{-- 
                                ***********************************
                                *** Endereço
                                ***********************************
                                --}}
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                            href="#collapse2">
                                            <i class="icon-plus"></i> Endereço
                                        </a>
                                    </div>
                                    <div id="collapse2" class="accordion-body collapse">
                                        @include('social.endereco')
                                        {{-- @include('social.emconstrucao') --}}
                                    </div>
                                </div>


                                {{-- 
                                ***********************************
                                *** Informações de Contato
                                ***********************************
                                --}}
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                            href="#collapse3">
                                            <i class="icon-plus"></i> Informações de Contato
                                        </a>
                                    </div>
                                    <div id="collapse3" class="accordion-body collapse">
                                        @include('social.informacoes_contato')
                                        {{-- @include('social.emconstrucao') --}}
                                    </div>
                                </div>

                                {{-- 
                                ***********************************
                                *** Depensentes
                                ***********************************
                                --}}
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse7">
                                            <i class="icon-plus"></i> Dependentes (Moradores do mesmo núcleo familiar)
                                        </a>
                                    </div>
                                    <div id="collapse7" class="accordion-body collapse">
                                        @include('social.dependentes')
                                        {{-- @include('social.emconstrucao') --}}
                                    </div>
                                </div>


                                {{-- 
                                ***********************************
                                *** Informações Adicionais
                                ***********************************
                                --}}
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse4">
                                            <i class="icon-plus"></i> Informações Profissionais e de Renda
                                        </a>
                                    </div>
                                    <div id="collapse4" class="accordion-body collapse">
                                        @include('social.informacoes_adicionais')
                                        {{-- @include('social.emconstrucao') --}}
                                    </div>
                                </div>

                                {{-- 
                                ***********************************
                                *** Documentos em Anexo
                                ***********************************
                                --}}
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse5">
                                            <i class="icon-plus"></i> Documentos em Anexo
                                        </a>
                                    </div>
                                    <div id="collapse5" class="accordion-body collapse">
                                        @include('social.documentos')
                                        {{-- @include('social.emconstrucao') --}}
                                    </div>
                                </div>
                                    
                                {{-- 
                                ***********************************
                                *** Auto declaração
                                ***********************************
                                --}}
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse8">
                                            <i class="icon-plus"></i> Declaração
                                        </a>
                                    </div>
                                    <div id="collapse8" class="accordion-body collapse">
                                        @include('social.declaracao')
                                        {{-- @include('social.emconstrucao') --}}
                                    </div>
                                </div>
                            </div>
                                <div class="span12 align-left">
                                    <a href="{{ $recurso==1? route('consultarsituacao') :  route('PAT_CADASTRO')  }}">
                                        <button type="button" class="btn btn-theme e_wiggle">
                                            {{ __('Voltar') }}
                                        </button>
                                    <a>
                                
                                    <button type="button" class="btn btn-warning e_wiggle align-right" id="solicitarAuxilio">
                                        {{ __('Solicitar Auxílio') }}
                                    </button>
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

    var $arq01 = false;
    var $arq02 = false;
    var $arq03 = false;
    var $arq04 = false;
    var $arq05 = false;
    var $arq06 = false;
    var $arq07 = false;
    var $arq08 = false;

    var $IncluirDependente = false;

    jQuery(document).ready(function(){
        $("#pat_cpf").mask("000.000.000-00");
        $("#dtnasc").mask("00/00/0000");
        $("#cep").mask("00.000-000");
        $("#celular").mask("(00)00000-0000");
        $("#telefone").mask("(00)0000-0000");
        $("#telefone").mask("(00)0000-0000");
        $("#depCpf").mask("000.000.000-00");
        $("#depDtNasc").mask("00/00/0000");

        $("#cnpj").mask("00.000.000/0000-00");
        $("#renda").mask("###.###.###.##0,00", {reverse: true});
        $("#numero").mask("##########");
    });
    
    $("#exigeMEI").hide();

    var pesquisaCid10Tbl = $('#pesquisaCid10Tbl').DataTable({
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

    $("#irSim").click(function(){
        $("#exigeIR").show();
    });
    $("#irNao").click(function(){
        $("#exigeIR").hide();
    });

    $("#doencaSim").click(function(){
        $("#rowDeclaracaoDocenca1").show();
        $("#rowDeclaracaoDocenca2").show();
        $("#rowCid").show();
        $("#exigeCid").show();
    });

    $("#doencaNao").click(function(){
        $("#rowDeclaracaoDocenca1").hide();
        $("#rowDeclaracaoDocenca2").hide();
        $("#rowCid").hide();
        $("#exigeCid").hide();
        $("#doencaDescricao").val("");
    });

    $("#incluirDependente").click(function(){
        console.log("Dependente: " + $IncluirDependente);
        if (!$IncluirDependente){
            $IncluirDependente = true;

            if($("#depNome").val()==""){
                alert("Informe o Nome do dependente")
                $("#collapse7").collapse('show');
                $("#depNome").focus();
                console.log("Teste: 1");
                $IncluirDependente = false;
                return false;
            }

            dependentes.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                this.data().forEach(function(column, $posicao) {
                    if ($posicao == 3){
                        console.log('row ' + rowIdx + ' column ' + $posicao + ' value ' + column);
                        if(column == $("#depNome").val()){
                            alert("Esse dependente já está cadastrado")
                            $("#collapse7").collapse('show');
                            $("#depNome").focus();
                            $achou =true;
                            console.log("Teste: 2");
                            $IncluirDependente = false;
                            return false;
                        }
                    }
                });
            });

            if($achou ){
                console.log("Teste: 3");
                $IncluirDependente = false;
                return false;
            }

            if($("#depDtNasc").val()==""){
                alert("Informe a Data de Nascimento do dependente")
                $("#collapse7").collapse('show');
                $("#depDtNasc").focus();
                console.log("Teste: 4");
                $IncluirDependente = false;
                return false;
            }

            if(!validadataNascimento3($("#depDtNasc").val())){
                alert("Data de Nascimento Inválida")
                $("#collapse7").collapse('show');
                $("#depDtNasc").focus();
                console.log("Teste: 5");
                $IncluirDependente = false;
                return false;
            }

            if($("#parentesco").val()==""){
                alert("Informe o Grau de Parentesco do dependente")
                $("#collapse7").collapse('show');
                $("#parentesco").focus();
                console.log("Teste: 6");
                $IncluirDependente = false;
                return false;
            }

            var menor = true

            if(validadataNascimento($("#depDtNasc").val())){
                menor = false;
                // Maior de 16 anos
                if($("#depCpf").val() == ""){
                    alert("É obrigatório informar o CPF dos dependentes maiores de 16 anos")
                    $("#collapse7").collapse('show');
                    $("#depCpf").focus();
                    console.log("Teste: 7");
                    $IncluirDependente = false;
                    return false;
                }
            }

            if( $("#depCpf").val() == $("#pat_cpf").val() ){
                alert("Este CPF já está sendo utilizado pelo Solicitante");
                $("#collapse7").collapse('show');
                $("#cpf").focus();
                console.log("Teste: 8");
                $IncluirDependente = false;
                return false;
            }



            var $achou = false;
            if($("#depCpf").val() != "" ){
                dependentes.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    this.data().forEach(function(column, $posicao) {
                        if ($posicao == 0){
                            console.log('row ' + rowIdx + ' column ' + $posicao + ' value ' + column);
                            if(column == $("#depCpf").val()){
                                alert("O CPF Já está cadastro em outro dependente")
                                $("#collapse7").collapse('show');
                                $("#depCpf").focus();
                                $achou =true;
                                console.log("Teste: 9");
                                $IncluirDependente = false;
                                return false;
                            }
                        }
                        if ($posicao == 3){
                            console.log('row ' + rowIdx + ' column ' + $posicao + ' value ' + column);
                            if(column == $("#depNome").val()){
                                alert("Esse dependente já está cadastrado")
                                $("#collapse7").collapse('show');
                                $("#depNome").focus();
                                $achou =true;
                                console.log("Teste: 10");
                                $IncluirDependente = false;
                                return false;
                            }
                        }
                    });
                });
            }
            console.log("Passou");

            if(!$achou ){
                if($("#depCpf").val() != "" ){

                    $("#mdlAguarde").modal('toggle');

                    var url = 'validaCpfDep/' + $("#depCpf").val();
                        
                    $.get( url,  function(resposta){
                        console.log(resposta);
                        if(resposta != 0){
                            if(resposta == 1){
                                alert( "CPF Inválido")
                                $("#collapse7").collapse('show');
                                $("#depCpf").focus();
                                console.log("Teste: 11");
                                $IncluirDependente = false;
                                $("#mdlAguarde").modal('toggle');
                                return false;
                            }
                            if(resposta == 2){
                                alert( "CPF já cadastrado em outra solicitação")
                                $("#collapse7").collapse('show');
                                $("#depCpf").focus();
                                console.log("Teste: 12");
                                $IncluirDependente = false;
                                $("#mdlAguarde").modal('toggle');
                                return false;
                            }
                            if(resposta == 3){
                                alert( "CPF já foi cadastrado como dependente em outra solicitação")
                                $("#collapse7").collapse('show');
                                $("#depCpf").focus();
                                console.log("Teste: 13");
                                $IncluirDependente = false;
                                $("#mdlAguarde").modal('toggle');
                                return false;
                            }
                        }
                        else{
                            dependentes.row.add([
                                $("#depCpf").val(),
                                $("#depDtNasc").val(),
                                $("#parentesco").val(),
                                $("#depNome").val(),
                                '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                            ]).draw(false);
                            dependentes.columns.adjust().draw();
                            $("#depCpf").val("");
                            $("#depNome").val("");
                            $("#depDtNasc").val("");
                            $("#parentesco").val("");
                            $("#depNome").focus();
                            console.log("Teste: 14");
                            $IncluirDependente = false;
                            $("#mdlAguarde").modal('toggle');
                        }
                    });
                }
                else if(menor){
                    dependentes.row.add([
                        $("#depCpf").val(),
                        $("#depDtNasc").val(),
                        $("#parentesco").val(),
                        $("#depNome").val(),
                        '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                    ]).draw(false);
                    dependentes.columns.adjust().draw();
                    $("#depCpf").val("");
                    $("#depNome").val("");
                    $("#depDtNasc").val("");
                    $("#parentesco").val("");
                    $("#depNome").focus();
                    console.log("Teste: 15");
                    $IncluirDependente = false;
                }
            }

            
        }
        else{
            console.log("Segundo Click");
        }

  
    });

    $("#profLiberal").change(function() {
        $("#entidadeClasse").val("");
        $("#identidadeFuncional").val("");
        
        if( $("#profLiberal").val() == "Profissional Liberal" ){
            $("#rowEntidade").show();
            $("#rowIDFuncional").show();
            $("#exigeIdentidade").show();
            $("#exigeIdentidade").show();
            $("#exigeMEI").hide();

        }
        else{
            $("#rowEntidade").hide();
            $("#rowIDFuncional").hide();
            $("#exigeMEI").hide();
        }
        if( $("#profLiberal").val() == "Trabalhador Informal" ){
            $("#rowCNPJ").hide();
        }
        else{
            $("#rowCNPJ").show();
        }

        if( $("#profLiberal").val() == "MEI" ){
            $("#rowCNPJ").show();
            $("#exigeMEI").show();
        }
        else{
            $("#rowCNPJ").show();
            $("#exigeMEI").hide();
        }
    });

    $("#cnpj").focusout(function() {
        if( $("#cnpj").val() != "" ){
            if(!validarCNPJ($("#cnpj").val())){
                alert("CNPJ inválido!  Por favor informe um cnpj correto");
                $("#cnpj").val("");
                $("#collapse4").collapse('show');
                $("#cnpj").focus();
                return false;  
            }
        }
    });

    $('#dependentes').on("click", "button", function () {
        dependentes.row($(this).parents('tr')).remove().draw(false);
    });

    // 

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
                var url = '../register/consultaCEP/' + cep;
                
                $.get( url,  function(resposta){
                    var obj = jQuery.parseJSON(resposta);
                    if(obj.logradouro){
                        if (obj.localidade.toUpperCase() == "MARICÁ" || obj.localidade.toUpperCase() == "MARICA"){
                            $("#numero").focus();
    
                            $("#logradouro").val(obj.logradouro);
                            $("#bairro").val(obj.bairro);
                            $("#cidade").val(obj.localidade);
                            $("#uf").val(obj.uf);
                            
                            $("#logradouro").prop('readonly', false);
                            $("#bairro").prop('readonly', true);
                            $("#cidade").prop('readonly', true);
                            $("#uf").prop('disabled', true);
                        }
                        else{
                            $("#logradouro").val("");
                            $("#bairro").val("");
                            $("#cidade").val("");
                            $("#uf").val("");

                            alert("Só é possível cadastrar CEP de Maricá!");
                        }
                    }
                    else if(obj.erro){
                        alert("CEP não encontrado ou inválido!");
                    }
                })
                .fail(function() {
                    alert("CEP não encontrado ou inválido!");
                })
                .always(function() {
                    $("#buscaCep").modal('toggle');
                });
               
            }					
        }
    });	
    
    var dependentes = $('#dependentes').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "scrollY": 150,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
    });
    
    var patDocumentos = $('#patDocumentos').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "scrollY": 150,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
    });

    $("#solicitarAuxilio").click(function () {

        if( $("#nome").val() == "" ){
            alert("Informe o seu Nome");
            $("#collapse1").collapse('show');
            $("#nome").focus();
            return false;
        }

        if( $("#nome").val().length < 5 ){
            alert("O Nome deve ter mais de 5 caracteres");
            $("#collapse1").collapse('show');
            $("#nome").focus();
            return false;
        }

        if( $("#dtnasc").val() == "" ){
            alert("Informe a sua Data de Nascimento");
            $("#collapse1").collapse('show');
            $("#dtnasc").focus();
            return false;
        }

        if( !validadataNascimento2( $("#dtnasc").val() ) ){
            alert("Idade Inválida para a solicitação do benefício");
            $("#collapse1").collapse('show');
            $("#dtnasc").focus();
            return false;
        }

        if( !validadataNascimento3( $("#dtnasc").val() ) ){
            alert("Data de Nascimento inválida");
            $("#collapse1").collapse('show');
            $("#dtnasc").focus();
            return false;
        }


        if( $("#sex").val() == "" ){
            alert("Informe o seu Sexo Biológico");
            $("#collapse1").collapse('show');
            $("#sex").focus();
            return false;
        }

        if( $("#eCivil").val() == "" ){
            alert("Informe o seu Estado Civil");
            $("#collapse1").collapse('show');
            $("#eCivil").focus();
            return false;
        }        

        if( !$("#doencaSim").is(':checked') && !$("#doencaNao").is(':checked') ){
            alert("Informe se possui algum tipo de Doença");
            $("#collapse1").collapse('show');
            $("#doencaSim").focus();
            return false;
        }
        if( $("#doencaSim").is(':checked') && $("#doencaDescricao").val() =="" ){
            alert("Informe o CID da Doença");
            $("#collapse1").collapse('show');
            $("#doencaDescricao").focus();
            return false;
        }

        if( $("#cep").val() == "" ){
            alert("Informe o CEP");
            $("#collapse2").collapse('show');
            $("#cep").focus();
            return false;
        }

        if( $("#uf").val() == "" ){
            alert("Informe o Estado");
            $("#collapse2").collapse('show');
            $("#uf").focus();
            return false;
        }

        if( $("#cidade").val() == "" ){
            alert("Informe o Município");
            $("#collapse2").collapse('show');
            $("#cidade").focus();
            return false;
        }

        if( $("#bairro").val() == "" ){
            alert("Informe o Bairro");
            $("#collapse2").collapse('show');
            $("#bairro").focus();
            return false;
        }

        if( $("#logradouro").val() == "" ){
            alert("Informe o Logradouro");
            $("#collapse2").collapse('show');
            $("#logradouro").focus();
            return false;
        }

        if( $("#numero").val() == "" ){
            alert("Informe o Número");
            $("#collapse2").collapse('show');
            $("#numero").focus();
            return false;
        }

        if( $("#email").val() == "" ){
            alert("Informe seu E-Mail");
            $("#collapse3").collapse('show');
            $("#email").focus();
            return false;
        }

        if( !checkMail($("#email").val())){
            alert("E-Mail inválido!");
            $("#collapse3").collapse('show');
            $("#email").focus();
            return false;
        }

        if( $("#email-confirm").val() == "" ){
            alert("Confirme o seu E-Mail");
            $("#collapse3").collapse('show');
            $("#email-confirm").focus();
            return false;
        }

        if( !checkMail($("#email-confirm").val())){
            alert("E-Mail inválido!");
            $("#collapse3").collapse('show');
            $("#email-confirm").focus();
            return false;
        }

       

        if( $("#email-confirm").val() !=  $("#email").val() ){
            alert("O E-mail e a Confirmação do E-mail devem ser iguais");
            $("#collapse3").collapse('show');
            $("#email-confirm").focus();
            return false;
        }

        if( $("#celular").val() == "" ){
            alert("Informe o número do seu telefone Celular");
            $("#collapse3").collapse('show');
            $("#celular").focus();
            return false;
        }


        if( $("#renda").val() == "" ){
            alert("Informe a sua Renda");
            $("#collapse4").collapse('show');
            $("#renda").focus();
            return false;
        }

        $renda = $("#renda").val().replace(/\./g, '')
        $renda = $renda.replace(/\,/g, '.')
        if( Number($renda) == 0 ){
            alert("A sua renda deve ser maior que R$ 0,00");
            $("#collapse4").collapse('show');
            $("#renda").focus();
            return false;
        }

        if( Number($renda) > 5225 ){
            alert("A renda deve ser inferior a 5 Salário Mínimos");
            $("#collapse4").collapse('show');
            $("#renda").focus();
            return false;
        }

        if( !$("#irSim").is(':checked') && !$("#irNao").is(':checked') ){
            alert("Informe se declara Imposto de Renda");
            $("#collapse4").collapse('show');
            $("#irSim").focus();
            return false;
        }

        if( $("#ocupacao").val() == "" ){
            alert("Informe a sua Ocupação");
            $("#collapse4").collapse('show');
            $("#ocupacao").focus();
            return false;
        }

        if( $("#profLiberal").val() == "MEI" ){
            if( $("#cnpj").val() == "" ){
                alert("Informe o CNPJ");
                $("#collapse4").collapse('show');
                $("#cnpj").focus();
                return false;  
            }
        }

        if( $("#profLiberal").val() == "Profissional Liberal" ){
            if( $("#entidadeClasse").val() == "" ){
                alert("Informe o nome da Entidade de Classe");
                $("#collapse4").collapse('show');
                $("#entidadeClasse").focus();
                return false;
            }
            if( $("#identidadeFuncional").val() == "" ){
                alert("Informe a sua Identidade Funcional");
                $("#collapse4").collapse('show');
                $("#identidadeFuncional").focus();
                return false;
            }
        }

        if( $("#cnpj").val() != "" ){
            if(!validarCNPJ($("#cnpj").val())){
                alert("CNPJ inválido!  Por favor informe um cnpj correto");
                $("#collapse4").collapse('show');
                $("#cnpj").focus();
                return false;  
            }
        }
        
        if($("#agPreferencia").val() == ""){
            alert("Informe a sua agência de preferência do banco Mumbuca");
            $("#collapse4").collapse('show');
            $("#agPreferencia").focus();
            return false;  
        }



        if(!$arq01){
            alert("É necessário incluir o seu CPF em formato digital");
            $("#collapse5").collapse('show');
            $("#arquivoCpf").focus();
            return false;
        }
        if(!$arq02){
            alert("É necessário incluir a sua IDENTIDADE em formato digital");
            $("#collapse5").collapse('show');
            $("#arquivoId").focus();
            return false;
        }
        if(!$arq03){
            alert("É necessário incluir o COMPROVANTE DE RESIDÊNCIA DE JANEIRO/2020 em formato digital");
            $("#collapse5").collapse('show');
            $("#arquivoCr1").focus();
            return false;
        }
        if(!$arq04){
            alert("É necessário incluir o COMPROVANTE DE RESIDÊNCIA DE FEVEREIRO/2020 em formato digital");
            $("#collapse5").collapse('show');
            $("#arquivoCr2").focus();
            return false;
        }
        if(!$arq05){
            alert("É necessário incluir o COMPROVANTE DE RESIDÊNCIA DE MARÇO/2020 em formato digital");
            $("#collapse5").collapse('show');
            $("#arquivoCr3").focus();
            return false;
        }
        if(!$arq06){
            alert("É necessário incluir o COMPROVANTE DE ATIVIDADES DE TRABALHO em formato digital");
            $("#collapse5").collapse('show');
            $("#arquivoCAT").focus();
            return false;
        }
                
        if($("#irSim").is(':checked')){
            if(!$arq07){
                alert("É necessário incluir o seu COMPROVANTE DE RENDA em formato digital");
                $("#collapse5").collapse('show');
                $("#arquivoCR").focus();
                return false;
            }
        }
        // if(!$arq08){
        //     alert("É necessário incluir a AUTO DECLARAÇÃO");
        //     $("#collapse5").collapse('show');
        //     $("#arquivoAD").focus();
        //     return false;
        // }

        if(!$("#declaracao1").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao1").focus();
            return false;       
        }

        if(!$("#declaracao2").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao2").focus();
            return false;       
        }

                
        if(!$("#declaracao9").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao9").focus();
            return false;       
        }

        if(!$("#declaracao3").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao3").focus();
            return false;       
        }

        if(!$("#declaracao4").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao4").focus();
            return false;       
        }

        if(!$("#declaracao5").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao5").focus();
            return false;       
        }

        if(!$("#declaracao6").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao6").focus();
            return false;       
        }


        if($("#doencaSim").is(':checked')){
            if(!$("#declaracao7").is(':checked')){
                alert("É necessário concordar com os termos do programa");
                $("#collapse8").collapse('show');
                $("#declaracao7").focus();
                return false;       
            }
        }

        if(!$("#declaracao8").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao8").focus();
            return false;       
        }
        
        if(!$("#declaracao10").is(':checked')){
            alert("É necessário concordar com os termos do programa");
            $("#collapse8").collapse('show');
            $("#declaracao10").focus();
            return false;       
        }
        


        $("#mdlAguarde").modal('toggle');

        var $dep = "";
        dependentes.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            if($dep.length > 0 ){
                $dep += "|"
            }
            $dep += JSON.stringify(this.data());
        });

        var $arq = "";
        patDocumentos.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            if($arq.length > 0 ){
                $arq += "|"
            }
            $arq += JSON.stringify(this.data());
        });

        $("#dependentesLista").val($dep);
        $("#arquivosLista").val($arq);

        $("#uf").prop('disabled', false);

        $("#pat_informacoes").submit();
    });

    $("#lancarArquivoCpf").click(function () {
        if ($("#arquivoCpf").val() == "") {
            alert("Por favor escolha um documento para enviar");
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


        if (file.size > 5120000) {
            alert("O arquivo deve ter no máximo 5Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='pat_doc_cpf']")[0]);
        var $descricao = dados.get("DescrDoc");

        $.ajax({
            type: 'POST',
            url: "{{ url('/pat_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                patDocumentos.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                patDocumentos.columns.adjust().draw();
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

    $("#lancarArquivoCr1").click(function () {
        if ($("#arquivoCr1").val() == "") {
            alert("Por favor escolha um documento para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCr1');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);

        
        $ext = file.name.split('.');

        $ext = "." +  $ext[$ext.length-1];

        if (file.size > 5120000) {
            alert("O arquivo deve ter no máximo 5Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='pat_doc_cr1']")[0]);
        var $descricao = dados.get("DescrDoc");

        $.ajax({
            type: 'POST',
            url: "{{ url('/pat_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                patDocumentos.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                patDocumentos.columns.adjust().draw();
                $("#arquivoCr1").val("");
                $arq03 = true;
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

    $("#lancarArquivoCr2").click(function () {
        if ($("#arquivoCr2").val() == "") {
            alert("Por favor escolha um documento para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCr2');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext ="." +  $ext[$ext.length-1];

        if (file.size > 5120000) {
            alert("O arquivo deve ter no máximo 5Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='pat_doc_cr2']")[0]);
        var $descricao = dados.get("DescrDoc");

        $.ajax({
            type: 'POST',
            url: "{{ url('/pat_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                patDocumentos.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                patDocumentos.columns.adjust().draw();
                $("#arquivoCr2").val("");
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

    $("#lancarArquivoCr3").click(function () {
        if ($("#arquivoCr3").val() == "") {
            alert("Por favor escolha um documento para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCr3');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);

        $ext = file.name.split('.');

        $ext ="." +  $ext[$ext.length-1];

        if (file.size > 5120000) {
            alert("O arquivo deve ter no máximo 5Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='pat_doc_cr3']")[0]);
        var $descricao = dados.get("DescrDoc");
        
        $.ajax({
            type: 'POST',
            url: "{{ url('/pat_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                patDocumentos.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                patDocumentos.columns.adjust().draw();
                $("#arquivoCr3").val("");
                $arq05 = true;
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

    $("#lancarArquivoCat").click(function () {
        if ($("#arquivoCAT").val() == "") {
            alert("Por favor escolha um documento para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCAT');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);

        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];

        if (file.size > 5120000) {
            alert("O arquivo deve ter no máximo 5Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='pat_doc_cat']")[0]);
        var $descricao = dados.get("DescrDoc");

        $.ajax({
            type: 'POST',
            url: "{{ url('/pat_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                patDocumentos.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                patDocumentos.columns.adjust().draw();
                $("#arquivoCAT").val("");
                $arq06 = true;
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

    $("#lancarArquivoId").click(function () {
        if ($("#arquivoId").val() == "") {
            alert("Por favor escolha um documento para enviar");
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

        if (file.size > 5120000) {
            alert("O arquivo deve ter no máximo 5Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='pat_doc_id']")[0]);
        var $descricao = dados.get("DescrDoc");

        $.ajax({
            type: 'POST',
            url: "{{ url('/pat_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                patDocumentos.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                patDocumentos.columns.adjust().draw();
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

    $("#lancarArquivoCr").click(function () {
        if ($("#arquivoCR").val() == "") {
            alert("Por favor escolha um documento para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoCR');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);
        
        $ext = file.name.split('.');

        $ext = "." + $ext[$ext.length-1];

        if (file.size > 5120000) {
            alert("O arquivo deve ter no máximo 5Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='pat_doc_cr']")[0]);
        var $descricao = dados.get("DescrDoc");
        
        $.ajax({
            type: 'POST',
            url: "{{ url('/pat_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                patDocumentos.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                patDocumentos.columns.adjust().draw();
                $("#arquivoCR").val("");
                $arq07 = true;
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

    $("#lancarArquivoAd").click(function () {
        if ($("#arquivoAD").val() == "") {
            alert("Por favor escolha um documento para enviar");
            return false;
        }

        var $input, file, $arquivo, $tamanho, $ext;
        
        if (!window.FileReader) {
            return false;
        }
        
        $input = document.getElementById('arquivoAD');
        file = $input.files[0];
        // $ext = /\..*$/g.exec(file.name);

        $ext = file.name.split('.');

        $ext ="." +  $ext[$ext.length-1];

        if (file.size > 5120000) {
            alert("O arquivo deve ter no máximo 5Mb");
            return false;
        }

        if ($ext != '.jpeg' && $ext != '.jpg' && $ext != '.gif' && $ext != '.png' && $ext != '.pdf'  && $ext != '.JPEG' && $ext != '.JPG' && $ext != '.GIF' && $ext != '.PNG' && $ext != '.PDF') {
            alert("O arquivo deve ser do tipo 'jpeg', 'jpg', 'png', 'gif' ou 'pdf'");
            return false;
        }

        $("#mdlAguarde").modal('toggle');
        var dados = new FormData($("form[name='pat_doc_ad']")[0]);
        var $descricao = dados.get("DescrDoc");
        
        $.ajax({
            type: 'POST',
            url: "{{ url('/pat_documentos') }}",
            data: dados,
            processData: false,
            contentType: false

        }).done(function (resposta) {
            $("#mdlAguarde").modal('toggle');

            if (resposta.statusArquivoTransacao == 1) {
                patDocumentos.row.add([
                    $descricao,
                    resposta.nome_original,
                    resposta.nome_novo,
                    '<button type="button" class="btn btn-red e_wiggle" >Remover</button>'
                ]).draw(false);
                patDocumentos.columns.adjust().draw();
                $("#arquivoAD").val("");
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

    $('#patDocumentos').on("click", "button", function () {
        $("#mdlAguarde").modal('toggle');

        var row = $(this).parents('tr').data();
        var tipo = patDocumentos.row($(this).parents('tr')).data()[0];
        var nomeArquivo = patDocumentos.row($(this).parents('tr')).data()[2];
        patDocumentos.row($(this).parents('tr')).remove().draw(false);

        switch(tipo) {
            case "CPF":
                $arq01=false;
                break;
            case "Identidade":
                $arq02=false;
                break;
            case "Comprovante de Residência (janeiro/2020)":
                $arq03=false;
                break;
            case "Comprovante de Residência (fevereiro/2020)":
                $arq04=false;
                break;
            case "Comprovante de Residência (março/2020)":
                $arq05=false;
                break;
            case "Comprovante de Atividades de Trabalho":
                $arq06=false;
                break;
            case "Comprovante de Imposto de Renda ano base 2018":
                $arq07=false;
                break;
            case "Auto declaração":
                $arq08=false;
                break;
        }
        $.get("{{ url('/pat_documentos_remove') }}/"  + nomeArquivo, function (resposta) {

            $("#mdlAguarde").modal('toggle');

        })
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
        return true;
    }

    function validadataNascimento2(data){
        data = data.replace(/\//g, "-"); // substitui eventuais barras (ex. IE) "/" por hífen "-"
        var data_array = data.split("-"); // quebra a data em array
        
        // para o IE onde será inserido no formato dd/MM/yyyy
        if(data_array[0].length != 4){
            data = data_array[2]+"-"+data_array[1]+"-"+data_array[0]; // remonto a data no formato yyyy/MM/dd
        }
        
        // comparo as datas e calculo a idade
        var hoje = new Date();
        var nasc  = new Date(data);
        var idade = hoje.getFullYear() - nasc.getFullYear();
        var m = hoje.getMonth() - nasc.getMonth();
        if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) idade--;
        
        if(idade < 10){
            return false;
        }

        if(idade >= 10 && idade <= 120){
            return true;
        }
        
        // se for maior que 120!
        return false;
    }

    function validadataNascimento(data){
        data = data.replace(/\//g, "-"); // substitui eventuais barras (ex. IE) "/" por hífen "-"
        var data_array = data.split("-"); // quebra a data em array
        
        // para o IE onde será inserido no formato dd/MM/yyyy
        if(data_array[0].length != 4){
            data = data_array[2]+"-"+data_array[1]+"-"+data_array[0]; // remonto a data no formato yyyy/MM/dd
        }
        
        // comparo as datas e calculo a idade
        var hoje = new Date();
        var nasc  = new Date(data);
        var idade = hoje.getFullYear() - nasc.getFullYear();
        var m = hoje.getMonth() - nasc.getMonth();
        if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) idade--;
        
        if(idade < 16){
            return false;
        }

        if(idade >= 16 && idade <= 120){
            return true;
        }
        
        // se for maior que 120!
        return false;
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

    function checkMail(mail){	
        var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);	
        if(typeof(mail) == "string"){		
            if(er.test(mail)){ return true; }	
        }else if(typeof(mail) == "object"){		
            if(er.test(mail.value)){ 					
                return true; 				
            }	
        }else{		
            return false;		
        }
    }

</script>
@endsection