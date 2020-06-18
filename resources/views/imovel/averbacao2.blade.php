<div class="container-fluid">
    <legend>
        <!-- <div class="row-fluid">
            <div class="span12">
                <label for="alteracao-polo" class="checkbox">
                    <input type="checkbox" id="alteracao-polo" name="alteracao-polo"> Averbação de imóveis com alteração de Polo Passivo
                </label>
            </div>
        </div> -->
        <div class="row-fluid">
            <!-- <div class="span4">
                <label for="anexo_itbi">Anexo de Comprovante de Pagamento ITBI <span>*</span></label>
                <input id="anexo_itbi" type="file" name="anexo_itbi" class="form-input">
                <div id="alert-comprovante-averbacao-success">
                    <div class="alert alert-success" role="alert">
                        <strong id="text-alert-comprovante-success"></strong>
                    </div>
                </div>
                <div id="alert-comprovante-averbacao-fail">
                    <div class="alert alert-danger" role="alert">
                        <strong id="text-alert-comprovante-fail"></strong>
                    </div>
                </div>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarComprovante" style="margin: 0; margin-top: 20px;">
                    {{ __('Lançar') }}
                </button>
            </div> -->
            <div class="span2">
                <label for="guiaItbi">Número da Guia ITBI <span>*</span></label>
                <input id="guiaItbi" type="text" class="form-input" name="guiaItbi" readonly>
            </div>
        </div>
    </legend>
    <div class="row-fluid">
        <div class="span2">
            <label for="cpf">CPF / CNPJ <span>*</span></label>
            <input id="cpf" type="text" name="cpf" class="form-input">
            <button type="button" class="btn e_wiggle" id="pesquisar-adquirente" disabled>
                Pesquisar
            </button>
            <div id="alert-doc-adquirente" class="controls span12">
            </div>
        </div>
        <div class="span10">
            <label for="nome_adquirente">Nome / Razão Social <span>*</span></label>
            <input id="nome_adquirente" type="text" name="nome_adquirente" class="form-input" readonly>
            <label for="adquirente_principal" id="label_adquirente_principal" name="label_adquirente_principal" class="checkbox">
                <input type="checkbox" id="adquirente_principal" name="adquirente_principal"> Adquirente principal?
            </label>
        </div>
    </div>
    <div id="dadosAdq">
        <div class="row-fluid">
            <div class="span3">
                <label for="telefone_adquirente">Telefone <span>*</span></label>
                <input id="telefone_adquirente" type="text" name="telefone_adquirente" class="form-input" readonly>
            </div>
            <div class="span3">
                <label for="celular_adquirente">Celular <span>*</span></label>
                <input id="celular_adquirente" type="text" name="celular_adquirente" class="form-input" readonly>
            </div>
            <div class="span3">
                <label for="cgm_adquirente">CGM</label>
                <input id="cgm_adquirente" type="text" name="cgm_adquirente" class="form-input" readonly>
            </div>
            <div class="span3">
                <label for="cep_adquirente">CEP <span>*</span></label>
                <input id="cep_adquirente" type="text" name="cep_adquirente" class="form-input" size="10" maxlength="9" onblur="pesquisaCep(this.value)" readonly>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <label for="endereco_adquirente">Endereço <span>*</span></label>
                <input id="endereco_adquirente" type="text" name="endereco_adquirente" class="form-input" readonly>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <label for="numero_adquirente">Número <span>*</span></label>
                <input id="numero_adquirente" type="text" name="numero_adquirente" class="form-input" readonly>
            </div>
            <div class="span10">
                <label for="complemento_adquirente">Complemento</label>
                <input id="complemento_adquirente" type="text" name="complemento_adquirente" class="form-input" readonly>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <label for="bairro_adquirente">Bairro <span>*</span></label>
                <input id="bairro_adquirente" type="text" name="bairro_adquirente" class="form-input" readonly>
            </div>
            <div class="span6">
                <label for="municipio_adquirente">Município <span>*</span></label>
                <input id="municipio_adquirente" type="text" name="municipio_adquirente" class="form-input" readonly>
            </div>
        </div>
    <div class="row-fluid">
        <div class="span3">
            <label for="estado_adquirente">Estado <span>*</span></label>
            <select name="estado_adquirente" id="estado_adquirente" disabled>
                <option value="">Selecione</option>
                @foreach ($estados as $estado)
                    <option value="{{$estado['key']}}">
                        {{$estado['value']}}
                    </option>
                @endforeach
            </select>


        </div>
        <div class="span9">
            <label for="email_adquirente">E-mail <span>*</span></label>
            <input id="email_adquirente" type="text" name="email_adquirente" class="form-input" readonly>
        </div>
    </div>
    </div>
    <div class="row-fluid">
        <div class="span9"></div>
        <div class="span3">
            <div id="box-adicionar-requerente">
                <button type="button" class="btn e_wiggle" id="adicionar-adquirente" disabled>
                    Adicionar dados na tabela <i class="icon-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="controls span2 form-label">
            <label for="cpf" class="col-md-4 col-form-label text-md-right">
                Adquirente(s)
            </label>
        </div>
        <div class="span10">
            <table id="tblAdquirente" class="display">
                <thead>
                    <tr>
                        <th>Nome / Razão Social</th>
                        <th>CPF / CNPJ</th>
                        <th>CGM</th>
                        <th>Principal</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="listaAdquirentes"></div>
    </div>
</div>
