@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span6">
                <div class="inner-heading">
                    <h2 class="titulo-grande">CERTIDÃO NEGATIVA DE DÉBITO</h2>
                </div>
            </div>
            <div class="span6">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{  url('/') }}">
                            <i class="fa fa-home"></i>
                        </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="{{  url('/servicos_documentos') }}">
                            Documentos e Processos
                        </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">
                        Certidão Negativa de Débito
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="span12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <iframe name="bpm-iframe" id="bpm-iframe" src="{{$caminho}}?processInstanceId={{ $infoForm['resposta']->{'content'}->{'processInstanceId'} }}&activityInstanceId={{ $infoForm['resposta']->{'content'}->{'currentActivityInstanceId'} }}&cycle={{ $infoForm['resposta']->{'content'}->{'currentCycle'} }}&uuid={{ $uuid }}&language=pt_BR&displayFormHeader=false&highContrast=false" frameborder="0" scrolling="auto" height="100%" width="100%" style="height: 1700px;"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
