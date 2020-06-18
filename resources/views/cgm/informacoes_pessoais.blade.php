<div class="accordion-inner">
    <form method="POST" action="{{ route('cgm_informacoes_pessoais') }}" id="infoPessoal">
        @csrf
        @php
            $infoPessoal = false;
        @endphp


        {{-- Total de processos = {{count($processos)}} - {{ $maxProcesso }}<br> --}}

        <input id="cgm" type="hidden" name="cgm" value="{{ $cgm->cgm }}">
        {{-- CPF/CNPJ --}}
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                    @if( strlen($cgm->aCgmPessoais->z01_cgccpf) > 11 )
                        {{ __('CNPJ') }}
                    @else
                        {{ __('CPF') }}
                    @endif
                </label>
            </div>
            <div class="span2">
                <input id="servidor" type="hidden" class="form-input" name="servidor" value="{{ $serv }}" readonly>
                <input maxlength="20" id="cpf" type="text" class="form-input" name="cpf" value="{{ $cgm->aCgmPessoais->z01_cgccpf }}" readonly>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            {{-- Última Atualização --}}
            <div class="controls span2 form-label">
                <label for="ultalt" class="col-md-4 col-form-label text-md-right">
                    {{ __('Última Atualização') }}
                </label>
            </div>

            <div class="span2">
                <input id="ultalt" type="text" class="form-input" name="ultalt" value="{{ \Carbon\Carbon::parse($cgm->aCgmPessoais->z01_ultalt)->format('d/m/Y')  }}" readonly>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="name" class="col-md-4 col-form-label text-md-right">
                    @if( strlen($cgm->aCgmPessoais->z01_cgccpf) > 11 )
                        {{-- Dados Pessoa Jurídica --}}
                        {{ __('Razão Social') }}
                    @else
                        {{-- Dados Pessoa Física --}}
                        {{ __('Nome') }}
                    @endif
                </label>
            </div>

            <div class="span7">
                <input id="nameOld" type="hidden" name="nameOld" value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgm->aCgmPessoais->z01_nome)))  }}">
                <input maxlength="40" id="name" type="text" class="form-input"  name="name" value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgm->aCgmPessoais->z01_nome)))  }}" readonly>
            </div>
        </div>
        
        @if( strlen($cgm->aCgmPessoais->z01_cgccpf) > 11 )
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="nomeFantasia" class="col-md-4 col-form-label text-md-right">
                        {{ __('Nome Fantasia') }}
                    </label>
                </div>

                <div class="span7">
                    <input id="nomeFantasiaOld" type="hidden" name="nomeFantasiaOld" value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmJuridico->z01_nomefanta))) }}">
                    <input maxlength="40" id="nomeFantasia" type="text" class="form-input"  name="nomeFantasia" value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmJuridico->z01_nomefanta))) }}" readonly>
                </div>
                <div class="span1">
                    @if($nomeFanta)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
            </div>

            {{-- INSCRIÇÃO / NIRE --}}
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="iest" class="col-md-4 col-form-label text-md-right">
                        {{ __('Inscrição Estadual') }}
                    </label>
                </div>
                <div class="span2">
                    <input id="iestOld" type="hidden" class="form-input" name="iestold" value="{{ $cgm->aCgmJuridico->z01_incest }}">
                    <input maxlength="15" id="iest" type="text" class="form-input" name="iest" value="{{ $cgm->aCgmJuridico->z01_incest }}" readonly>
                </div>
                <div class="span1">
                    @if($inscrEst)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
                {{-- Separação --}}
                <div class="controls span1 form-label">
                    <label for="" class="col-md-4 col-form-label text-md-right">
                        &nbsp;
                    </label>
                </div>

                {{-- Nire --}}
                <div class="controls span1 form-label">
                    <label for="nire" class="col-md-4 col-form-label text-md-right">
                        {{ __('NIRE') }}
                    </label>
                </div>

                <div class="span2">
                    <input id="nireOld" type="hidden" name="nireOld" value="{{ $cgm->aCgmJuridico->z08_nire }}">
                    <input maxlength="15" id="nire" type="text" class="form-input" name="nire" value="{{ $cgm->aCgmJuridico->z08_nire  }}" readonly>
                </div>
                <div class="span1">
                    @if($nire)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
            </div>

            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="contato" class="col-md-4 col-form-label text-md-right">
                        {{ __('Contato') }}
                    </label>
                </div>

                <div class="span7">
                    <input id="contatoOld" type="hidden" name="contatoOld" value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmJuridico->z01_contato))) }}">
                    <input maxlength="30" id="contato" type="text" class="form-input" name="contato" 
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmJuridico->z01_contato))) }}" readonly>
                </div>
                <div class="span1">
                    @if($contato)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
            </div> 
            {{-- Fim dados Pessoa Jurídica --}}
        @else  
            {{-- Dados Pessoa Física --}}
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="mae" class="col-md-4 col-form-label text-md-right">
                        {{ __('Mãe') }}
                    </label>
                </div>

                <div class="span7">
                    <input id="maeOld" type="hidden" name="maeOld"
                        value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmPessoais->z01_mae))) }}">
                    <input maxlength="40" id="mae" type="text" class="form-input" name="mae"
                        value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmPessoais->z01_mae))) }}" readonly>

                    @if ($errors->has('mae'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('mae') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="span1">
                    @if($mae)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
            </div>

            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="pai" class="col-md-4 col-form-label text-md-right">
                        {{ __('Pai') }}
                    </label>
                </div>

                <div class="span7">
                    <input id="paiOld" type="hidden" name="paiOld"
                        value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmPessoais->z01_pai))) }}">
                    <input maxlength="40" id="pai" type="text" class="form-input" name="pai"
                        value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmPessoais->z01_pai))) }}" readonly>

                    @if ($errors->has('pai'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('pai') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="span1">
                    @if($pai)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
            </div>

            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="dtnasc" class="col-md-4 col-form-label text-md-right">
                        {{ __('Data de Nascimento') }}
                    </label>
                </div>

                <div class="span2">
                    <input id="dtnascOld" type="hidden" name="dtnascOld"
                        value="{{ \Carbon\Carbon::parse($cgm->aCgmPessoais->z01_nasc)->format('d/m/Y') }}">
                    <input id="dtnasc" type="text" class="form-input" name="dtnasc"
                        @if($cgm->aCgmPessoais->z01_nasc=="")
                            value=""
                        @else
                            value="{{ \Carbon\Carbon::parse($cgm->aCgmPessoais->z01_nasc)->format('d/m/Y') }}"
                        @endif
                    readonly>
                    @if ($errors->has('dtnasc'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('dtnasc') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="span1">
                    @if($nascimento)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
                {{-- Separação --}}

                <div class="controls span2 form-label">
                    <label for="estCivil" class="col-md-4 col-form-label text-md-right">
                        {{ __('Estado Civil') }}
                    </label>
                </div>
            
                <div class="span2">
                    <input id="estCivilOld" type="hidden" name="estCivilOld" value="{{ $cgm->aCgmPessoais->z01_estciv }}">
                    <select name="estCivil" id="estCivil"
                        style="width:100%; {{ $estadoCivil==true ? ' background-color: #5C9CC7; color: #555555;' : '' }}" disabled>
                        <option value="1" {{ $cgm->aCgmPessoais->z01_estciv == "1" ? "selected" : "" }}>Solteiro</option>
                        <option value="2" {{ $cgm->aCgmPessoais->z01_estciv == "2" ? "selected" : "" }}>Casado</option>
                        <option value="3" {{ $cgm->aCgmPessoais->z01_estciv == "3" ? "selected" : "" }}>Viúvo</option>
                        <option value="4" {{ $cgm->aCgmPessoais->z01_estciv == "4" ? "selected" : "" }}>Divorciado</option>
                        <option value="5" {{ $cgm->aCgmPessoais->z01_estciv == "5" ? "selected" : "" }}>Separado Consensual
                        </option>
                        <option value="6" {{ $cgm->aCgmPessoais->z01_estciv == "6" ? "selected" : "" }}>Separado Judicial
                        </option>
                        <option value="7" {{ $cgm->aCgmPessoais->z01_estciv == "7" ? "selected" : "" }}>União Estavel
                        </option>
                    </select>
                </div>
                <div class="span1">
                    @if($estadoCivil)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
            </div>
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="nacionalidade" class="col-md-4 col-form-label text-md-right">
                        {{ __('Nacionalidade') }}
                    </label>
                </div>

                <div class="span2">
                    <input id="nacionalidadeOld" type="hidden" name="nacionalidadeOld" value="{{ $cgm->aCgmPessoais->z01_nacion }}">
                    <select name="nacionalidade" id="nacionalidade"
                        style="width:100%;"
                        disabled>
                        <option value="1" {{ $cgm->aCgmPessoais->z01_nacion == "1" ? "selected" : "" }}>Brasileira</option>
                        <option value="2" {{ $cgm->aCgmPessoais->z01_nacion == "2" ? "selected" : "" }}>Estrangeira</option>
                    </select>
                </div>
                <div class="span1">
                    @if($nacionalidade)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>

                {{-- Separação --}}
                <div class="controls span1 form-label">
                    <label for="" class="col-md-4 col-form-label text-md-right">
                        &nbsp;
                    </label>
                </div>

                <div class="controls span1 form-label">
                    <label for="sex" class="col-md-4 col-form-label text-md-right">
                        {{ __('Sexo') }}
                    </label>
                </div>

                <div class="span2">
                    <input id="sexOld" type="hidden" name="sexOld" value="{{ $cgm->aCgmPessoais->z01_sexo }}">
                    <select id="sex" class="form-input" name="sex"
                        disabled>
                        <option value="M" {{ $cgm->aCgmPessoais->z01_sexo == "M" ? "selected" : "" }}>Masculino</option>
                        <option value="F" {{ $cgm->aCgmPessoais->z01_sexo == "F" ? "selected" : "" }}>Feminino</option>
                    </select>
                </div>
                <div class="span1">
                    @if($sexo)
                        @php
                            $infoPessoal = true;
                        @endphp
                        <img src="{{ asset('img/icon-question.png') }}" title="A informação alterada está em análise para aprovação/reprovação" />
                    @endif
                </div>
            </div>
        @endif

        @isset($documentosPendentes)
            @foreach ($documentosPendentes as $documento)
                @if($documento["aba"] == "Informações Pessoais" || $documento["aba"] == "Informações Empresariais")
                    <div class="alert alert-error" role="alert">
                        <p>
                            <strong>Atenção Documentos pendentes:</strong><br>
                            Para a análise da sua solicitação, é necessário que os seguintes documentos sejam enviados:<br>
                            Processo:<br>
                            @foreach ($documentosPendentes as $doc)
                                @if($doc["aba"] == "Informações Pessoais" || $doc["aba"] == "Informações Empresariais")
                                    {{$doc["processo"]}} <br>
                                @endif
                            @endforeach
                            Documentos:<br> 
                            @if($documento["aba"] == "Informações Pessoais" || $contato)
                            - Documento de Identidade<br>
                            @endif
                            @if($documento["aba"] == "Informações Empresariais")
                            - Contrato Social<br>
                            @endif
                            <br>
                            Para enviar os documentos, utilize a aba "<b>Documentos em Anexo</b>", informe no número do processo e faça o envio do documento.
                        </p>
                    </div>
                    @break;
                @endif
            @endforeach
        @endisset

        @if( count($documentosPendentes) == 0 )
            <div class="alert" role="alert">
                <p>
                <strong>Atenção:</strong><br>
                Para alterar as informações cadastrais é necessário enviar os seguintes documentos:<br>
                - CPF ou Documento de Identidade<br>
                @if(strlen($cgm->aCgmPessoais->z01_cgccpf) > 11)
                - Contrato Social<br>
                @endif
                <br>
                Para enviar os documentos, utiize a aba "<b>Documentos em Anexo</b>", informe no número do processo e faça o envio do documento.
            </div>
        @endif

        @isset($infoPessoal)
            @if($infoPessoal)
                <div class="alert alert-info" role="alert">
                    <p>
                        <strong>Atenção:</strong><br>
                        Você possui uma solicitação de alteração de informações pendente. As informações
                        alteradas estão em análise para aprovação/reprovação.<br>
                    </p>
                    <center>
                        <a href="{{ route('acompanhamento') }}">
                            <button type="button" class="btn btn-theme e_wiggle">
                                {{ __('Consultar Andamento') }}
                            </button>
                        </a>
                    </center>
                </div>
            @endif
        @endisset

        @if(count($processos) >= $maxProcesso)
            <div class="alert" role="alert">
                <p>
                    <strong>Atenção:</strong><br>
                    Você possui diversos processos em análise, aguarde a conclusão destes para efetuar novas solicitações.<br>
                </p>
            </div>
        @endif


        <div class="row">
            <div class="span3 align-left">
                <button type="button" value='1' class="btn btn-theme e_wiggle align-right" id="btn_altera_info_pess"
                {{count($processos) >= $maxProcesso?"disabled":""}}>
                    {{ __('Alterar Dados') }}
                </button>
            </div>
            <div class="span8 align-left">
                <button type="button" class="btn btn-warning e_wiggle align-right" id="btn_gravar_info_pess" disabled>
                    {{ __('Gravar Dados') }}
                </button>
            </div>
        </div>
    </form>
</div>
