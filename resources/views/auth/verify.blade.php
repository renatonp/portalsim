@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="span4">
                    <div class="inner-heading">
                        <h2>{{ __('Cadastro') }}</h2>
                    </div>
                </div>
                <div class="span8">
                    <ul class="breadcrumb">
                        <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                        <li class="active">{{ __('Cadastro') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row aligncenter">
            <div class="span12">
                <h2>Verifique seu endereço de e-mail</h2>
                @if (session('resent'))
                    <div class="alert alert-success">
                        {{ __('Um novo link de verificação foi enviado para seu endereço de e-mail.') }}
                    </div>
                @endif
                <br>
                <div class="alert alert-success">
                    {{ __('Antes de prosseguir, verifique seu e-mail em busca de um link de verificação.') }}
                    {{ __('Se você não recebeu o email') }}, <a href="{{ route('verification.resend') }}">{{ __('clique aqui para solicitar outro') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
@endsection
