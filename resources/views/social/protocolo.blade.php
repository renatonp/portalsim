@extends('layouts.tema01')

@section('content')

<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('PROGRAMA DE AMPARO AO TRABALHADOR ') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('PROGRAMA DE AMPARO AO TRABALHADOR ') }}</li>
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
                                        <h2>Benefício Solicitado</h2>
                                    </center>
                                    <p>
                                        <strong>Atenção:</strong><br>
                                        Guarde o número do protocolo, ele será solicitado para fazer a consulta do andamento desta solicitação.<br>
                                        <br>
                                        <br>
                                        Nome: <b>{{$nome}}</b><br>
                                        CPF: <b>{{$cpf}}</b><br><br>
                                        Protocolo: 
                                        <center>
                                        <h3>{{$protocolo}}</h3>
                                        </center>
                                    </p>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="span3 align-left">
                                <a href="{{ route('PAT', 1 )  }}">
                                    <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                                        {{ __('Finalizar') }}
                                    </button>
                                    <a>
                            </div>
                            <div class="span8 align-right">
                                <form method="POST" action="{{ route('imprimirprotocolo') }}" id="frmConsultarAuxilio">
                                    @csrf
                                    <input id="protocolo" type="hidden" name="protocolo" value="{{ $protocolo }}">
                                    <button type="submit" class="btn btn-warning e_wiggle align-right" id="autenticar">
                                        {{ __('Imprimir Protocolo') }}
                                    </button>
                                </form>
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