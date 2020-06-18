<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
            <div class="span3">
                <a href="{{ route('servicos', 1 ) }}">
                    <div class="box aligncenter">
                        <div class="aligncenter icon">
                            <img src="img/icones/cidadao.png" alt="Icone Cidadão" title="Icone Cidadão"
                                width="70px" />
                        </div>
                        <div class="text">
                            <h6>CIDADÃO</h6>
                        </div>
                        <div>
                            Nesta área do Portal SIM, você pode administrar os serviços oferecidos pela Prefeitura de Maricá.
                        </div>
                    </div>
                </a>
            </div>
            @endif

            @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
            <div class="span3">
                <a href="{{ route('servicos', 2 ) }}">
                    <div class="box aligncenter">
                        <div class="aligncenter icon">
                            <img src="img/icones/empresa.png" alt="Icone Empresa" title="Icone Empresa"
                                width="70px" />
                        </div>
                        <div class="text">
                            <h6>EMPRESA</h6>
                        </div>
                        <div>
                            Nesta área do Portal SIM, você pode administrar os serviços oferecidos pela Prefeitura de Maricá à sua empresa, bem como as pessoas autorizadas a responder por ela.
                        </div>
                    </div>
                </a>
            </div>
            @endif
            <div class="span3">
                <a href="https://www.marica.rj.gov.br/2018/01/04/iptu/">
                    <div class="box aligncenter">
                        <div class="aligncenter icon">
                            <img src="img/icones/iptu.png" alt="Icone IPTU" title="Icone IPTU"
                                width="70px" />
                        </div>
                        <div class="text">
                            <h6>IPTU</h6>
                        </div>
                        <div>
                        Retire aqui o seu IPTU 2020. COTA ÚNICA com desconto de 15% para o vencimento até 28/02/2020.
                        </div>
                    </div>
                </a>
            </div>
            <div class="span3">
                <a href="{{ route('PAT', 1 ) }}">
                    <div class="box aligncenter">
                        <div class="aligncenter icon">
                            <img src="img/icones/corona.png" alt="Icone Coronavírus" title="Icone Coronavírus"
                                width="70px" />
                        </div>
                        <div class="text">
                            <h6>PAT</h6>
                        </div>
                        <div>
                            Programa de Amparo ao Trabalhador deverá atender aqueles trabalhadores formais, informais, autônomos e MEI prejudicados pela pandemia.
                        </div>
                    </div>
                </a>
            </div>
            {{-- <div class="span3">
                <a href="{{ route('servicos', 5 ) }}">
                    <div class="box aligncenter">
                        <div class="aligncenter icon">
                            <img src="img/icones/servidor.png" alt="Icone Servidor" title="Icone Servidor"
                                width="70px" />
                        </div>
                        <div class="text">
                            <h6>SERVIDOR</h6>
                        </div>
                    </div>
                </a>
            </div>             --}}
            {{-- <div class="span2">
                <a href="{{ route('servicos', 4 ) }}">
                    <div class="box aligncenter">
                        <div class="aligncenter icon">
                            <img src="img/icones/passaporte.png" alt="Icone Passaporte Universitário"
                                title="Icone Passaporte Universitário" width="70px" />
                        </div>
                        <div class="text">
                            <h6>PASSAPORTE UNIVERSITÁRIO</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="span2">
                <a href="{{ route('servicos', 5 ) }}">
                    <div class="box aligncenter">
                        <div class="aligncenter icon">
                            <img src="img/icones/servidor.png" alt="Icone Servidor" title="Icone Servidor"
                                width="70px" />
                        </div>
                        <div class="text">
                            <h6>SERVIDOR</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="span2">
                <a href="{{ route('servicos', 3 ) }}">
                    <div class="box aligncenter">
                        <div class="aligncenter icon">
                            <img src="img/icones/ouvidoria.png" alt="Icone Ouvidoria" title="Icone Ouvidoria"
                                width="70px" />
                        </div>
                        <div class="text">
                            <h6>OUVIDORIA</h6>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>
    </div>
</section>
