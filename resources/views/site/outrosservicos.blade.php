@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="inner-heading">
                    <h2>{{ __('OUTROS SERVIÇOS') }}</h2>
                </div>
            </div>
            <div class="span8">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Outros Serviços') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
        <div class="container">
            <br>
            <br>
            <br>
            <div class="row">

                <div class="span12">
                    <div class="row">
                        <div class="span2">
                            &nbsp;
                        </div>
                        <div class="span4">
                            <a href="http://passaporteuniversitario.marica.rj.gov.br/" target="_BLANK">
                                <div class="box aligncenter">
                                    <div class="aligncenter icon">
                                        <img src="img/icones/passaporte.png" alt="Icone Passaporte Universitário"
                                            title="Icone Passaporte Universitário" width="70px" />
                                    </div>
                                    <div class="text">
                                        <h6>PASSAPORTE UNIVERSITÁRIO</h6>
                                    </div>
                                    <div>
                                        Acesse aqui o Portal do Programa Passaporte Universitário para solicitação e consulta de serviços.
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="span4">
                            @if( !Auth::user())
                            <a href="http://itbionline.marica.rj.gov.br/" target="_BLANK">
                            @else
                            <a href="{{ url('servicos/1/4' ) }}">
                            @endif
                                <div class="box aligncenter">
                                    <div class="aligncenter icon">
                                        <img src="img/icones/ouvidoria.png" alt="Icone Ouvidoria" title="Icone Ouvidoria"
                                            width="70px" />
                                    </div>
                                    <div class="text">
                                        <h6>ITBI ON-LINE</h6>
                                    </div>
                                    <div>
                                        Faça aqui a sua solicitação da guia do ITBI online. Acompanhe o andamento do serviço na opção Consulta. Público alvo: Corretoras, despachantes e empresas.
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- <div class="span3">
                            <a href="{{ route('servicos', 5 ) }}">
                                <div class="box aligncenter">
                                    <div class="aligncenter icon">
                                        <img src="img/icones/servidor.png" alt="Icone Servidor" title="Icone Servidor"
                                            width="70px" />
                                    </div>
                                    <div class="text">
                                        <h6>SERVIDOR</h6>
                                    </div>
                                </div>
                            </a>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </section>
<br>
<br>
<br>
<br>
@endsection
