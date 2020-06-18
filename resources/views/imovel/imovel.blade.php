@extends('layouts.tema_principal')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>
                            <?php //dd($registros); ?>
                            <i class="fa fa-home"></i> 
                            
                            Imóvel <small>(mátricula: {{ $registros->i_matricula }})</small>
                        </h3>
                    </div>
                    
                    <div class="card-body">
                        @foreach($servicosImovel as $view => $descricao)

                            <div id="accordion">
                                <div class="card mb-3">
                                    <a class="card-link no-underline text-dark" data-toggle="collapse" href="#service{{ $loop->iteration }}">
                                        <div class="card-header">
                                            <i class="fa fa-arrow-down arrow-red"></i> 
                                            {{ $descricao }}
                                        </div>
                                    </a>
                                    <div id="service{{ $loop->iteration }}" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            @include($view)
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col-lg-12">
                <a href="{{ route('consultaInformacoes') }}" class="btn btn-primary mt-3">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
                <a href="{{ route('imprimeInformacoes', $registros->i_matricula) }}" class="btn btn-success mt-3">
                    <i class="fa fa-print"></i> Imprimir Boletim
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
