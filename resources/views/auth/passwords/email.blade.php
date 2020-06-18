@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('ESQUECEU A SENHA') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Esqueceu a Senha') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('esqueceuSenha') }}">
                            @csrf

                            <div class="row">
                                <div class="span4 form-label">
                                    <label for="cpf" class="control-label">
                                        {{ __('CPF/CNPJ') }}
                                    </label>
                                </div>
                                <div class="span4">
                                    <input id="cpf" type="text" class="form-input{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{ $email ?? old('cpf') }}" required autofocus>
                
                                    @if ($errors->has('cpf'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cpf') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            {!! $showRecaptcha !!}
                            <br>

                            {{-- <div class="row">
                                <diV class="controls span4 form-label">
                                    <label for="email" class="control-label">{{ __('E-Mail') }}</label>
                                </div>
                                <div class="controls span6">
                                    <input id="email" type="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <div class="controls">
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div> --}}

                            <div class="row">
                                <div class="span12 aligncenter">
                                    <button id="enviarlink" type="submit" class="btn btn-theme e_wiggle" disabled>
                                        {{ __('Enviar Link para recuperar a senha') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
<br>
<br>
<br>
<br>
@endsection
@section('post-script')
    <script type="text/javascript">

        $("#enviarlink").prop('disabled', true);
        var tmpcpf = $("#cpf").val()
        
        jQuery(document).ready(function(){
            jQuery('.g-recaptcha').attr('data-callback', 'onReCaptchaSuccess');
            jQuery('.g-recaptcha').attr('data-expired-callback', 'onReCaptchaTimeOut');            

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
        });

        function onReCaptchaTimeOut(){
            $("#enviarlink").prop('disabled', true);
        }
        function onReCaptchaSuccess(){
            $("#enviarlink").prop('disabled', false);
        }   

    </script>
@endsection   