<div class="form-row">
    <div class="col-lg-2 form-group">
        <label for="numero_guia_itbi">Número da Guia ITBI:</label>
        <input type="text" name="numero_guia_itbi" id="numero_guia_itbi" class="form-control form-control-sm" />
    </div>

    <div class="col-lg-4 form-group">
        <label for="documento">CPF/CNPJ:</label>
        <div class="input-group">
            <input type="text" name="documento" class="form-control form-control-sm" id="documento">
            <div class="input-group-append">
                <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Pesquisar</button>
            </div>
        </div>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-lg-6 mt-3">
        <h5><i class="fa fa-user"></i> Dados Adquirente:</h5>

        <div class="form-row mt-4">
            <div class="col-lg-12 form-group">
                <label for="razao_social">Nome/Razão Social:</label>
                <input type="text" name="razao_social" id="razao_social" class="form-control form-control-sm" />
            </div>
        </div>

        <div class="form-row">
            <div class="col-lg-4 form-group">
                <label for="cgm">CGM:</label>
                <input type="text" name="cgm" id="cgm" class="form-control form-control-sm" />
            </div>

            <div class="col-lg-4 form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" class="form-control form-control-sm" />
            </div>

            <div class="col-lg-4 form-group">
                <label for="celular">Celular:</label>
                <input type="text" name="celular" id="celular" class="form-control form-control-sm" />
            </div>
        </div>

        <div class="form-row">
            <div class="col-lg-8 form-group">
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" class="form-control form-control-sm" />
            </div>
        </div>
    </div>

    <div class="col-lg-6 mt-3">
        <h5><i class="fa fa-map-marker"></i> Endereço Adquirente:</h5>

        <div class="form-row mt-4">
            <div class="col-lg-4 form-group">
                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" class="form-control form-control-sm" />
            </div>
        
            <div class="col-lg-8 form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" id="endereco" class="form-control form-control-sm" />
            </div>
        </div>

        <div class="form-row">
            <div class="col-lg-2 form-group">
                <label for="numero">Número:</label>
                <input type="text" name="numero" id="numero" class="form-control form-control-sm" />
            </div>
        
            <div class="col-lg-6 form-group">
                <label for="complemento">Complemento:</label>
                <input type="text" name="complemento" id="complemento" class="form-control form-control-sm" />
            </div>
        
            <div class="col-lg-4 form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="form-control form-control-sm" />
            </div>
        </div>

        <div class="form-row">
            <div class="col-lg-4 form-group">
                <label for="municipio">Município:</label>
                <input type="text" name="municipio" id="municipio" class="form-control form-control-sm" />
            </div>
        
            <div class="col-lg-2 form-group">
                <label for="estado">Estado:</label>
                <select name="estado" id="estado" class="form-control form-control-sm">
                    <option></option>
                </select>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-primary btn-sm w-100"><i class="fa fa-save"></i> Salvar Adquirente</button>

<hr />

<div class="row col-lg-12 mb-3">
    <h5><i class="fa fa-users"></i> Adquirente(s) Salvo(s):</h5>
</div>

<div class="callout-red">
    <div class="row">
        <div class="col-lg-6">
            <p>
                <b>Nome/Razão Social: </b> Fernando da Silva Pereira
            </p>
        </div>
        
        <div class="col-lg-6">
            <p>
                <b>CPF/CNPJ: </b> 
            </p>
        </div>

        <div class="col-lg-6">
            <p>
                <b>CGM: </b> 
            </p>
        </div>

        <div class="col-lg-6">
            <p>
                <b>Principal: </b> 
            </p>
        </div>
        
        <div class="col-lg-12">
            <button class="btn btn-outline-danger btn-sm w-100">
                <i class="fa fa-trash"></i> Excluir Adquirente
            </button>
        </div>
    </div>
</div>
