<div class="accordion-inner">
    <form method="POST" action="{{ route('cgm_endereco') }}" id="formEndereco">
        @csrf
        @php
        $infoEndereco = false;
        @endphp
        <input id="servidorEnd" type="hidden" class="form-input" name="servidor" value="{{ $serv }}" readonly>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="morador" class="col-md-4 col-form-label text-md-right">
                    Mora no Município
                </label>
            </div>

            <div class="span2">
                <select id="morador1" class="form-input{{ $errors->has('morador') ? ' is-invalid' : '' }}"
                    name="morador1" disabled>
                    <option value="0" {{ $end1->endereco->iMunicipio == "0" ? "selected" : "" }}>SIM</option>
                    <option value="1" {{ $end1->endereco->iMunicipio == "1" ? "selected" : "" }}>NÃO</option>
                </select>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span1 form-label">
                <label for="cep1" class="col-md-4 col-form-label text-md-right">
                    {{ __('CEP') }}
                </label>
            </div>

            <div class="span2">
                {{--  <input id="cep" type="text" class="form-input{{ $errors->has('cep') ? ' is-invalid' : '' }}"
                name="cep" --}}
                {{--  value="{{ $end1->endereco->sCep }}" readonly> --}}
                <input id="cep1" type="text" class="form-input"
                    name="cep1" value=""
                    readonly>
            </div>
            <div class="span2 align-left">
                @if($cep)
                @php
                $infoEndereco = true;
                @endphp
                &nbsp;
                &nbsp;
                &nbsp;
                <img src="{{ asset('img/icon-question.png') }}"
                    title="A informação alterada está em análise para aprovação/reprovação" />
                @endif
                <button type="button" class="btn e_wiggle align-right" id="buscaCep1" disabled>
                    {{ __('Buscar Cep') }}
                </button>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="uf1" class="col-md-4 col-form-label text-md-right">
                    {{ __('Estado') }}
                </label>
            </div>

            <div class="span7">
                <input id="ufDesc1" type="hidden" name="ufDesc1" value="">
                <input maxlength="2" id="ufCod1" type="hidden" name="ufCod1" value="">
                <select maxlength="2" id="uf1" class="form-input" name="uf1"
                    disabled>
                    @if (count($estados->oEstados) > 0)
                    @foreach ($estados->oEstados as $estado)
                    <option value="{{ $estado->codigo }}"
                        {{ $end1->endereco->iEstado == $estado->codigo  ? "selected" : "" }}>
                        {{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $estado->descricao))) }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="span1">
                @if($uf)
                @php
                $infoEndereco = true;
                @endphp
                <img src="{{ asset('img/icon-question.png') }}"
                    title="A informação alterada está em análise para aprovação/reprovação" />
                @endif
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="city1" class="col-md-4 col-form-label text-md-right">
                    {{ __('Município') }}
                </label>
            </div>

            <div class="span7">
                <input maxlength="40" id="city1" readonly type="text" name="city1" class="form-input"
                    value="{{ mb_convert_case(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $end1->endereco->sMunicipio))), MB_CASE_UPPER, 'UTF-8' ) }}"
                    readonly>
                <br>
            </div>
            <div class="span1">
                @if($municipio)
                @php
                $infoEndereco = true;
                @endphp
                <img src="{{ asset('img/icon-question.png') }}"
                    title="A informação alterada está em análise para aprovação/reprovação" />
                @endif
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="district1" class="col-md-4 col-form-label text-md-right">
                    {{ __('Bairro') }}
                </label>
            </div>

            <div class="span7">
                <input maxlength="40" id="district_11" readonly type="text" class="form-input" name="district1"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $end1->endereco->sBairro))) }}"
                    readonly>
                <select maxlength="40" id="district_01" name="district1" class="form-input" disabled>
                    @if (count($bairros->aBairrosEncontradas) > 0)
                    @foreach ($bairros->aBairrosEncontradas as $bairro)
                    <option value="{{ $bairro->iBairro }}|{{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $bairro->sDescricao))) }}">
                        {{ $end1->endereco->sBairro ==  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $bairro->sDescricao)))  ? "selected" : "" }}
                        {{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $bairro->sDescricao))) }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="span1">
                @if($bairroEnd == true)
                @php
                $infoEndereco = true;
                @endphp
                <img src="{{ asset('img/icon-question.png') }}"
                    title="A informação alterada está em análise para aprovação/reprovação" />
                @endif
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="address1" class="col-md-4 col-form-label text-md-right">
                    {{ __('Logradouro') }}
                </label>
            </div>

            <div class="span7">
                <input maxlength="100" id="address_11" readonly type="text"
                    class="form-input" name="address1"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $end1->endereco->sRua))) }}" readonly>

                <select id="address_01" name="address1" class="form-input" disabled>
                </select>
            </div>
            <div class="span1">
                @if($endereco)
                @php
                $infoEndereco = true;
                @endphp
                <img src="{{ asset('img/icon-question.png') }}"
                    title="A informação alterada está em análise para aprovação/reprovação" />
                @endif
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="number1" class="col-md-4 col-form-label text-md-right">
                    {{ __('Número') }}
                </label>
            </div>

            <div class="span1">
                <input maxlength="4" id="number1" type="text" class="form-input" name="number1"
                    value="{{ $end1->endereco->sNumeroLocal }}" readonly>
            </div>
            <div class="span1">
                @if($numero)
                @php
                $infoEndereco = true;
                @endphp
                <img src="{{ asset('img/icon-question.png') }}"
                    title="A informação alterada está em análise para aprovação/reprovação" />
                @endif
            </div>

            <div class="controls span2 form-label">
                <label for="complement1" class="col-md-4 col-form-label text-md-right">
                    {{ __('Complemento') }}
                </label>
            </div>

            <div class="span3">
                <input maxlength="100" id="complement1" type="text" class="form-input" name="complement1"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $end1->endereco->sComplemento))) }}"
                    readonly>
            </div>
            <div class="span1">
                @if($complemento)
                @php
                $infoEndereco = true;
                @endphp
                <img src="{{ asset('img/icon-question.png') }}"
                    title="A informação alterada está em análise para aprovação/reprovação" />
                @endif
            </div>
        </div>


        @isset($documentosPendentes)
            @foreach ($documentosPendentes as $documento)
                @if($documento["aba"] == "Endereço" )
                    <div class="alert alert-error" role="alert">
                        <p>
                            <strong>Atenção Documentos pendentes:</strong><br>
                            Para a análise da sua solicitação, é necessário que os seguintes documentos sejam enviados:<br>
                            Processo:<br>
                            @foreach ($documentosPendentes as $doc)
                                @if($doc["aba"] == "Endereço" )
                                    {{$doc["processo"]}} <br>
                                @endif
                            @endforeach
                            Documentos:<br> 
                            - Comprovante de Residência<br>
                            <br>
                            Para enviar os documentos, utiize a aba "<b>Documentos em Anexo</b>", informe no número do processo e faça o envio do documento.
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
                - Comprovante de Residência<br>
                <br>
                Para enviar os documentos, utiize a aba "<b>Documentos em Anexo</b>", informe no número do processo e faça o envio do documento.
            </div>
        @endif

        @isset($infoEndereco)
        @if($infoEndereco)
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

        @if(count($processos)>=$maxProcesso)
        <div class="alert" role="alert">
            <p>
                <strong>Atenção:</strong><br>
                Você possui diversos processos em análise, aguarde a conclusão destes para efetuar novas solicitações.<br>
            </p>
        </div>
        @endif


        <div class="row">
            <div class="span3 align-left">
                <button type="button" value='1' class="btn btn-theme e_wiggle align-right" id="btn_altera_endereco"
                {{count($processos)>=$maxProcesso?"disabled":""}}>
                    {{ __('Alterar Dados') }}
                </button>
            </div>
            <div class="span8 align-left">
                <button type="button" class="btn btn-warning e_wiggle align-right" id="btn_gravar_endereco" disabled>
                    {{ __('Gravar Dados') }}
                </button>
            </div>
        </div>
    </form>
</div>