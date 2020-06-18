@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>PAT</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">PAT</li>
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
                                @if($assunto->descricao=="BENEFÍCIO")
                                    <a href="{{ route( 'consultarsituacao' ) }}">
                                        <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                                            {{ __('Consultar Situação do Benefício') }}
                                        </button>
									</a>
                                @endif
                            </div>
                            <p>
                                <a href="{{  route( 'PAT_CADASTRO' ) }}" class="btnServico">
                                Solicite o <strong>Benefício</strong> aqui:
                                </a>
                            </p>
                            @inject('servicos', 'App\Services\ServicosService')
                            @foreach ($servicos->servicos( $assunto->id ) as $servico)
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
                                        @if($servico->id == 23 )
                                        <br><br>
                                        {{-- <b>{{$total_pat}}</b> Benefício(s) solicitado(s) --}}
                                                <br>
                                                <span style="font-size: 16px;">
                                                    <b>
                                                    Encerramento das inscrições no dia 07/04/2020 foi alterado de 01:31:46 para 13:31:46
                                                    </b>
                                                </span>
                                                <br>
                                                <br>
                                    @endif                                        
                                    </span>
                                    @endif

                                </p>
                            @endforeach
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
