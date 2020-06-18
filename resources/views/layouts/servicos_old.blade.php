<section id="servicos">
    <div class="container">
        <!-- divider -->
        <div class="row">
            <div class="span12">
                <div class="solidline">
                </div>
            </div>
        </div>
        <!-- end divider -->
        <div class="row">
            <div class="span12">
                <h4 class="heading">Principais <strong>Serviços</strong></h4>
                <div class="row">
                    <section id="projects">
                        {{-- <ul id="thumbs" class="portfolio"> --}}
                            {{--
                            @inject('servicos', 'App\Services\ServicosService')
                            @foreach ($servicos->servicos_qtd() as $servico)
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('servicos', $servico->guia ) }}">
                            <span class="overlay-img"></span>
                            <span class="overlay-img-thumb font-icon-plus"></span>
                            </a>
                            <!-- Thumb Image and Description -->
                            <div class="aligncenter servicos">
                                <p>

                                    <i class="fa {{$servico->icone}} fa-3x"></i>

                                </p>
                                <h6>{{$servico->guia}}</h6>
                                <strong>{{$servico->servico}}</strong>
                                <br>
                                {{$servico->desc_servico}}
                            </diV>
                            </li>

                            @endforeach --}}




{{--
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="#">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/passaporte2.png" alt="Icone Passaporte"
                                            title="Icone Passaporte" width="64px" />
                                    </p>
                                    <h6>Passaporte Universitário</h6>
                                    <strong>Estudante</strong>
                                    <br>
                                    Solicitação de bolsa de estudos para universidades participantes do programa
                                </diV>
                            </li>

                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="#">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cgm.png" alt="Icone CGM" title="Icone CGM" width="64px" />
                                    </p>
                                    <h6>Cadastro Geral Município</h6>
                                    <strong>Cadastro Geral do Município</strong>
                                    <br>
                                </diV>
                            </li>

                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="#">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Empresa" title="Icone Empresa"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Solicitação de ITBI</strong>
                                    <br>
                                </diV>
                            </li>

                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="#">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cidadao2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Cidadão</h6>
                                    <strong>Solicitação de ITBI</strong>
                                    <br>
                                </diV>
                            </li>
                        </ul> --}}

                        {{--  Segunda Linha  --}}
                        <ul id="thumbs" class="portfolio">

                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoNegativaPositiva' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Certidão Negativa de Débitos de Empresas</strong>
                                    <br>
                                </diV>
                            </li>


                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoAutenticacao' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Verifica Autenticidade das Certidões</strong>
                                    <br>
                                </diV>
                            </li>



                            @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('cadastroCGM' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cidadao2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Cidadão</h6>
                                    <strong>Cadastro do Cidadão</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoITBI' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cidadao2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Cidadão</h6>
                                    <strong>Certidão de Quitação de ITBI</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoNumeroPorta' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cidadao2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Cidadão</h6>
                                    <strong>Certidão de Numeração Predial Oficial</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoNegativa' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cidadao2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Cidadão</h6>
                                    <strong>Certidão de Negativa de Imóveis</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoValorVenal' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cidadao2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Cidadão</h6>
                                    <strong>Declaração de Valor Venal de Imóveis</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) <= 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route( 'boletosTaxas' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cidadao2.png" alt="Icone Cidadão" title="Icone Cidadão"
                                            width="64px" />
                                    </p>
                                    <h6>Cidadão</h6>
                                    <strong>Boletos de Taxas</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif


                            {{-- EMPRESA --}}

                            @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('cadastroCGM' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Empresa" title="Icone Empresa"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Cadastro Empresarial</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoITBI' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Empresa" title="Icone Empresa"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Certidão de Quitação de ITBI</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoNumeroPorta' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Empresa" title="Icone Empresa"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Certidão de Numeração Predial Oficial</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoNegativa' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Empresa" title="Icone Empresa"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Certidão de Negativa de Imóveis</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('certidaoValorVenal' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Empresa" title="Icone Empresa"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Declaração de Valor Venal de Imóveis</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif



                            @if( !Auth::user() || strlen(Auth::user()->cpf) > 14 )
                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ route('boletosTaxas' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/empresa2.png" alt="Icone Empresa" title="Icone Empresa"
                                            width="64px" />
                                    </p>
                                    <h6>Empresas</h6>
                                    <strong>Boletos de Taxas</strong>
                                    <br>
                                </diV>
                            </li>
                            @endif

                            <li class="item-thumbs span3 design" data-id="id-0" data-type="web">
                                <a class="hover-wrap" href="{{ url('servicos/1/4' ) }}">
                                    <span class="overlay-img"></span>
                                    <span class="overlay-img-thumb font-icon-plus"></span>
                                </a>
                                <!-- Thumb Image and Description -->
                                <div class="aligncenter servicos">
                                    <p>
                                        <img src="img/icones/cidadao2.png" alt="Icone IPTU" title="Icone IPTU"
                                            width="64px" />
                                    </p>
                                    <h6>IPTU</h6>
                                    <strong>Retire aqui seu IPTU 2020.</strong>
                                    <br>
                                </diV>
                            </li>
                        </ul>



                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
