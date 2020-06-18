@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{$guia}}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{$guia}}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section id="content">
    <div class="container">
        <div class="tabbable tabs-left">
            <ul class="nav nav-tabs" id="menuTab">
                @foreach ($assuntos as $assunto)
                    @if ($loop->first)
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a href="#tab-{{$loop->index}}" data-toggle="tab">
                        {{$assunto->descricao}}
                    </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach ($assuntos as $assunto)
                    @if ($loop->first)
                        <div class="tab-pane active" id="tab-{{$loop->index}}">
                    @else
                        <div class="tab-pane" id="tab-{{$loop->index}}">
                    @endif
                        <div class="tab-interna">
                            <div class="titulo-servico">
                                <h2>
                                    {{$assunto->descricao}}
                                </h2>
                            </div>
                            <p>
                                Escolha o seu <strong>Serviço</strong>:
                            </p>
                            @inject('servicos', 'App\Services\ServicosService')
                            @foreach ($servicos->servicos( $assunto->id ) as $servico)
                                @if(($guia == "CIDADÃO" && $servico->cidadao == 1) || (  $guia == "EMPRESA" && $servico->empresa == 1) )
                                    <p class="lead" >
                                        @if($servico->rota != "itbionline")
                                            @if($servico->servico == "IPTU")
                                                <a href="{{$servico->rota}}" target="_blank">
                                            @else
                                                <a href="{{ route( $servico->rota ) }}" class="btnServico" >
                                            @endif
                                                <button type="button" class="btn btn-theme full">
                                                    {{ $servico->servico }}
                                                </button>
                                            </a>
                                        @else
                                            @auth
                                            <a href="#abrirITBI" data-toggle="modal">
                                            @else
                                            <a href="http://itbionline.marica.rj.gov.br/" target="_BLANK">
                                            @endauth
                                                <button type="button" class="btn btn-theme full">
                                                    {{ $servico->servico }}
                                                </button>
                                            </a>
                                        @endif

                                        @if($servico->descricao != "" )
                                        <span class="pullquote-left" style="margin-top: 6px;">
                                            {{$servico->descricao}}
                                        </span>
                                        @endif
                                    </p>
                                @endif
                            @endforeach
							@if($assunto->descricao == "CERTIDÕES")
								<br>
								<div class="aligncenter" >
									<a href="{{ route( 'certidaoAutenticacao' ) }}">
									<button type="button" class="btn btn-theme e_wiggle" id="autenticar">
										{{ __('Autenticar Certidão') }}
									</button>
									<a>
								</div>
							@endif
                        </div>
                    </div>
                    @endforeach
                    <br>


            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
@endsection

@section('post-script')
<script type="text/javascript">
    jQuery(document).ready(function(){
        if("{{$aba}}" != ""){
            $('#menuTab li:nth-child({{$aba}}) a').tab('show')
        }
        $(".btnServico").click(function () {
            $("#mdlAguarde").modal('toggle');
        });

    });


</script>
@endsection
