<div style="background-color: #F4F4F4; margin-bottom: -20px;">
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 text-center my-5 pb-5 pt-3">
                <h1 class="barra_title">Principais Serviços</h1>
            </div>
            
            <div class="cidadao col-lg-12">
                <h3 class="servicos-title mb-4">Serviços Cidadão</h3>
            </div>
            
            <!-- CIDADÃO -->
            @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
                
                <div class="col-lg-3">
                    <a href="{{ route('cadastroCGM' ) }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/cidadao2.png') }}" alt="Icone Cidadão" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Cidadão</h4>
                            <p>Cadastro de Cidadão</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>
            
                <div class="col-lg-3">
                    <a href="{{ route('certidaoITBI') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/cidadao2.png') }}" alt="Icone Cidadão" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Cidadão</h4>
                            <p>Certidão de Quitação de ITBI</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('certidaoNumeroPorta') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/cidadao2.png') }}" alt="Icone Cidadão" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Cidadão</h4>
                            <p>Certidão de Numeração Predial Oficial</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('certidaoNegativa') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/cidadao2.png') }}" alt="Icone Cidadão" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Cidadão</h4>
                            <p>Certidão de Negativa de Imóveis</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('certidaoValorVenal') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/cidadao2.png') }}" alt="Icone Cidadão" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Cidadão</h4>
                            <p>Declaração de Valor Venal de Imóveis</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route( 'boletosTaxas') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/cidadao2.png') }}" alt="Icone Cidadão" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Cidadão</h4>
                            <p>Boletos de Taxas</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            <div class="col-lg-3">
                <a href="{{ url('servicos/1/4') }}" class="text-dark no-underline">
                    <div class="servicos-home text-center shadow-sm mb-5">
                        <img src="{{ asset('img/icones/cidadao2.png') }}" alt="Icone Cidadão" 
                            title="Icone Cidadão" width="64px" />

                        <h4>Cidadão</h4>
                        <p>Retire aqui seu IPTU 2020</p>

                        <div class="btn-acessar btn btn-danger d-none shadow-sm">
                            <i class="fa fa-link"></i> Acessar
                        </div>
                    </div>
                </a>
            </div>
            <!-- FIM CIDADÃO COLUNA -->
            

            <!-- EMPRESA COLUNA -->
            @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
                <div class="cidadao col-lg-12">
                    <h3 class="servicos-title mb-4 mt-4">Serviços Empresa</h3>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('cadastroCGM') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/empresa2.png') }}" alt="Icone Empresa" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Empresa</h4>
                            <p>Cadsatro Empresarial</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('certidaoITBI') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/empresa2.png') }}" alt="Icone Empresa" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Empresa</h4>
                            <p>Certidão de Quitação de ITBI</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('certidaoNumeroPorta' ) }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/empresa2.png') }}" alt="Icone Empresa" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Empresa</h4>
                            <p>Certidão de Numeração Predial Oficial</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('certidaoNegativa') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/empresa2.png') }}" alt="Icone Empresa" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Empresa</h4>
                            <p>Certidão de Negativa de Imóveis</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('certidaoValorVenal') }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/empresa2.png') }}" alt="Icone Empresa" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Empresa</h4>
                            <p>Declaração de Valor Venal de Imóveis</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3">
                    <a href="{{ route('boletosTaxas' ) }}" class="text-dark no-underline">
                        <div class="servicos-home text-center shadow-sm mb-5">
                            <img src="{{ asset('img/icones/empresa2.png') }}" alt="Icone Empresa" 
                                title="Icone Cidadão" width="64px" />

                            <h4>Empresa</h4>
                            <p>Boletos de Taxas</p>

                            <div class="btn-acessar btn btn-danger d-none shadow-sm">
                                <i class="fa fa-link"></i> Acessar
                            </div>
                        </div>
                    </a>
                </div>
                <!-- FIM EMPRESA COLUNA -->
            @endif
        </div>
    </div>
</div>
