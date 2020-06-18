@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>CONSULTA</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">Consulta</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="span12">
                <form method="POST" action="{{ route('acompanhamento') }}" style="width:100%">
                    @csrf

                    <div class="row">
                        <div class="span2">
                            <label for="chamado" class=" text-md-right">{{ __('Nº do Protocolo') }}</label>
                            <input id="chamado" type="text" class="form-input" name="chamado" value="" autofocus>
                        </div>
                        <div class="span2">
                            <label for="responsavel" class=" text-md-right">{{ __('Responsavel') }}</label>
                            <input id="responsavel" type="text" class="form-input" name="responsavel" value="">
                        </div>
                        <div class="span1">
                            <label for="Servico" class=" text-md-right">{{ __('Serviço') }}</label>
                            <input id="Servico" type="text" class="form-input" name="Servico" value="">
                        </div>
                        <div class="span2">
                            <label for="Situacao" class=" text-md-right">{{ __('Situação') }}</label>
                            <select id="Situacao" class="form-input" name="Situacao">
                                <option value=""></option>

                                @inject('servicos', 'App\Services\ServicosService')


                                @foreach ($servicos->fases() as $fase)
                                <option value="{{$fase->fase}}">{{$fase->fase}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="span2">
                            <label for="dataIni" class=" text-md-right">{{ __('Data Inicial') }}</label>
                            <input id="dataIni" type="date" class="form-input" name="dataIni" value="">
                        </div>
                        <div class="span2">
                            <label for="dataFim" class=" text-md-right">{{ __('Data Final') }}</label>
                            <input id="dataFim" type="date" class="form-input" name="dataFim" value="">
                        </div>
                        <div class="span1">
                            <label for="dataFim" class=" text-md-right">&nbsp;</label>
                            <button type="submit" class="btn btn-theme e_wiggle">
                                {{ __('Pesquisar') }}
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                <br>

                @isset($pass)
                @if($pass > 0)
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Atenção!</strong> Você já tem uma solicitação para este serviço. Verifique o status deste
                    serviço:
                </div>
                <br>
                <br>
                @endif
                @endisset

                @if(!empty($registros))
                    @foreach ($registros as $registro)
                        @if( $registro->Serviço == 'Cadastro Geral do Município - PF' || $registro->Serviço == 'Cadastro Geral do Município - PJ')
                            <div class="row registro-fase-topo">
                                <div class="span2">
                                    Chamado: <b>{{ $registro->Chamado }}</b>
                                </div>
                                <div class="span2">
                                    Data: <b>{{ date('d/m/Y', strtotime($registro->abertura)) }}</b>
                                </div>
                                <div class="span4">
                                    Serviço: <b>{{ $registro->Serviço }}</b>
                                </div>
                                <div class="span4">
                                    Responsável: <b>{{ $registro->responsavel_consulta }}</b><br>
                                </div>
                            </div>

                            <div class="justfy-content-center registro-fase">
                                <center>
                                    @switch($registro->Fase)
                                    @case('Abertura da Solicitação')
                                    @case('Inscrição')
                                    @if( $registro->Serviço == 'Cadastro Geral do Município - PF' )
                                    <img src="{{ asset('img/fase_cgm_01.png') }}" alt="Fase" class="fase" />
                                    @else
                                    <img src="{{ asset('img/fase_01.png') }}" alt="Fase" class="fase" />
                                    @endif
                                    @break
                                    @case('Em Análise')
                                    @case('Análise Inicial')
                                    <img src="{{ asset('img/fase_02.png') }}" alt="Fase" class="fase" />
                                    @break
                                    @case('Execução do Serviço')
                                    @if( $registro->Serviço == 'Cadastro Geral do Município - PF' )
                                    <img src="{{ asset('img/fase_cgm_02.png') }}" alt="Fase" class="fase" />
                                    @else
                                    <img src="{{ asset('img/fase_03.png') }}" alt="Fase" class="fase" />
                                    @endif
                                    @break
                                    @case('Resposta ao Contribuinte')
                                    <img src="{{ asset('img/fase_04.png') }}" alt="Fase" class="fase" />
                                    @break
                                    @case('Cadastro Aprovado')
                                    <img src="{{ asset('img/fase_cgm_04.png') }}" alt="Fase" class="fase" />
                                    @break

                                    @case('Concluído')
                                    @case('Finalizado')
                                    @case('Cadastro Reprovado')
                                    @case('Reprovado')
                                    @case('Aprovado')
                                    @if( $registro->Serviço == 'Cadastro Geral do Município - PF' )
                                    <img src="{{ asset('img/fase_cgm_03.png') }}" alt="Fase" class="fase" />
                                    @else
                                    <img src="{{ asset('img/fase_05.png') }}" alt="Fase" class="fase" />
                                    @endif
                                    @break
                                    @endswitch
                                </center>
                                @if($registro->Fase != "Finalizado" && $registro->Fase != 'Concluído')
                                    @if($registro->responsavel == "Portal")
                                    <br>
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Atenção!</strong> Esta solicitação requer que você faça uma interação: &nbsp;
                                        <a href="{{ route('formularioEdita', $registro->Chamado) }}" class="btn btn-blue">Editar
                                            Solicitação</a>
                                    </div>
                                    @endif
                                @endif

                                @if($registro->motivo != "" || $registro->Fase == "Cadastro Aprovado")
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Atenção!</strong><br>
                                    Esta solicitação foi finalizada e teve como conclusão:<br>
                                    Conclusão: <strong>{{$registro->Fase}}</strong><br>
                                    @if($registro->motivo != "")
                                        Motivo: {{$registro->motivo}}<br>
                                    @endif
                                </div>
                                @endif
                            </div>
                        @elseif( $registro->Serviço == 'Cadastro Geral do Município' )
                            <div class="row registro-fase-topo">
                                <div class="span2">
                                    Chamado: <b>{{ $registro->Chamado }}</b>
                                </div>
                                <div class="span2">
                                    Data: <b>{{ date('d/m/Y', strtotime($registro->abertura)) }}</b>
                                </div>
                                <div class="span4">
                                    Serviço: <b>{{ $registro->Serviço }}</b>
                                </div>
                                <div class="span4">
                                    Responsável: <b>{{ $registro->responsavel_consulta }}</b><br>
                                </div>
                            </div>

                            <div class="justfy-content-center registro-fase">
                                <center>
                                    @switch($registro->Fase)
                                        @case('Abertura de Solicitação')
                                            <img src="{{ asset('img/fases_SIM_CGM_01.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Solicitação em Análise')
                                            <img src="{{ asset('img/fases_SIM_CGM_02.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cumprir Exigências')
                                            <img src="{{ asset('img/fases_SIM_CGM_03.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cadastro Aprovado')
                                            <img src="{{ asset('img/fases_SIM_CGM_04.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cadastro Reprovado')
                                            <img src="{{ asset('img/fases_SIM_CGM_05.png') }}" alt="Fase" class="fase" />
                                            @break
                                    @endswitch
                                </center>

                                @if($registro->Fase != "Finalizado" && $registro->Fase != 'Concluído')
                                    @if($registro->responsavel == "Portal")
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Atenção!</strong> Esta solicitação requer que você faça uma interação: &nbsp;
                                            <a href="{{ route('formularioEdita', $registro->Chamado) }}" class="btn btn-blue">Editar
                                                Solicitação</a>
                                        </div>
                                    @endif
                                @endif

                                @if($registro->motivo != "" &&  $registro->FINALIZADO != "andamento")
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Atenção!</strong><br>
                                        Esta solicitação foi finalizada e teve como conclusão:<br>
                                        Conclusão: <strong>{{$registro->Fase}}</strong><br>
                                        @if(trim($registro->motivo) != "")
                                            Motivo: {{$registro->motivo}}<br>
                                        @endif
                                    </div>
                                @endif
                            </div>

                        @elseif( $registro->Serviço == 'Alteração de Vencimento de IPTU - Idoso' )
                            <div class="row registro-fase-topo">
                                <div class="span2">
                                    Chamado: <b>{{ $registro->Chamado }}</b>
                                </div>
                                <div class="span2">
                                    Data: <b>{{ date('d/m/Y', strtotime($registro->abertura)) }}</b>
                                </div>
                                <div class="span4">
                                    Serviço: <b>{{ $registro->Serviço }}</b>
                                </div>
                                <div class="span4">
                                    Responsável: <b>{{ $registro->responsavel_consulta }}</b><br>
                                </div>
                            </div>

                            <div class="justfy-content-center registro-fase">
                                <center>
                                    @switch($registro->Fase)
                                        @case('Abertura de Solicitação')
                                            <img src="{{ asset('img/fases_UPTU_01.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Solicitação em Análise')
                                            <img src="{{ asset('img/fases_UPTU_02.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cumprir Exigências')
                                            <img src="{{ asset('img/fases_UPTU_03.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Venc. IPTU em Análise')
                                            <img src="{{ asset('img/fases_UPTU_04.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Exigências no IPTU')
                                            <img src="{{ asset('img/fases_UPTU_05.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Venc. do IPTU Alterado')
                                            <img src="{{ asset('img/fases_UPTU_06.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Venc. do IPTU Inalterado')
                                            <img src="{{ asset('img/fases_UPTU_07.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cadastro Reprovado')
                                            <img src="{{ asset('img/fases_UPTU_08.png') }}" alt="Fase" class="fase" />
                                            @break                                            
                                    @endswitch
                                </center>

                                @if($registro->Fase != "Finalizado" && $registro->Fase != 'Concluído')
                                    @if($registro->responsavel == "Portal")
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Atenção!</strong> Esta solicitação requer que você faça uma interação: &nbsp;
                                            <a href="{{ route('formularioEdita', $registro->Chamado) }}" class="btn btn-blue">Editar
                                                Solicitação</a>
                                        </div>
                                    @endif
                                @endif

                                @if($registro->motivo != "" &&  $registro->FINALIZADO != "andamento")
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Atenção!</strong><br>
                                        Esta solicitação foi finalizada e teve como conclusão:<br>
                                        Conclusão: <strong>{{$registro->Fase}}</strong><br>
                                        @if(trim($registro->motivo) != "")
                                            Motivo: {{$registro->motivo}}<br>
                                        @endif
                                    </div>
                                @endif
                            </div>


                        @elseif( $registro->Serviço == 'Averbar Imóvel' )
                            <div class="row registro-fase-topo">
                                <div class="span2">
                                    Chamado: <b>{{ $registro->Chamado }}</b>
                                </div>
                                <div class="span2">
                                    Data: <b>{{ date('d/m/Y', strtotime($registro->abertura)) }}</b>
                                </div>
                                <div class="span4">
                                    Serviço: <b>{{ $registro->Serviço }}</b>
                                </div>
                                <div class="span4">
                                    Responsável: <b>{{ $registro->responsavel_consulta }}</b><br>
                                </div>
                            </div>

                            <div class="justfy-content-center registro-fase">
                                <center>
                                    @switch($registro->Fase)
                                        @case('Abertura da Solicitação')
                                            <img src="{{ asset('img/fases_averbar_01.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Análise da Documentação')
                                        @case('Análise Documental')
                                            <img src="{{ asset('img/fases_averbar_02.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cumprir Exigências')
                                            <img src="{{ asset('img/fases_averbar_03.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cadastro do CGM')
                                            <img src="{{ asset('img/fases_averbar_04.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Averbação Realizada')
                                            <img src="{{ asset('img/fases_averbar_05.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cancelado')
                                            <img src="{{ asset('img/fases_averbar_06.png') }}" alt="Fase" class="fase" />
                                            @break
                                    @endswitch
                                </center>
                                @if($registro->Fase != "Finalizado" && $registro->Fase != 'Concluído')
                                    @if($registro->responsavel == "Portal")
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Atenção!</strong> Esta solicitação requer que você faça uma interação: &nbsp;
                                            <a href="{{ route('formularioEdita', $registro->Chamado) }}" class="btn btn-blue">Editar
                                                Solicitação</a>
                                        </div>
                                    @endif
                                @endif

                                @if($registro->motivo != "" &&  $registro->FINALIZADO != "andamento")
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Atenção!</strong><br>
                                        Esta solicitação foi finalizada e teve como conclusão:<br>
                                        Conclusão: <strong>{{$registro->Fase}}</strong><br>
                                        @if($registro->motivo != "")
                                            Motivo: {{$registro->motivo}}<br>
                                        @endif
                                    </div>
                                @endif

                                @if( $registro->Serviço == 'Averbar Imóvel' )
                                    @if( $registro->Etapa == "11")
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Atenção!</strong> Existem pendências na sua solicitação: &nbsp;<br><br>
                                            <strong>Pendências:</strong> {{$registro->motivo}}<br><br>

                                            <a href="{{ route('averbacaoImovel', $registro->Chamado) }}" class="btn btn-blue">Corrigir pendências</a>
                                        </div>
                                    @endif
                                @endif

                            </div>
                        @elseif( $registro->Serviço == 'Solicitação de ITBI' )
                            <div class="row registro-fase-topo">
                                <div class="span2">
                                    Chamado: <b>{{ $registro->Chamado }}</b>
                                </div>
                                <div class="span2">
                                    Data: <b>{{ date('d/m/Y', strtotime($registro->abertura)) }}</b>
                                </div>
                                <div class="span4">
                                    Serviço: <b>{{ $registro->Serviço }}</b>
                                </div>
                                <div class="span4">
                                    Responsável: <b>{{ $registro->responsavel_consulta }}</b><br>
                                </div>
                            </div>

                            <div class="justfy-content-center registro-fase">
                                <center>
                                    @switch($registro->Fase)
                                        @case('Abertura da Solicitação')
                                            <img src="{{ asset('img/fases_solicitar_itbi_01.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Análise da Documentação')
                                        @case('Análise Documental')
                                            <img src="{{ asset('img/fases_solicitar_itbi_02.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cumprir Exigência')
                                        @case('Cumprir Exigências')
                                            <img src="{{ asset('img/fases_solicitar_itbi_03.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cadastro do CGM')
                                            <img src="{{ asset('img/fases_solicitar_itbi_04.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Emitir ITBI')
                                        @case('Pagamento Efetuado')
                                            <img src="{{ asset('img/fases_solicitar_itbi_05.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('expirada')
                                            <img src="{{ asset('img/fases_solicitar_itbi_06.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Cancelado')
                                            <img src="{{ asset('img/fases_solicitar_itbi_08.png') }}" alt="Fase" class="fase" />
                                            @break
                                    @endswitch
                                </center>

                                @if($registro->Fase != "Finalizado" && $registro->Fase != 'Concluído')
                                    @if($registro->responsavel == 'Portal')
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <br>resp: $registro->responsavel<br>
                                            <strong>Atenção!</strong> Esta solicitação requer que você faça uma interação: &nbsp;
                                            <a href="{{ route('formularioEdita', $registro->Chamado) }}" class="btn btn-blue">Editar
                                                Solicitação</a>
                                        </div>
                                    @endif
                                @endif



                                @if( $registro->Serviço == 'Solicitação de ITBI' && $registro->FINALIZADO == "andamento")
                                    @if( $registro->Etapa == "6")
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Atenção!</strong> A sua Guia de ITBI já está disponível. Clique no botão para baixar a guia: &nbsp;<br><br>
                                            <a href="{{ route('baixarguiaitbi', $registro->Chamado) }}" class="btn btn-blue">Baixar Guia de ITBI</a>
                                        </div>
                                    @elseif( $registro->Etapa == "7")
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Atenção!</strong> Existem pendências na sua solicitação: &nbsp;<br><br>
                                            <strong>Pendências:</strong> {{$registro->motivo}}<br><br>

                                            <a href="{{ route('editarItbi', $registro->Chamado) }}" class="btn btn-blue">Corrigir pendências</a>
                                        </div>
                                    @endif
                                @endif

                                @if($registro->motivo != "" && $registro->FINALIZADO != "andamento")
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Atenção!</strong><br>
                                    Esta solicitação foi finalizada e teve como conclusão:<br>
                                    Conclusão: <strong>{{$registro->Fase}}</strong><br>
                                    @if($registro->motivo != "")
                                        Motivo: {{$registro->motivo}}<br>
                                    @endif
                                </div>
                                @endif
                            </div>
                        @elseif( $registro->Serviço == 'Solicitar Licença Maternidade' || $registro->Serviço == 'Solicitar Licença Prêmio')
                            <div class="row registro-fase-topo">
                                <div class="span2">
                                    Chamado: <b>{{ $registro->Chamado }}</b>
                                </div>
                                <div class="span2">
                                    Data: <b>{{ date('d/m/Y', strtotime($registro->abertura)) }}</b>
                                </div>
                                <div class="span4">
                                    Serviço: <b>{{ $registro->Serviço }}</b>
                                </div>
                                <div class="span4">
                                    Responsável: <b>{{ $registro->responsavel_consulta }}</b><br>
                                </div>
                            </div>
                            <div class="justfy-content-center registro-fase">
                                <center>
                                    @switch($registro->Fase)
                                        @case('Abertura da Solicitação')
                                        @case('Abertura de Solicitação')
                                            <img src="{{ asset('img/fase_licenca_01.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Análise da Documentação')
                                        @case('Análise Documental')
                                            <img src="{{ asset('img/fase_licenca_02.png') }}" alt="Fase" class="fase" />
                                        @break
                                        @case('Licença Aprovada')
                                        @case('Licença Aprovada')
                                            <img src="{{ asset('img/fase_licenca_03.png') }}" alt="Fase" class="fase" />
                                        @break
                                        @case('Finalizado')
                                            <img src="{{ asset('img/fase_licenca_04.png') }}" alt="Fase" class="fase" />
                                        @break
                                    @endswitch
                                </center>
                                @if($registro->Fase != "Finalizado" && $registro->Fase != 'Concluído')
                                    @if($registro->responsavel == 'portal')
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <br>resp: {{ $registro->responsavel }}<br>
                                            <strong>Atenção!</strong> Esta solicitação requer que você faça uma interação: &nbsp;
                                            <a href="{{ route('formularioEdita', $registro->Chamado) }}" class="btn btn-blue">Editar Solicitação</a>
                                        </div>
                                    @endif
                                @endif
                                @if($registro->motivo != "" && $registro->FINALIZADO != "andamento")
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Atenção!</strong><br>
                                    Esta solicitação foi finalizada e teve como conclusão:<br>
                                    Conclusão: <strong>{{$registro->Fase}}</strong><br>
                                    @if($registro->motivo != "")
                                        Motivo: {{$registro->motivo}}<br>
                                    @endif
                                </div>
                                @endif
                            </div>
                        @elseif( $registro->Serviço == 'Solicitar Auxílio Transporte')
                            <div class="row registro-fase-topo">
                                <div class="span2">
                                    Chamado: <b>{{ $registro->Chamado }}</b>
                                </div>
                                <div class="span2">
                                    Data: <b>{{ date('d/m/Y', strtotime($registro->abertura)) }}</b>
                                </div>
                                <div class="span4">
                                    Serviço: <b>{{ $registro->Serviço }}</b>
                                </div>
                                <div class="span4">
                                    Responsável: <b>{{ $registro->responsavel_consulta }}</b><br>
                                </div>
                            </div>
                            <div class="justfy-content-center registro-fase">
                                <center>
                                    @switch($registro->Fase)
                                        @case('Abertura da Solicitação')
                                        @case('Abertura de Solicitação')
                                            <img src="{{ asset('img/fase_auxilio_01.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Análise da Documentação')
                                        @case('Análise Documental')
                                            <img src="{{ asset('img/fase_auxilio_02.png') }}" alt="Fase" class="fase" />
                                        @break
                                        @case('Auxílio Aprovado')
                                        @case('Auxílio Aprovado')
                                            <img src="{{ asset('img/fase_auxilio_03.png') }}" alt="Fase" class="fase" />
                                        @break
                                        @case('Finalizado')
                                            <img src="{{ asset('img/fase_auxilio_04.png') }}" alt="Fase" class="fase" />
                                        @break
                                    @endswitch
                                </center>
                                @if($registro->Fase != "Finalizado" && $registro->Fase != 'Concluído')
                                    @if($registro->responsavel == 'portal')
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <br>resp: {{ $registro->responsavel }}<br>
                                            <strong>Atenção!</strong> Esta solicitação requer que você faça uma interação: &nbsp;
                                            <a href="{{ route('formularioEdita', $registro->Chamado) }}" class="btn btn-blue">Editar Solicitação</a>
                                        </div>
                                    @endif
                                @endif
                                @if($registro->motivo != "" && $registro->FINALIZADO != "andamento")
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Atenção!</strong><br>
                                    Esta solicitação foi finalizada e teve como conclusão:<br>
                                    Conclusão: <strong>{{$registro->Fase}}</strong><br>
                                    @if($registro->motivo != "")
                                        Motivo: {{$registro->motivo}}<br>
                                    @endif
                                </div>
                                @endif
                            </div>
                        @elseif( $registro->Serviço == 'Alterar Lotação Servidor')
                            <div class="row registro-fase-topo">
                                <div class="span2">
                                    Chamado: <b>{{ $registro->Chamado }}</b>
                                </div>
                                <div class="span2">
                                    Data: <b>{{ date('d/m/Y', strtotime($registro->abertura)) }}</b>
                                </div>
                                <div class="span4">
                                    Serviço: <b>{{ $registro->Serviço }}</b>
                                </div>
                                <div class="span4">
                                    Responsável: <b>{{ $registro->responsavel_consulta }}</b><br>
                                </div>
                            </div>
                            <div class="justfy-content-center registro-fase">
                                <center>
                                    @switch($registro->Fase)
                                        @case('Abertura da Solicitação')
                                        @case('Abertura de Solicitação')
                                            <img src="{{ asset('img/fase_lotacao_01.png') }}" alt="Fase" class="fase" />
                                            @break
                                        @case('Análise da Documentação')
                                        @case('Análise Documental')
                                            <img src="{{ asset('img/fase_lotacao_02.png') }}" alt="Fase" class="fase" />
                                        @break
                                        @case('Alteração Aprovada')
                                        @case('Alteração Aprovada')
                                            <img src="{{ asset('img/fase_lotacao_03.png') }}" alt="Fase" class="fase" />
                                        @break
                                        @case('Finalizado')
                                            <img src="{{ asset('img/fase_lotacao_04.png') }}" alt="Fase" class="fase" />
                                        @break
                                    @endswitch
                                </center>
                                @if($registro->Fase != "Finalizado" && $registro->Fase != 'Concluído')
                                    @if($registro->responsavel == 'portal')
                                        <br>
                                        <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <br>resp: {{ $registro->responsavel }}<br>
                                            <strong>Atenção!</strong> Esta solicitação requer que você faça uma interação: &nbsp;
                                            <a href="{{ route('formularioEdita', $registro->Chamado) }}" class="btn btn-blue">Editar Solicitação</a>
                                        </div>
                                    @endif
                                @endif
                                @if($registro->motivo != "" && $registro->FINALIZADO != "andamento")
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Atenção!</strong><br>
                                    Esta solicitação foi finalizada e teve como conclusão:<br>
                                    Conclusão: <strong>{{$registro->Fase}}</strong><br>
                                    @if($registro->motivo != "")
                                        Motivo: {{$registro->motivo}}<br>
                                    @endif
                                </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    @endsection
