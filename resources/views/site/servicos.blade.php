@extends('layouts.tema_principal')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-servicos">
                <div class="card-header card-header-title">{{ $guia }}</div>

                <div class="card-body">
                    <div id="accordion">
                        @inject('servicos', 'App\Services\ServicosService')
                        @foreach ($assuntos as $assunto)
                            
                            <div class="card mb-3">
                                <a data-toggle="collapse" href="#collapse{{$loop->index}}" class="text-secondary no-underline">
                                    <div class="card-header">
                                        <i class="fa fa-arrow-down arrow-red"></i> {{$assunto->descricao}}
                                    </div>
                                </a>

                                <div id="collapse{{$loop->index}}" class="collapse shadow-lg {{ (str_slug($assunto->descricao) == $aba ? 'show' : '') }}" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>
                                            Escolha o seu <strong>Serviço</strong>:
                                        </p>

                                        @foreach ($servicos->servicos($assunto->id) as $servico)

                                            @if( ($guia == "CIDADÃO" && $servico->cidadao == 1) || (  $guia == "EMPRESA" && $servico->empresa == 1) )

                                                <div class="alert alert-primary pt-4">

                                                    @if($servico->rota != "itbionline")

                                                        @if ($servico->servico == "IPTU")
                                                            <a href="{{ $servico->rota}}" class="btn btn-outline-primary w-100" target="_blank">
                                                                <b>{{ $servico->servico }}</b>
                                                            </a>
                                                        @else
                                                            <a href="{{ route( $servico->rota ) }}" class="btn btn-outline-primary w-100">
                                                                <b>{{ $servico->servico }}</b>
                                                            </a>
                                                        @endif
                                                    @else
                                                        @auth
                                                            <a href="#abrirITBI" data-toggle="modal" class="btn btn-outline-primary w-100">
                                                                <b>{{ $servico->servico }}</b>
                                                            </a>
                                                        @else
                                                            <a href="http://itbionline.marica.rj.gov.br/" class="btn btn-outline-primary w-100" target="_blank">
                                                                <b>{{ $servico->servico }}</b>
                                                            </a>
                                                        @endauth
                                                    @endif

                                                    @if($servico->descricao != "")
                                                        <p class="mt-3 mb-4 ml-4">
                                                            {{$servico->descricao}}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach

                                        @if($assunto->descricao == "CERTIDÕES")
                                            <div class="text-center">
                                                <a href="{{ route('certidaoAutenticacao') }}" class="btn btn-primary">
                                                    Autenticar Certidão
                                                <a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('post-script')
<script>
    $('#accordion').on('shown.bs.collapse', function (e) {

        var panelHeadingHeight = $('.card').height();
        var animationSpeed = 900;
        var currentScrollbarPosition = $(document).scrollTop();

        var topOfPanelContent = $(e.target).offset().top - 142;

        if ( currentScrollbarPosition >  topOfPanelContent - panelHeadingHeight) {
            $("html, body").animate({ scrollTop: topOfPanelContent}, animationSpeed);
        }
    });
</script>
@endsection
