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
                <div>
                    {{-- <div class="alert" style="width: 380px; text-align:center; float:right; border-radius: 7px; border: 1px solid #d7cbb6; color: #ae7410;"> --}}
                    <div class="alert alert-info" style="width: 480px; text-align:center; margin: auto; border-radius: 7px; border: 1px solid #82a5c7; color: #ae7410;">
                        {{-- <h4>
                            <b>{{$total_pat}}</b> Benefício(s) solicitado(s)
                        </h4>  --}}
                            <br>
                            <b>
                                Encerramento das inscrições<br> 
                                no dia 07/04/2020 foi alterado de 01:31:46 para <br><h5>13:31:46</h5>
                            </b>
                    </div>
                    <br>
                    <br>
                </div>
                
                <form method="POST" action="{{ route('pat_validarCpf') }}" id="infoCpf">
                    @csrf
                    {{-- totalizador --}}
                    <div class="row formrow">
                        <div class="controls span5 form-label">
                            <label for="pat_cpf" class="col-md-4 col-form-label text-md-right">
                            </label>
                        </div>

                    </div>

                    {{-- CPF --}}
                    <div class="row formrow">
                        <div class="controls span5 form-label">
                            <label for="pat_cpf" class="col-md-4 col-form-label text-md-right">
                            {{ __('Informe o seu CPF') }}
                            </label>
                        </div>
                        <div class="span2">
                            <input maxlength="20" id="pat_cpf" type="text" class="form-input{{ $errors->has('pat_cpf') ? ' is-invalid' : '' }}" name="pat_cpf" value="" required>
                            @if ($errors->has('pat_cpf'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pat_cpf') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="span2 align-left">
                            <button type="button" class="btn btn-theme e_wiggle align-right" id="validar_CPF">
                                {{ __('Validar CPF') }}
                            </button>
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
                </form>
                <div class="row">
                    <div class="span1 align-left">
                    </div>
                    <div class="span8 align-left">
                        <a href="{{ route('PAT', 1 )  }}">
                            <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
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

    jQuery(document).ready(function(){
        $("#pat_cpf").mask("000.000.000-00");

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