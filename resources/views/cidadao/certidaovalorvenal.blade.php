@extends('layouts.tema_principal')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col-lg-12">
                <h2 class="mb-4"><i class="fa fa-file-o"></i> Certidão de Valor Venal</h2>

                <div class="card">
                    <div class="card-header">
                        <h4>Suas Informações</h4>
                    </div>

                    <div class="card-body">
                        <p><b>{{ (strlen(Auth::user()->cpf) > 14 ? 'CNPJ:' : 'CPF:') }}</b> {{ Auth::user()->cpf }}</p>
                        <p><b>NOME:</b> {{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col d-flex justify-content-center mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Imóveis</h4>
                    </div>

                    <div class="card-body">
                        @foreach ($registros->aMatriculasCgmEncontradas as $registro)
                            <div class="callout-red shadow-sm mb-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p><b>Mátricula:</b> {{ $registro->matricula }}</p>
                                        <p><b>Tipo:</b> {{ $registro->tipo }}</p>
                                        <p><b>Bairro:</b> {{ convert_accentuation($registro->bairro) }}</p>
                                        <p><b>Logradouro:</b> {{ convert_accentuation($registro->logradouro) }}</p>
                                    </div>

                                    <div class="col-lg-6">
                                        <p><b>Número:</b> {{ $registro->numero }}</p>
                                        <p><b>Complemento:</b> {{ convert_accentuation($registro->complemento) }}</p>
                                        <p><b>Planta/Quadra/Lote:</b> {{ convert_accentuation($registro->planta) }} / {{ $registro->quadra }} / {{ $registro->lote }}</p>
                                    </div>

                                    <div class="col-lg-12">
                                        <a href="{{ route('certidaoValorVenalImprimir', $registro->matricula) }}"
                                            class="btn btn-sm btn-outline-danger d-block">
                                            <span style="font-size: 15px;">
                                                Imprimir <i class="fa fa-print"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <a href="{{ route('servicos', ['guia' => get_guia_services(), 'aba' => 'certidoes']) }}" 
                            class="btn btn-primary">
                            
                            <i class="fa fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
                <div class="text-center">
                    {!! $paginator !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
