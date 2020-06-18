@extends('layouts.tema01')

@section('content')

<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('CERTIDÃO NEGATIVA DE DÉBITOS DE EMPRESAS') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('CERTIDÃO NEGATIVA DE DÉBITOS DE EMPRESAS') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-12">
                
                <form method="POST" action="" id="infoCpf">
                    @csrf
                    {{-- CPF --}}
                    <div class="row formrow">
                        <div class="controls span3 form-label">
                            <label for="cpf" class="col-md-4 col-form-label text-md-right">
                            {{ __('CNPJ') }}
                            </label>
                        </div>
                        <div class="span2">
                            <input maxlength="20" id="cpf1" type="text" class="form-input" name="cpf1" value="{{$cnpj}}" readonly>
                        </div>
                    </div>
                    <div class="row formrow">
                        <div class="controls span3 form-label">
                            <label for="nome" class="col-md-4 col-form-label text-md-right">
                            {{ __('Nome') }}
                            </label>
                        </div>
                        <div class="span6">
                        <input maxlength="20" id="nome" type="text" class="form-input" name="nome" value="{{ $resposta->sNomeEmpresa }}" readonly>
                        </div>
                    </div>
                    {{-- <div class="row formrow">
                        <div class="controls span3 form-label">
                            <label for="cgm_cpf" class="col-md-4 col-form-label text-md-right">
                            {{ __('CGM') }}
                            </label>
                        </div>
                        <div class="span2">
                            <input maxlength="20" id="cgm" type="text" class="form-input" name="cgm_cpf" value="{{ $resposta->iNumcgm }}" readonly>
                        </div>
                    </div> --}}


                    <div class="row formrow">
                        <div class="controls span3 form-label">
                        </div>
                        <div class="span2 align-left">
                            <a href="{{$resposta->sUrl}}" download target="_Blank">
                                <button type="button" class="btn btn-theme e_wiggle align-right">
                                    {{ __('Baixar Certidão') }}
                                </button>
                            </a>
                        </div>                              
                    </div>
                    <br>

                </form>
                <div class="row">
                    <div class="span1 align-left">
                    </div>
                    <div class="span8 align-left">
                        <a href="{{ route('certidaoNegativaPositiva')  }}">
                            <button type="button" class="btn btn-theme e_wiggle">
                                {{ __('Voltar') }}
                            </button>
                            <a>
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

    $("#validar_CPF").prop('disabled', true);
    // $("#cpf1").mask('000.000.000-00');

    // var cpf_options = {
    //     onKeyPress: function (cpf1, e, field, cpf_options) {
    //         var masks = ['000.000.000-00', '00.000.000/0000-00'];
    //         var mask = (cpf1.length > 14 || cpf1.length == 0) ? masks[1] : masks[0];
    //         $('#cpf1').mask(mask, cpf_options);
    //     }
    // };

    // if (typeof ($("#cpf1")) !== "undefined") {
    //     $("#cpf1").mask('00.000.000/0000-00', cpf_options);
    // }

    jQuery(document).ready(function(){



    });

    function onReCaptchaTimeOut(){
        $("#validar_CPF").prop('disabled', true);
    }
    function onReCaptchaSuccess(){
        $("#validar_CPF").prop('disabled', false);
    }

    $("#validar_CPF").click(function(){
        $("#mdlAguarde").modal('toggle');
        
        $("#infoCpf").submit();
    });

</script>
@endsection