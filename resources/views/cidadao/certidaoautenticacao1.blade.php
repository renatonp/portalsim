@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>Verifica Autenticidade das Certidões</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{  url('/servicos/1') }}">Cidadão </a><i class="fa fa-angle-right"></i></li>
                    <li class="active">Verifica Autenticidade das Certidões</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="aligncenter">
            <form method="POST" action="{{ route('validaautenticidade2') }}" id="validaFormCertidao">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <br />
                        <br />
                        <div class="row formrow">
                            <div class="controls span3 form-label">
                                <label for="codigo" class="col-md-4 col-form-label text-md-right">
                                    {{ __('CÓDIGO DE AUTENTICIDADE') }}
                                </label>
                            </div>
                            <div class="span7">
                                <input id="codigo" type="text" class="form-input" name="codigo" value="" autofocus>
                            </div>
                        </div>

                        {!! $showRecaptcha !!}
                        <br>
                        <br>
                        <br>
                        <div class='row'>
                            <div class="span6 align-left">
                                <a href="{{ url('servicos/1') }}">
                                    <button type="button" class="btn btn-theme e_wiggle">
                                        {{ __('Voltar') }}
                                    </button>
                                    <a>
                            </div>
                            <div class="span6 align-right">
                                <button type="button" class="btn btn-theme e_wiggle" id="autenticar" disabled>
                                    {{ __('Verificar Autenticidade') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
</section>


@endsection


@section('post-script')
<script type="text/javascript">

    $("#autenticar").prop('disabled', true);

    jQuery(document).ready(function(){
            
        $("#autenticar").click(function(){
            if( $("#codigo").val() === ""  ){
                alert("Por favor, informe o CÓDIGO DE AUTENTICAÇÃO para verificar.");
                $("#codigo").focus();
            }
            else{
                
                $("#validaFormCertidao").submit();
            }
        });

        jQuery('.g-recaptcha').attr('data-callback', 'onReCaptchaSuccess');
        jQuery('.g-recaptcha').attr('data-expired-callback', 'onReCaptchaTimeOut');
    });
    function onReCaptchaTimeOut(){
        $("#autenticar").prop('disabled', true);
    }
    function onReCaptchaSuccess(){
        $("#autenticar").prop('disabled', false);
    }
</script>
@endsection