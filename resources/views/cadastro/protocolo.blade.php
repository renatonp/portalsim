@extends('layouts.tema01')

@section('content')

<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    @if($vencimentoIPTU == 0)
                    <h2>{{ __('Cadastrar / Atualizar CGM') }}</h2>
                    @else
                    <h2>{{ __('ALTERAR VALIDADE DE IPTU') }}</h2>
                    @endif
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    @if($vencimentoIPTU == 0)
                    <li class="active">{{ __('Cadastrar / Atualizar CGM') }}</li>
                    @else
                    <li class="active">{{ __('ALTERAR VALIDADE DE IPTU') }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row formrow">
                            <div class="controls span2 form-label">
                            </div>
                            
                            <div class="span7">

                                <div class="alert alert-info" role="alert">
                                    <center>
                                        <h2>Sucesso</h2>
                                    </center>
                                    <p>
                                        <strong>Atenção:</strong> A sua solicitação foi efetuada com sucesso.<br>
                                        <br>
                                        <br>
                                        @if(strlen($cpf)>14)
                                            Razão Social: 
                                        @else
                                            Nome: 
                                        @endif
                                        <b>{{$nome}}</b><br>
                                        @if(strlen($cpf)>14)
                                            CNPJ: 
                                        @else
                                            CPF: 
                                        @endif
                                        
                                        <b>{{$cpf}}</b><br><br>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="span3 align-left">
                                @if($vencimentoIPTU == 0)
                                    <a href="{{ route('servicos', [1 ,1 ] )  }}">
                                @else
                                    <a href="{{ route('servicos', [1 ,4 ] )  }}">
                                @endif
                                    <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                                        {{ __('Finalizar') }}
                                    </button>
                                    <a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
</section>
@endsection

@section('post-script')

<script type="text/javascript">
    jQuery(document).ready(function(){
        $("#pat_cpf").mask("000.000.000-00");
        $("#dtnasc").mask("00/00/0000");
    });
    
    var dependentes = $('#dependentes').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "scrollY": 150,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
    });
    
    var patDocumentos = $('#patDocumentos').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "scrollY": 150,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
    });
</script>
@endsection