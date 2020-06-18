@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span6">
                <div class="inner-heading">
                    @if($servico == "Cadastro Geral do Município - PF")
                        <h2 class="texto-titulo">Cadastro Geral do Município</h2>
                    @else
                        <h2 class="texto-titulo">{{$servico}}</h2>
                    @endif
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
                        <a href="{{url('/servicos/' . $guia)}}">
                            {{$guia}}
                        </a> 
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">
                        @if($servico == "Cadastro Geral do Município - PF")
                            Cadastro Geral do Município 
                        @else
                            {{$servico}}
                        @endif                        
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @if (session('erroServico'))
        @if (session('erroServico') == 1)

            <div id="erroServico" class="modal styled hide fade" tabindex="-1" role="dialog" aria-labelledby="mySignupModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="mySignupModalLabel">SERVIÇOS</h4>
                </div>
                <div class="modal-body">
        
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Erro!</strong> Houve um erro ao tentar acessar os serviços. Tente novamente em alguns intantes.
                    </div>
        
                    <p class="text-center">
                        <button  class="btn btn-large btn-theme margintop10" type="button" data-dismiss="modal">Fechar</button>
                    </p>
                </div>
            </div>

        @endif
    @endif
        
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
                {{-- <div class="row align-right">
                    <div class="span5">
                        <ul class="progress align-right">
                            <li id='etapa3' class="item 
                            @if ($activityInstanceId == 13)
                            is-active
                            @endif
                            ">
                            </li>
                            <li  id='etapa12' class="item"></li>
                            <li id='etapa11' class="item"></li>
                            <li id='etapa10' class="item"></li>
                            <li id='etapa9' class="item"></li>
                        </ul>
                    </div>
                </div> --}}
                <iframe name="bpm-iframe" id="bpm-iframe" src="{{$caminho}}?processInstanceId={{ $processInstanceId }}&activityInstanceId={{ $activityInstanceId }}&cycle={{ $cycle }}&uuid={{ $uuid }}&language=pt_BR&displayFormHeader=false&highContrast=false" frameborder="0" scrolling="auto" height="100%" width="100%" style="height: 1700px;"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection

    
@section('post-script')
    <script type="text/javascript">
        jQuery(document).ready(function(){

            // $('#bpm-iframe').on('load', function() {
            //     var url = '{{ url( config('app.url')."/detectaEtapa/").$processInstanceId }}';
            //     $.get( url,  function(resposta){

            //         console.log("RESPOSTA: " + resposta);

            //         $('html, body').animate({ scrollTop: 10 }, 50);

            //         $("#etapa3").removeClass('is-active')
            //         $("#etapa12").removeClass('is-active')
            //         $("#etapa11").removeClass('is-active')
            //         $("#etapa10").removeClass('is-active')
            //         $("#etapa9").removeClass('is-active')

            //         if( resposta == 13 ){
            //             $("#etapa3").addClass('is-active')
            //         }
            //         else if( resposta == 12 ){
            //             $("#etapa3").addClass('is-active')
            //             $("#etapa12").addClass('is-active')
            //         }
            //         else if( resposta == 11 ){
            //             $("#etapa3").addClass('is-active')
            //             $("#etapa12").addClass('is-active')
            //             $("#etapa11").addClass('is-active')
            //         }
            //         else if( resposta == 10 ){
            //             $("#etapa3").addClass('is-active')
            //             $("#etapa12").addClass('is-active')
            //             $("#etapa11").addClass('is-active')
            //             $("#etapa10").addClass('is-active')
            //         }
            //         else if( resposta == 9 ){
            //             $("#etapa3").addClass('is-active')
            //             $("#etapa12").addClass('is-active')
            //             $("#etapa11").addClass('is-active')
            //             $("#etapa10").addClass('is-active')
            //             $("#etapa9").addClass('is-active')
            //         }
            //     });

            // });

        });

    </script>
@endsection
