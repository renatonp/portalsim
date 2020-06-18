<div class="accordion-inner">
    
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="name" class="col-md-4 col-form-label text-md-right">
            </label>
        </div>

        <div class="span8">
            <input type="checkbox" id="transacaoParcial" name="transacaoParcial" class="form-input" value=""> Transação Parcial
        </div>
    </div>
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="transacao" class="col-md-4 col-form-label text-md-right">
                {{ __('Tipo de Transação') }}
            </label>
        </div>

        <div class="span8">
            <select id="transacao" class="form-input" name="transacao">
                <option value=""></option>
                @isset($dadosTransacao)
                    <option value="À Vista" {{$dadosTransacao[0]->TIPO_TRANSACAO=="À Vista"?"selected":""}}>À Vista</option>
                    <option value="Isento - Imune" {{$dadosTransacao[0]->TIPO_TRANSACAO=="Isento - Imune"?"selected":""}}>Isento - Imune</option>
                    <option value="Parcelado"  {{$dadosTransacao[0]->TIPO_TRANSACAO=="Parcelado"?"selected":""}}>Parcelado</option>
                @else
                    <option value="À Vista">À Vista</option>
                    <option value="Isento - Imune">Isento - Imune</option>
                    <option value="Parcelado">Parcelado</option>
                @endisset
            </select>
        </div>
    </div>
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="natureza" class="col-md-4 col-form-label text-md-right">
                {{ __('Natureza') }}
            </label>
        </div>

        <div class="span8">
            <select id="natureza" class="form-input" name="natureza">
                <option value=""></option>
                @foreach ($transacoes->aListaItbiTransacao as $transacao)
                <option value="{{ $transacao->it01_tipotransacao ." - ". utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $transacao->it01_descr ))) }}"
                    @isset($dadosTransacao)
                    {{ ($dadosTransacao[0]->NAT_TRANSACAO == $transacao->it01_tipotransacao ." - ". utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $transacao->it01_descr ))))?"selected":""}}
                    @endisset
                    >
                    {{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $transacao->it01_descr ))) }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
     
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="valorDeclarado" class="col-md-4 col-form-label text-md-right">
                {{ __('Valor declarado da transação R$') }}
            </label>
        </div>

        <div class="span2">
            <input id="valorDeclarado" type="text" class="form-input" name="valorDeclarado" value="
            @isset($dadosTransacao[0]->VL_DECL_TRANSACAO)
                {{$dadosTransacao[0]->VL_DECL_TRANSACAO}}
            @endisset
            " >
        </div>
        {{-- Separação --}}
        <div class="controls span1 form-label">
            <label for="" class="col-md-4 col-form-label text-md-right">
                &nbsp;
            </label>
        </div>

        <div class="controls span3 form-label">
            <label for="percentualTransferido" class="col-md-4 col-form-label text-md-right">
                {{ __('Percentual a ser Transferido') }}
            </label>
        </div>

        <div class="span1">
            <input id="percentualTransferido" type="text" class="form-input" name="percentualTransferido" value="
            @isset($dadosTransacao[0]->PERCENT_TRANSF)
                {{($dadosTransacao[0]->PERCENT_TRANSF*1)}}
            @else
                100
            @endisset
            " readonly>
        </div>
        <div class="span1">
            <strong>%</strong>
        </div>
    </div>
     
    <h4 class="heading">Anexar Documentos<span></span></h4>
    <form method="POST" action="{{ route('itbi_documentos_transacao') }}" name="formDocumentosTransacao" id="formDocumentosTransacao" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="descricaoTransacao" class="col-md-4 col-form-label text-md-right">
                    {{ __('Descrição') }}
                </label>
            </div>

            <div class="span4">
                <input id="descricaoTransacao" type="text" class="form-input" name="descricaoTransacao" value="" maxlength="40">
                {{-- <select id="descricaoTransacao" class="form-input" name="descricaoTransacao">
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
                <input type="file" name="arquivo" id="fileTransacao" /><br>
                {{--  <input id="documento" type="text" class="form-input" name="documento" value="">  --}}
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoTransacao">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosTransacao" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th align="left">Descrição</th>
                        <th align="left">Documento Original</th>
                        <th align="left">Documento Final</th>
                        <th width='10%'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>


</div>