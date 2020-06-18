@extends('layouts.tema_principal')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>
                            <i class="fa fa-home"></i> Averbação de Imóveis
                        </h3>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="" autocomplete="off">
                            @csrf

                            <div class="alert alert-info">
                                <h3 class="mb-3">Formulário destinado a transações por meio de ITBI (Inter vivos).</h3>
                                <p>
                                    <a href="{{ url('/download/RGI_fundo_branco.pdf') }}" target="_blank">
                                        Clique aqui
                                    </a> 
                                    
                                    para identificar no Registro do Imóvel no Cartório (RGI) onde se encontram as informações para preenchimento do formulário abaixo.
                                </p>

                                <p class="alert alert-danger">
                                    <b>IMPORTANTE:</b> 
                                
                                    Preencher os dados com cuidado, pois quaisquer divergências entre os dados cadastrados e o 
                                    documento apresentado serão analisadas e apontadas.
                                </p>
                            </div>
                        
                            <div id="accordion">
                                
                                <div class="card mb-3">
                                    <a class="card-link no-underline text-dark" data-toggle="collapse" href="#averbacao">
                                        <div class="card-header">
                                            <i class="fa fa-arrow-down arrow-red"></i> Averbação
                                        </div>
                                    </a>
                                    <div id="averbacao" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            @include('imovel.averbacao.form_averbacao')
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div id="accordion">
                                <div class="card mb-3">
                                    <a class="card-link no-underline text-dark" data-toggle="collapse" href="#adquirentes">
                                        <div class="card-header">
                                            <i class="fa fa-arrow-down arrow-red"></i> Adquirente
                                        </div>
                                    </a>
                                    <div id="adquirentes" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            @include('imovel.averbacao.form_adquirentes')
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="accordion">
                                <div class="card mb-3">
                                    <a class="card-link no-underline text-dark" data-toggle="collapse" href="#documentos">
                                        <div class="card-header">
                                            <i class="fa fa-arrow-down arrow-red"></i> Documentação em Anexo
                                        </div>
                                    </a>
                                    <div id="documentos" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            @include('imovel.averbacao.form_documentos')
                                        </div>
                                    </div>
                                </div>
                            </div>

							<div class="row">
								<div class="col-lg-6">
									<a href="{{ route('servicos', 1) }}" class="btn btn-primary mt-3 w-100">
										<i class="fa fa-arrow-left"></i> Voltar
									</a>
								</div>

								<div class="col-lg-6">
									<button class="btn btn-success mt-3 w-100">Solicitar <i class="fa fa-send"></i></button>
								</div>
							</div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
