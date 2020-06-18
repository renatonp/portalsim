<div class="alert alert-info">
    <div class="row">
        <div class="col-lg-12 mb-3">
            <h4>Documentação Obrigatória</h4>
        </div>

        <div class="col-lg-6">
            <h6>Pessoa Física:</h6>
            <ul>
                <li>i. Identidade</li>
                <li>ii. CPF</li>
                <li>iii. Comprovante de Residência:</li>
                <li>iv. RGI</li>
            </ul>
        </div>

        <div class="col-lg-6">
            <h6>Pessoa Jurídica:</h6>
            <ul>
                <li>i. Contrato Social</li>
                <li>ii. Identidade – Sócios</li>
                <li>iii. CPF – Sócios:</li>
                <li>iv. Comprovante de Residência – Sócios</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 form-group">
        <label for="descricao">Descrição:</label>
        <select name="descricao" id="descricao" class="form-control form-control-sm">
            <option>CPF</option>
            <option>Identidade</option>
            <option>Comprovante de Residência</option>
            <option>Contrato Social</option>
            <option>Imposto de Renda</option>
            <option>RGI</option>
            <option>Outros</option>
        </select>
    </div>

    <div class="col-lg-4 form-group">
        <label for="arquivo">Documento:</label>
        <input type="file" name="arquivo" id="arquivo" />
    </div>

    <div class="col-lg-12">
        <button class="btn btn-primary btn-sm w-100"><i class="fa fa-save"></i> Salvar Documento</button>
    </div>
</div>

<hr />

<div class="row col-lg-12 mb-3 mt-3">
    <h5><i class="fa fa-file-o"></i> Documentos Enviados:</h5>
</div>

<div class="callout-red">
    <div class="row">
        <div class="col-lg-4">
            <p>
                <b>Descrição: </b>
            </p>
        </div>

        <div class="col-lg-4">
            <p>
                <b>Nome Original: </b>
            </p>
        </div>

        <div class="col-lg-4">
            <p>
                <b>Nome Novo: </b>
            </p>
        </div>

        <div class="col-lg-12">
            <button class="btn btn-outline-danger btn-sm w-100">
                <i class="fa fa-trash"></i> Excluir Documento
            </button>
        </div>
    </div>
</div>