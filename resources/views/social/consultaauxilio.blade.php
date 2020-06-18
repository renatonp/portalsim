@extends('layouts.tema01')

@section('content')

<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('CONSULTA DE BENEFÍCIO') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('CONSULTA DE BENEFÍCIO') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form method="POST" action="{{ route('validaconsultaauxilio') }}" id="frmConsultarAuxilio">
                                @csrf
                                
                                @if ($errors->has('mensagem'))
                                <div class="alert alert-error">
                                    <center>
                                        <strong>Atenção:</strong><br>
                                        <strong>{{ $errors->first('mensagem') }}</strong>
                                    </center>
                                </div>
                                @endif



                                {{-- CPF --}}
                                <div class="row formrow">
                                    <div class="controls span5 form-label">
                                        <label for="protocolo" class="col-md-4 col-form-label text-md-right">
                                        {{ __('Número do Protocolo') }}
                                        </label>
                                    </div>
                                    <div class="span2">
                                        <input maxlength="20" id="protocolo" type="text" class="form-input" name="protocolo" value="{{ old('protocolo') }}" autofocus>
                                        @if ($errors->has('protocolo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('protocolo') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row formrow">
                                    <div class="controls span5 form-label">
                                        <label for="pat_cpf" class="col-md-4 col-form-label text-md-right">
                                        {{ __('CPF') }}
                                        </label>
                                    </div>
                                    <div class="span2">
                                        <input maxlength="20" id="pat_cpf" type="text" class="form-input" name="pat_cpf" value="{{ old('pat_cpf') }}" >
                                        @if ($errors->has('pat_cpf'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pat_cpf') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row formrow">
                                    <div class="controls span5 form-label">
                                        <label for="dtNasc" class="col-md-4 col-form-label text-md-right">
                                        {{ __('Data de Nascimento') }}
                                        </label>
                                    </div>
                                    <div class="span2">
                                        <input maxlength="20" id="dtNasc" type="text" class="form-input" name="dtNasc" value="{{ old('dtNasc') }}">
                                        @if ($errors->has('dtNasc'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dtNasc') }}</strong>
                                        </span>
                                        <br>
                                        <br>
                                        @endif
                                    </div>
                                </div>
                                <div class="row formrow">
                                    <div class="controls span5 form-label">
                                        &nbsp;
                                    </div>
                                    <div class="span4">
                                        {!! $showRecaptcha !!}
                                    </div>
                                </div>
                                <div class="row formrow">
                                    <div class="controls span5 form-label">
                                        &nbsp;
                                    </div>
                                    <div class="span4">
                                        <br>
                                        <br>
                                        @if ($errors->has('dtNasc'))
                                        <br>
                                        <br>
                                        @endif
                                        <button type="button" class="btn btn-warning e_wiggle" id="btn_consultar">
                                            {{ __('Consultar') }}
                                        </button>
                                    </div>
                                </div>

                            </form>
                            <div class="span3 align-left">
                                <a href="{{ route('PAT', 1 )  }}">
                                    <button type="button" class="btn btn-theme e_wiggle" id="voltar">
                                        {{ __('Voltar') }}
                                    </button>
                                    <a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
</section>
@endsection

@section('post-script')

<script type="text/javascript">

    $("#btn_consultar").prop('disabled', true);


    jQuery(document).ready(function(){
        $("#pat_cpf").mask("000.000.000-00");
        $("#dtNasc").mask("00/00/0000");
    });

    function onReCaptchaTimeOut(){
        $("#btn_consultar").prop('disabled', true);
    }
    function onReCaptchaSuccess(){
        $("#btn_consultar").prop('disabled', false);
    }

    $("#btn_consultar").click(function(){
        $("#frmConsultarAuxilio").submit();
    });

</script>
@endsection