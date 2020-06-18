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
                
                <form method="POST" action="{{ route('certnegativa_validarCpf') }}" id="infoCpf">
                    @csrf
                    {{-- CPF --}}
                    <div class="row formrow">
                        <div class="controls span5 form-label">
                            <label for="cgm_cpf" class="col-md-4 col-form-label text-md-right">
                            {{ __('Informe o CNPJ') }}
                            </label>
                        </div>
                        <div class="span2">
                            <input maxlength="20" id="cgm_cpf" type="text" class="form-input{{ $errors->has('cgm_cpf') ? ' is-invalid' : '' }}" name="cgm_cpf" 
                            @auth
                                value="{{Auth::user()->cpf}}" 
                            @else
                                value="" 
                            @endif
                            required>
                            @if ($errors->has('pat_cpf'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('cgm_cpf') }}</strong>
                            </span>
                            @endif
                        </div>

                    </div>

                    <div class="row formrow">
                        <div class="controls span5 form-label">
                        </div>
                        <div class="span3 align-left">
                            {!! $showRecaptcha !!}
                        </div>
                    </div>
                    <br>
                    <br>

                    <div class="row formrow">
                        <div class="controls span5 form-label">
                        </div>
                        <div class="span2 align-left">
                            <button type="button" class="btn btn-theme e_wiggle align-right" id="validar_CPF">
                                {{ __('Gerar Certidão') }}
                            </button>
                        </div>                              
                    </div>
                    <br>

                </form>
                <div class="row">
                    <div class="span1 align-left">
                    </div>
                    <div class="span8 align-left">
                        <a href="{{ route('servicos', [1,2] )  }}">
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
    $("#cgm_cpf").mask('00.000.000/0000-00');
    
    // var cpf_options = {
    //     onKeyPress: function (cpf1, e, field, cpf_options) {
    //         var masks = ['000.000.000-000', '00.000.000/0000-00'];
    //         var mask = (cpf1.length > 14 || cpf1.length == 0) ? masks[1] : masks[0];
    //         $('#cgm_cpf').mask(mask, cpf_options);
    //     }
    // };

    // if (typeof ($("#cgm_cpf")) !== "undefined") {
    //     $("#cgm_cpf").mask('00.000.000/0000-00', cpf_options);
    // }

    function onReCaptchaTimeOut(){
        $("#validar_CPF").prop('disabled', true);
    }
    function onReCaptchaSuccess(){
        $("#validar_CPF").prop('disabled', false);
    }


    $("#validar_CPF").click(function(){
        if($("#cgm_cpf").val() == ""){
            alert("Por favor informe o CNPJ");
            $("#cgm_cpf").focus();
            return false;
        }

        // if($("#cgm_cpf").val().length <= 14){
        //     if(!validarCPF($("#cgm_cpf").val())){
        //         alert("CPF Inválido!");
        //         $("#cgm_cpf").focus();
        //         return false;
        //     }
        // }
        // else{
            if(!validarCNPJ($("#cgm_cpf").val())){
                alert("CNPJ Inválido!");
                $("#cgm_cpf").focus();
                return false;
            }
        // }

        $("#mdlAguarde").modal('toggle');
        $("#infoCpf").submit();
        $("#cgm_cpf").val("");
        grecaptcha.reset();
        setTimeout(function(){ $("#mdlAguarde").modal('toggle'); }, 5000);
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


</script>
@endsection