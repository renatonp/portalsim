<div class="accordion-inner">
    
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="adqCPF" class="col-md-4 col-form-label text-md-right">
                {{ __('CPF/CNPJ') }}
            </label>
        </div>

        <div class="span2">
            <input id="adqCPF" type="text" class="form-input" name="adqCPF" value="" >
        </div>
        <div class="span1">
            <button type="button" class="btn btn-theme e_wiggle" id="pesquisarAdquirente">
                {{ __('Pesquisar') }}
            </button>
        </div>
    </div>

    <section id="identificacao">
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="name" class="col-md-4 col-form-label text-md-right">
                </label>
            </div>
    
            <div class="span8">
                <input type="checkbox" id="adqPrincipal" name="adqPrincipal" class="form-input" value=""> Adquirente Principal
            </div>
        </div> 

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="adqNome" class="col-md-4 col-form-label text-md-right">
                    {{ __('Nome') }}
                </label>
            </div>

            <div class="span8">
                <input maxlength="40" id="adqNome" type="text" class="form-input" name="adqNome" value="" readonly>
            </div>
        </div>
        <section id="dadosAdq">
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="adqTel" class="col-md-4 col-form-label text-md-right">
                        {{ __('Telefone') }}
                    </label>
                </div>
        
                <div class="span2">
                    <input id="adqTel" type="text" class="form-input" name="adqTel" value="" readonly>
                </div>
                {{-- Separação --}}
                <div class="controls span1 form-label">
                    <label for="" class="col-md-4 col-form-label text-md-right">
                        &nbsp;
                    </label>
                </div>
        
                <div class="controls span1 form-label">
                    <label for="adqCel" class="col-md-4 col-form-label text-md-right">
                        {{ __('Celular') }}
                    </label>
                </div>
        
                <div class="span4">
                    <input id="adqCel" type="text" class="form-input" name="adqCel" value="" readonly>
                </div>
            </div>

            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="adqCGM" class="col-md-4 col-form-label text-md-right">
                        {{ __('CGM') }}
                    </label>
                </div>
        
                <div class="span2">
                    <input id="adqCGM" type="text" class="form-input" name="adqCGM" value="" readonly>
                </div>
                {{-- Separação --}}
                <div class="controls span1 form-label">
                    <label for="" class="col-md-4 col-form-label text-md-right">
                        &nbsp;
                    </label>
                </div>
        
                <div class="controls span1 form-label">
                    <label for="adqCEP" class="col-md-4 col-form-label text-md-right">
                        {{ __('CEP') }}
                    </label>
                </div>
        
                <div class="span2">
                    <input id="adqCEP" type="text" class="form-input" name="adqCEP" value="" readonly>
                </div>
                <div class="span2 text-left">
                    <button type="button" class="btn e_wiggle align-right" id="buscaCep" disabled>
                        {{ __('Buscar Cep') }}
                    </button>
                </div>
            </div>


            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="adqEndereco" class="col-md-4 col-form-label text-md-right">
                        {{ __('Endereço') }}
                    </label>
                </div>

                <div class="span8">
                    <input maxlength="100" id="adqEndereco" type="text" class="form-input" name="adqEndereco" value="" readonly>
                </div>
            </div>    
            
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="adqNum" class="col-md-4 col-form-label text-md-right">
                        {{ __('Número') }}
                    </label>
                </div>
        
                <div class="span2">
                    <input id="adqNum" type="text" class="form-input" name="adqNum" value="" readonly>
                </div>
                {{-- Separação --}}
                <div class="controls span1 form-label">
                    <label for="" class="col-md-4 col-form-label text-md-right">
                        &nbsp;
                    </label>
                </div>
        
                <div class="controls span2 form-label">
                    <label for="adqCompl" class="col-md-4 col-form-label text-md-right">
                        {{ __('Complemento') }}
                    </label>
                </div>
        
                <div class="span3">
                    <input maxlength="75" id="adqCompl" type="text" class="form-input" name="adqCompl" value="" readonly>
                </div>
            </div>
            
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="adqBairro" class="col-md-4 col-form-label text-md-right">
                        {{ __('Bairro') }}
                    </label>
                </div>
        
                <div class="span2">
                    <input maxlength="40" id="adqBairro" type="text" class="form-input" name="adqBairro" value="" readonly>
                </div>
                {{-- Separação --}}
                <div class="controls span1 form-label">
                    <label for="" class="col-md-4 col-form-label text-md-right">
                        &nbsp;
                    </label>
                </div>
        
                <div class="controls span2 form-label">
                    <label for="adqMunicipio" class="col-md-4 col-form-label text-md-right">
                        {{ __('Município') }}
                    </label>
                </div>
        
                <div class="span3">
                    <input maxlength="40" id="adqMunicipio" type="text" class="form-input" name="adqMunicipio" value="" readonly>
                </div>
            </div>
            
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="adqEstado" class="col-md-4 col-form-label text-md-right">
                        {{ __('Estado') }}
                    </label>
                </div>
        
                <div class="span2">
                    <input maxlength="2" id="adqEstado" type="text" class="form-input" name="adqEstado" value="" readonly>
                </div>
                {{-- Separação --}}
                <div class="controls span1 form-label">
                    <label for="" class="col-md-4 col-form-label text-md-right">
                        &nbsp;
                    </label>
                </div>
        
                <div class="controls span1 form-label">
                    <label for="adqEmail" class="col-md-4 col-form-label text-md-right">
                        {{ __('Email') }}
                    </label>
                </div>
        
                <div class="span4">
                    <input maxlength="100" id="adqEmail" type="text" class="form-input" name="adqEmail" value="" readonly>
                </div>
            </div>
        </section>
        <div class="row formrow">
            <div class="span3">
            </div>
            <div class="span11 text-right">
                <button type="button" class="btn btn-theme e_wiggle" id="incluirAdquirente" disabled>
                    {{ __('Incluir Adquirente') }}
                </button>
            </div>
        </div>
    </section>
<br>

    <h4>Adquirentes Cadastrados</h4>
    <div class="row formrow">
        <div class="span11">
                <table id="tbladquirentesDisplay" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th align="left">CPF/CNPJ</th>
                            <th align="left">Nome</th>
                            <th align="left">CGM</th>
                            <th align="left">Principal</th>
                            <th>&nbsp;&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <section id="tblfull" style="display: none;">
                    <table id="tbladquirentes" class="" style="width:100%;">
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
                                <th align="center">Principal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </section>
        </div>
    </div>

    <h4 class="heading">Anexar Documentos<span></span></h4>
    <form method="POST" action="{{ route('itbi_documentos_adquirente') }}" name= "formDocumentosAdquirente" id="formDocumentosAdquirente" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="descricaoAdquirente" class="col-md-4 col-form-label text-md-right">
                    {{ __('Descrição') }}
                </label>
            </div>

            <div class="span4">
                <select id="descricaoAdquirente" class="form-input" name="descricao">
                    <option value="CPF">CPF</option>
                    <option value="Identidade">Identidade</option>
                    <option value="Comprovante de Residência">Comprovante de Residência</option>
                    <option value="Contrato Social">Contrato Social</option>
                </select>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Documento') }}
                </label>
            </div>

            <div class="span6">
                <input type="file" name="arquivo" id="fileAdquirente" /><br>
                {{--  <input id="documento" type="text" class="form-input" name="documento" value="">  --}}
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoAdquirente">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosAdquirente" class="display" style="width:100%">
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
</div>