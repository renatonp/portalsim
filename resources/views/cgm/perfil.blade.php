@extends('layouts.tema01')

@section('content')
@php
    $maxProcesso = MAX_PROC_LECOM;
@endphp

<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('CADASTRO DO CIDADÃO') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Cadastro do Cidadão') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
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



                @if (session('status'))
                @if (session('status') == 1 || session('status') == 3)
                <div class="alert alert-success" role="alert" id="mensagem" style="transition: 10s; opacity: 1;">
                    As suas informações foram gravadas com sucesso
                </div>
                @endif
                @if (session('status') == 2 || session('status') == 3)
                <div class="alert alert-info" role="alert" id="mensagem2" style="transition: 20s; opacity: 1;">
                    Para efetivar a alteração, confirme a sua solicitação no endereço de e-mail anteriormente cadastrado.
                </div>
                @endif

                @endif
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
                                        href="#collapseOne1">
                                        <i class="icon-minus"></i>
                                        @if( strlen($cgm->aCgmPessoais->z01_cgccpf) > 11 )
                                        Informações Empresariais
                                        @else
                                        Informações Pessoais
                                        @endif
                                    </a>
                                </div>
                                <div id="collapseOne1" class="accordion-body collapse in">
                                    @include('cgm.informacoes_pessoais')
                                    {{-- @include('cgm.emconstrucao') --}}
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
                                        href="#collapseTwo1">
                                        <i class="icon-plus"></i> Informações de Contato
                                    </a>
                                </div>
                                <div id="collapseTwo1" class="accordion-body collapse">
                                    @include('cgm.informacoes_contato')
                                    {{-- @include('cgm.emconstrucao') --}}
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
                                        href="#collapseThree1">
                                        <i class="icon-plus"></i> Endereço
                                    </a>
                                </div>
                                <div id="collapseThree1" class="accordion-body collapse">
                                    @include('cgm.endereco')
                                    {{-- @include('cgm.emconstrucao') --}}
                                </div>
                            </div>

                            {{-- 
                            ***********************************
                            *** Endereço de correspondência
                            ***********************************
                            --}}
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                        href="#collapseThree2">
                                        <i class="icon-plus"></i> Endereço de Correspondência
                                    </a>
                                </div>
                                <div id="collapseThree2" class="accordion-body collapse">
                                    @include('cgm.endereco_correspondencia')
                                </div>
                            </div>
                            {{-- 
                            ***********************************
                            *** Informações Adicionais
                            ***********************************
                            --}}
                            @if( strlen($cgm->aCgmPessoais->z01_cgccpf) <= 11) 
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse4">
                                        <i class="icon-plus"></i> Informações Adicionais
                                    </a>
                                </div>
                                <div id="collapse4" class="accordion-body collapse">
                                    @include('cgm.informacoes_adicionais')
                                </div>
                            </div>
                            @endif
                            
                        {{-- 
                        ***********************************
                        *** Documentos em Anexo
                        ***********************************
                        --}}
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                    href="#collapse5">
                                    <i class="icon-plus"></i> Documentos em Anexo
                                </a>
                            </div>
                            <div id="collapse5" class="accordion-body collapse">
                                @include('cgm.documentos')
                                {{-- @include('cgm.emconstrucao') --}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                    <div class="span6 text-left">
                        <a href="{{ url('servicos/1')  }}">
                            <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                                {{ __('Voltar') }}
                            </button>
                            <a>
                    </div>
                    <div class="span6 align-left">
                        <a href="{{ route('alterarSenha') }}">
                            <button type="button" class="btn btn-warning e_wiggle align-right">
                                {{ __('Alterar Senha') }}
                            </button>
                        </a>
                    </div>
                </div>
                {{--  </form>  --}}
            </div>
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

    var infoEnviada = false;

    jQuery(document).ready(function(){

        @if (session('status'))
            @if (session('status') == 1 || session('status') == 3)
                $("#mensagem").css({
                    "opacity": "0"
                });
            @endif
            @if (session('status') == 2 || session('status') == 3)
                $("#mensagem2").css({
                    "opacity": "0"
                });
            @endif
        @endif

        var tmpcpf = "{{Auth::user()->cpf}}";

        var cpf_opt = {
            onKeyPress: function (cpf, e, field, cpf_opt) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                var mask = (cpf.length > 14) ? masks[1] : masks[0];
                $('#cpf').mask(mask, cpf_opt);
            }
        };

        if (typeof ($("#cpf")) !== "undefined") {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = ($("#cpf").val().length > 14) ? masks[1] : masks[0];
            $("#cpf").mask(mask, cpf_opt);
        }
        $("#cpf").val(tmpcpf) ;

        var cpf_opt2 = {
            onKeyPress: function (cpf2, e, field, cpf_opt2) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                var mask = (cpf2.length > 14) ? masks[1] : masks[0];
                $('#cpf').mask(mask, cpf_opt2);
            }
        };

        if (typeof ($("#cpf2")) !== "undefined") {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = ($("#cpf2").val().length > 14) ? masks[1] : masks[0];
            $("#cpf2").mask(mask, cpf_opt);
        }
        $("#cpf2").val(tmpcpf) ;


        $("#cep").mask("00.000-000");
        $("#celphone").mask("(00)00000-0000");
        $("#phone").mask("(00)0000-0000");
        $("#pis").mask("000.0000.00-0", {reverse: true});
        $("#identidade").mask("##.999.999-00", {reverse: true});
        $("#number1").mask("####");
        $("#number").mask("####");
        $("#renda").mask("###.###.###.##0,00", {reverse: true});

        $("#btn_consultar").click(function(){
            if ($("#cep").val() == ""){
                alert("Informe o CEP");
                return false;
            }
            else{
                // $("#buscaCep").modal('toggle');
                var cep = $("#cep").val().replace(/[^0-9]/, '');
                if(cep){
                    var url = 'register/consultaCEP/' + cep;
                    
                    $.get( url,  function(resposta){
                        var obj = jQuery.parseJSON(resposta);
                        console.log(obj);
                        if(obj.logradouro){
                            $("#address").val(obj.logradouro);
                            $("#district").val(obj.bairro);
                            $("#city").val(obj.localidade);
                            $("#uf").val(obj.uf);
                            $("#buscaCep").modal('toggle');
                        }
                    });
                }					
            }
        });	


    });

</script>
<script src="{{ asset('js/cgm/informacoes_adicionais.js') }}"></script>
<script src="{{ asset('js/cgm/informacoes_contato.js') }}"></script>
<script src="{{ asset('js/cgm/informacoes_pessoais.js') }}"></script>
<script src="{{ asset('js/cgm/endereco_correspondencia.js') }}"></script>
<script src="{{ asset('js/cgm/endereco.js') }}"></script>
<script src="{{ asset('js/cgm/documentos.js') }}"></script>
@endsection