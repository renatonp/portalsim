@extends('layouts.tema_principal')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa fa-lock"></i> Faça login na sua conta</h4>
                    </div>

                    <div class="card-body">
                        <form class="" method="POST" action="{{ route('login') }}" id="frm_login" autocomplete="off">
                            @csrf
                            
                            <div class="form-group">
                                <label for="cpf">Digite seu CPF/CNPJ</label>
                                <input type="text" name="cpf" id="cpf" class="form-control {{ $errors->has('cpf') ? ' is-invalid' : '' }}" value="{{ $cpf ?? old('cpf') }}" required="true" {{ !$cpf ? 'autofocus' : '' }} />
                                
                                @if ($errors->has('cpf'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('cpf') }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Digite sua Senha</label>
                                <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required="true" {{ $cpf ? 'autofocus' : '' }} />
                                
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                {!! $showRecaptcha !!}
                                
                                @if ($errors->has('g-recaptcha-response'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('g-recaptcha-response') }}
                                    </div>
                                @endif
                            </div>
                            
                            <button type="submit" id="btn_submit" class="btn btn-danger"><i class="fa fa-lock"></i> Acessar</button>
                        </form>
                        
                        <p class="mt-3">
                            <a href="{{ route('password.request') }}">Esqueceu a sua senha?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('post-script')

<script type="text/javascript">

    var tmpcpf = $("#cpf").val()
    $("#btn_submit").prop('disabled', true);

    console.log("Registrando Funções do captcha");
    function onReCaptchaTimeOut() {
        console.log("Bloquear Botão");
        $("#btn_submit").prop('disabled', true);
    }
    function onReCaptchaSuccess() {
        console.log("Liberar Botão");
        $("#btn_submit").prop('disabled', false);
    }
    function onReCaptchaError() {
        console.log("Erro no captcha");
        $("#btn_submit").prop('disabled', true);
    }
    console.log("Fim do registro");


    jQuery(document).ready(function () {
        console.log("Registrando os Eventos do captcha");
        // jQuery('.g-recaptcha').attr('data-callback', 'onReCaptchaSuccess');
        // jQuery('.g-recaptcha').attr('data-expired-callback', 'onReCaptchaTimeOut');
        // jQuery('.g-recaptcha').attr('data-error-callback', 'onReCaptchaError');
        console.log("Fim do registro");

        $('#cpf').mask('00.000.000/0000-00')
        var cpf_opt = {
            onKeyPress: function (cpf, e, field, cpf_opt) {
                console.log("Keypress: " + cpf.length)
                var masks = ['00.000.000/0000-00', '000.000.000-00'];
                var mask = (cpf.length > 14 || cpf.length == 0) ? masks[0] : masks[1];
                $('#cpf').mask(mask, cpf_opt);
            }
        };

        if (typeof ($("#cpf")) !== "undefined") {
            var masks = ['00.000.000/0000-00', '000.000.000-00'];
            var mask = ($("#cpf").val().length > 14 || $("#cpf").val().length == 0) ? masks[0] : masks[1];
            $("#cpf").mask(mask, cpf_opt);
        }

        $("#cpf").val(tmpcpf);

    });

</script>

@endsection
