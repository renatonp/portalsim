<div class="accordion-inner">
    <form method="POST" action="{{ route('itbi_lancar') }}" name="formITBI" id="formITBI">
        @csrf
        @isset($edicao)
            <input type="hidden" id="edicao" name="edicao" value="{{$edicao}}">
        @else
            <input type="hidden" id="edicao" name="edicao" value="">
        @endisset
        @isset($dadosTransacao)
            <input type="hidden" id="processo" name="processo" value="{{$dadosTransacao[0]->COD_PROCESSO}}">
            <input type="hidden" id="etapa" name="etapa" value="{{$dadosTransacao[0]->COD_ETAPA_ATUAL}}">
            <input type="hidden" id="ciclo" name="ciclo" value="{{$dadosTransacao[0]->COD_CICLO_ATUAL}}">
        @else
            <input type="hidden" id="processo" name="processo" value="">
            <input type="hidden" id="etapa" name="etapa" value="">
            <input type="hidden" id="ciclo" name="ciclo" value="">            
        @endisset
        <input type="hidden" id="adquirentes" name="adquirentes" value="">
        <input type="hidden" id="documentosAdquirentes" name="documentosAdquirentes" value="">
        <input type="hidden" id="transmitentes" name="transmitentes" value="">
        <input type="hidden" id="documentostransmitentes" name="documentostransmitentes" value="">
        <input type="hidden" id="txtdocumentosimovel" name="txtdocumentosimovel" value="">
        <input type="hidden" id="txtdocumentosTransacao" name="txtdocumentosTransacao" value="">

        <input type="hidden" id="cadtransacao" name="cadtransacao" value="">
        <input type="hidden" id="cadnatureza" name="cadnatureza" value="">
        <input type="hidden" id="cadnumGuia" name="cadnumGuia" value="">
        <input type="hidden" id="cadpercentualTransferido" name="cadpercentualTransferido" value="">
        <input type="hidden" id="cadvalorDeclarado" name="cadvalorDeclarado" value="">
        <input type="hidden" id="cadvalorFinanciado" name="cadvalorFinanciado" value="">
        <input type="hidden" id="cadobservacoes" name="cadobservacoes" value="">
        <input type="hidden" id="cadtransacaoParcial" name="cadtransacaoParcial" value="">

        <input type="hidden" id="it01_mail" name="it01_mail" value="
        @isset($dadosImovel->oDadosLocalInserir->it01_mail)
        {{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel->oDadosLocalInserir->it01_mail ))) }}
        @endisset
        ">
        <input type="hidden" id="it01_obs" name="it01_obs" value="@isset($dadosImovel->oDadosLocalInserir->it01_obs){{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel->oDadosLocalInserir->it01_obs ))) }}@endisset
        ">
        
        <input type="hidden" id="it01_valortransacao" name="it01_valortransacao" value="@isset($dadosImovel->oDadosTrasacaoInserir->it01_valortransacao){{  $dadosImovel->oDadosTrasacaoInserir->it01_valortransacao }}@endisset">

        <input type="hidden" id="it01_valorterreno" name="it01_valorterreno" value="@isset($dadosImovel->oDadosTrasacaoInserir->it01_valorterreno){{ $dadosImovel->oDadosTrasacaoInserir->it01_valorterreno }}@endisset">
        <input type="hidden" id="it01_valorconstr" name="it01_valorconstr" value="@isset($dadosImovel->oDadosTrasacaoInserir->it01_valorconstr){{  $dadosImovel->oDadosTrasacaoInserir->it01_valorconstr }}@endisset">
        <input type="hidden" id="it29_setorloc" name="it29_setorloc" value="@isset($dadosImovel->oDadosRegistroImovelInserir->it29_setorloc){{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel->oDadosRegistroImovelInserir->it29_setorloc ))) }}@endisset">
        

        <input type="hidden" id="numero" name="numero" value="
        @isset($dadosImovel->oDadosLocalInserir->it22_numero)
        {{  $dadosImovel->oDadosLocalInserir->it22_numero }}
        @endisset
        ">
        <input type="hidden" id="rua" name="rua" value="
        @isset($dadosImovel->oDadosLocalInserir->it22_descrlograd)
        {{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel->oDadosLocalInserir->it22_descrlograd ))) }}
        @endisset
        ">
        <input type="hidden" id="complemento" name="complemento" value="
        @isset($dadosImovel->oDadosLocalInserir->it22_compl)
        {{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel->oDadosLocalInserir->it22_compl ))) }}
        @endisset
        ">

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="name" class="col-md-4 col-form-label text-md-right">
                    {{ __('Nome') }}
                </label>
            </div>

            <div class="span8">
                <input id="name" type="text" class="form-input" name="name"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',  Auth::user()->name )))  }}"
                    readonly>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="tipo" class="col-md-4 col-form-label text-md-right">
                    {{ __('Tipo de Imóvel') }}
                </label>
            </div>

            <div class="span2">
                <input id="tipo" type="text" class="form-input" name="tipo" value="@isset($dadosImovel2->s_situacao){{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel2->s_situacao ))) }}@endisset" readonly>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span2 form-label">
                <label for="caracteristica" class="col-md-4 col-form-label text-md-right">
                    {{ __('Característica do Imóvel') }}
                </label>
            </div>

            <div class="span3">
                <input id="caracteristica" type="text" class="form-input" name="caracteristica" value="@isset($dadosImovel2->s_tipo){{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel2->s_tipo ))) }}@endisset
                " readonly>
            </div>
        </div>
        @isset($pendencias->bDebitoimovel)
        <input type="hidden" id="debito" name="debito" value="{{$pendencias->bDebitoimovel?'SIM':'NÃO'}}">
        @if($pendencias->bDebitoimovel)
        <h4>Débitos</h4>
        <div class="row formrow">
            <div class="controls span3 form-label">
            </div>
            <div class="controls span6">
                <p><strong>Atenção:</strong> o imóvel possui débitos.</p>
                <ul>
                    <li>{{ $pendencias->aDebito->sTipoDebitoDesc }} </li>
                </ul>
            </div>
        </div>
        @endif
        @endisset
        <h4>Localização</h4>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                    {{ __('Matrícula') }}
                </label>
            </div>

            <div class="span2">
                <input id="matricula2" type="text" class="form-input" name="matricula2" value="@isset( $dadosImovel->aLocalMostra[0]->i_matricula){{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',  $dadosImovel->aLocalMostra[0]->i_matricula ))) }}@endisset" readonly>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span2 form-label">
                <label for="situacao" class="col-md-4 col-form-label text-md-right">
                    {{ __('Situação') }}
                </label>
            </div>

            <div class="span3">
                @php
                    $situacao = "";   
                @endphp
                @isset($dadosImovel2->aCaracteristicasEncontradas)
                @foreach ($dadosImovel2->aCaracteristicasEncontradas as $caracteristica)
                    @if($caracteristica->i_caract == "42")
                        @php
                            $descrArr = explode("-" , $caracteristica->s_descri);
                            $situacao = $descrArr[1];
                        @endphp
                        @break
                    @endif
                @endforeach
                @endisset
                <input id="situacao" type="text" class="form-input" name="situacao" value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$situacao))) }}" readonly>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="pql" class="col-md-4 col-form-label text-md-right">
                    {{ __('Planta / Quadra / Lote') }}
                </label>
            </div>

            <div class="span8">
                <input id="pql" type="text" class="form-input" name="pql"
                    value="@isset( $dadosImovel->aLocalMostra[0]->s_planta){{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel->aLocalMostra[0]->s_planta ))) }}@endisset" readonly>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="imovelendereco" class="col-md-4 col-form-label text-md-right">
                    {{ __('Endereço') }}
                </label>
            </div>

            <div class="span8">
                <input id="imovelendereco" type="text" class="form-input" name="imovelendereco"
                    value="@isset( $dadosImovel->aLocalMostra[0]->s_logradouro){{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $dadosImovel->aLocalMostra[0]->s_logradouro ))) }}@endisset" readonly>
            </div>
           
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="bairro" class="col-md-4 col-form-label text-md-right">
                    {{ __('Bairro') }}
                </label>
            </div>

            <div class="span4">
                <input id="bairro" type="text" class="form-input" name="bairro" value=" {{utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$dadosImovel2->s_bairro)))}} " readonly>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span1 form-label">
                <label for="imovelCep" class="col-md-4 col-form-label text-md-right">
                    CEP
                </label>
            </div>

            <div class="span2">
                <input id="imovelCep" type="text" class="form-input" readonly name="imovelCep" value="{{utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$dadosImovel2->s_cep)))}}" >
            </div>            
        </div>

        <h4>Medidas</h4>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="areaTotal" class="col-md-4 col-form-label text-md-right">
                    {{ __('Área Total') }}
                </label>
            </div>
            <div class="span1">
                <input id="areaTotal" type="text" class="form-input" name="areaTotal" value="{{ $dadosImovel->oDadosMedidasInserir->it01_areaterreno }}" readonly>
            </div>
            <div class="span1">
                <strong>m<sup>2</sup></strong>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                    <label for="" class="col-md-4 col-form-label text-md-right">
                        &nbsp;
                    </label>
                </div>
    
                <div class="controls span2 form-label">
                    <label for="areaConstruida" class="col-md-4 col-form-label text-md-right">
                        {{ __('Área Construida') }}
                    </label>
                </div>
    
                <div class="span1">
                    <input id="areaConstruida" type="text" class="form-input" name="areaConstruida" value="{{ $dadosImovel2->i_area_const }}" readonly>
                </div>
                <div class="span1">
                    <strong>m<sup>2</sup></strong>
                </div>
        </div>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="percentual" class="col-md-4 col-form-label text-md-right">
                    {{ __('Percentual de Área Transmitida') }}
                </label>
            </div>
            <div class="span1">
                <input id="percentual" type="text" class="form-input" name="percentual" value="{{ $dadosImovel->oDadosMedidasInserir->it01_percentualareatransmitida }}" readonly>
            </div>
            <div class="span1">
                    <strong>%</strong>
                </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span2 form-label">
                <label for="areaTransmitida" class="col-md-4 col-form-label text-md-right">
                    {{ __('Área Transmitida') }}
                </label>
            </div>

            <div class="span1">
                <input id="areaTransmitida" type="text" class="form-input" name="areaTransmitida" value="{{ $dadosImovel->oDadosMedidasInserir->it01_areatrans }}" readonly>
            </div>
            <div class="span1">
                <strong>m<sup>2</sup></strong>
            </div>
        </div>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="frente" class="col-md-4 col-form-label text-md-right">
                    {{ __('Frente') }}
                </label>
            </div>
            <div class="span1">
                <input id="frente" type="text" class="form-input" name="frente" value="{{ $dadosImovel->oDadosMedidasInserir->it05_frente }}" readonly>
            </div>
            <div class="span1">
                <strong>m</strong>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span2 form-label">
                <label for="fundos" class="col-md-4 col-form-label text-md-right">
                    {{ __('Fundos') }}
                </label>
            </div>

            <div class="span1">
                <input id="fundos" type="text" class="form-input" name="fundos" value="{{ $dadosImovel->oDadosMedidasInserir->it05_fundos }}" readonly>
            </div>
            <div class="span1">
                <strong>m</strong>
            </div>
        </div>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="ladoDireito" class="col-md-4 col-form-label text-md-right">
                    {{ __('Lado Direito') }}
                </label>
            </div>
            <div class="span1">
                <input id="ladoDireito" type="text" class="form-input" name="ladoDireito" value="{{ $dadosImovel->oDadosMedidasInserir->it05_direito }}" readonly>
            </div>
            <div class="span1">
                <strong>m</strong>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span2 form-label">
                <label for="ladoEsquerdo" class="col-md-4 col-form-label text-md-right">
                    {{ __('Lado Esquerdo') }}
                </label>
            </div>

            <div class="span1">
                <input id="ladoEsquerdo" type="text" class="form-input" name="ladoEsquerdo" value="{{ $dadosImovel->oDadosMedidasInserir->it05_esquerdo }}" readonly>
            </div>
            <div class="span1">
                <strong>m</strong>
            </div>
        </div>

        <h4>Registro do Imóvel</h4>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                    {{ __('Matrícula') }}
                </label>
            </div>
            <div class="span1">
                <input id="matricula" type="text" class="form-input" name="matricula" value="{{ $dadosImovel->oDadosLocalInserir->j01_matric }}" readonly>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span3 form-label">
                <label for="setor" class="col-md-4 col-form-label text-md-right">
                    {{ __('Setor') }}
                </label>
            </div>

            <div class="span3">
                <input id="setor" type="text" class="form-input" name="setor" value="{{$dadosImovel->oDadosLocalInserir->it22_setor}}" readonly>
            </div>
        </div>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="quadra" class="col-md-4 col-form-label text-md-right">
                    {{ __('Quadra') }}
                </label>
            </div>
            <div class="span1">
                <input id="quadra" type="text" class="form-input" name="quadra" value="{{$dadosImovel->oDadosLocalInserir->it22_quadra}}" readonly>
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span3 form-label">
                <label for="lote" class="col-md-4 col-form-label text-md-right">
                    {{ __('Lote') }}
                </label>
            </div>

            <div class="span2">
                <input id="lote" type="text" class="form-input" name="lote" value="{{$dadosImovel->oDadosLocalInserir->it22_lote}}" readonly>
            </div>
        </div>
    </form>
    @if(!$edicao)
    <h4 class="heading">Anexar Documentos<span></span></h4>
    <form method="POST" action="{{ route('itbi_documentos_imovel') }}" name= "formDocumentosimovel" id="formDocumentosimovel" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="descricaoImovel" class="col-md-4 col-form-label text-md-right">
                    {{ __('Descrição') }}
                </label>
            </div>

            <div class="span4">
                <input id="descricaoImovel" type="text" class="form-input" name="descricao" value="" maxlength="40">
                {{-- <select id="descricaoImovel" class="form-input" name="descricao">
                    <option value="CPF">CPF</option>
                    <option value="Identidade">Identidade</option>
                    <option value="Comprovante de Residência">Comprovante de Residência</option>
                    <option value="Contrato Social">Contrato Social</option>
                </select> --}}
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Documento') }}
                </label>
            </div>

            <div class="span6">
                <input type="file" name="arquivo" id="fileImovel" /><br>
                {{--  <input id="documento" type="text" class="form-input" name="documento" value="">  --}}
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoImovel">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosImovel" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th align="left">Descrição</th>
                        <th align="left">Documento Original</th>
                        <th align="left">Documento Final</th>
                        <th width='10%'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @isset($arquivos)
                    @foreach ($arquivos as $documento)
                    <tr>
                        <td>{{ $documento->descricao }} </td>
                        <td>{{ $documento->nome_documento }}</td>
                        <td align="right">
                            <a href="{{ url('cgm_documentos_excluir/' . $documento->id) }}">
                                <button type="button" class="btn btn-small btn-danger e_wiggle">
                                    {{ __('Excluir') }}
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endisset --}}
                </tbody>
            </table>

        </div>
    </div>
    @endif
    <br>
    <br>
</div>