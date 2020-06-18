<div class="accordion-inner">
    
    {{-- <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="name" class="col-md-4 col-form-label text-md-right">
                {{ __('Cidadão') }}
            </label>
        </div>

        <div class="span2">
            <input id="name" type="text" class="form-input" name="name" value="" >
        </div>
        <div class="span1">
            <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                {{ __('Pesquisar') }}
            </button>
        </div>
    </div> --}}
     
    
    <h4>Transmitentes Cadastrados</h4>
    <div class="row formrow">
        <div class="span11">
                <table id="tbltransmitentes" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th align="left">CPF/CNPJ</th>
                            <th align="left">Nome</th>
                            <th align="left">Telefone</th>
                            <th align="left">Celular</th>
                            <th align="left">CGM</th>
                            <th align="left">CEP</th>
                            <th align="left">Endereço</th>
                            <th align="left">Número</th>
                            <th align="left">Complemento</th>
                            <th align="left">Bairro</th>
                            <th align="left">Município</th>
                            <th align="left">Estado</th>
                            <th align="left">E-Mail</th>                            
                            <th>Principal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ Auth::user()->cpf }}</td>
                            <td>{{ Auth::user()->name }}</td>
                            <td>{{ $transmitentePrincipal->cgm->aCgmContato->z01_telef }}</td>
                            <td>{{ $transmitentePrincipal->cgm->aCgmContato->z01_telcel }}</td>
                            <td>{{ $transmitentePrincipal->cgm->cgm }}</td>
                            <td>{{ $transmitentePrincipal->endereco->endereco->iCep }}</td>
                            <td>{{ $transmitentePrincipal->endereco->endereco->sRua }}</td>
                            <td>{{ $transmitentePrincipal->endereco->endereco->sNumeroLocal }}</td>
                            <td>{{ $transmitentePrincipal->endereco->endereco->sComplemento }}</td>
                            <td>{{ $transmitentePrincipal->endereco->endereco->sBairro }}</td>
                            <td>{{ $transmitentePrincipal->endereco->endereco->sMunicipio }}</td>
                            <td>{{ $transmitentePrincipal->endereco->endereco->sEstado }}</td>
                            <td>{{ $transmitentePrincipal->cgm->aCgmContato->z01_email }}</td>
                            <td  align="center">SIM</td>
                        </tr>

                        {{-- @isset($dadosImovel2->aOutrosProprietariosEncontradas)
                        @foreach ($dadosImovel2->aOutrosProprietariosEncontradas as $proprietarios)
                        
                            <tr>
                                <td>{{ $proprietarios->s_cpfcnpj }}</td>
                                <td>{{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$proprietarios->s_nome))) }}</td>
                                <td  align="center">NÃO</td>
                            </tr>
                        @endforeach
                        @endisset --}}


                    </tbody>
                </table>
        </div>
    </div>
    
    <h4 class="heading">Anexar Documentos<span></span></h4>
    <form method="POST" action="{{ route('itbi_documentos_transmitente') }}" name="formDocumentosTransmitente" id="formDocumentosTransmitente" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="descricaoTransmitente" class="col-md-4 col-form-label text-md-right">
                    {{ __('Descrição') }}
                </label>
            </div>

            <div class="span4">
                <select id="descricaoTransmitente" class="form-input" name="descricao">
                    <option value="CPF">CPF</option>
                    <option value="Identidade">Identidade</option>
                    <option value="Comprovante de Residência">Comprovante de Residência</option>
                    <option value="Contrato Social">Contrato Social</option>
                </select>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documentoTransmitente" class="col-md-4 col-form-label text-md-right">
                    {{ __('Documento') }}
                </label>
            </div>

            <div class="span6">
                <input type="file" name="arquivo" id="fileTransmitente" /><br>
                {{--  <input id="documento" type="text" class="form-input" name="documento" value="">  --}}
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoTransmitente">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosTransmitente" class="display" style="width:100%">
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
