<div class="container-fluid">
    <form method="POST" action="{{ route('averbacao_documentos') }}" id="formDocumentos" name="formDocumentos" enctype="multipart/form-data">
        @csrf
        <div class="row-fluid">
            <div class="span3 form-label">
                <label for="descricao" class="col-md-4 col-form-label text-md-right">
                    {{ __('Descrição') }}
                </label>
            </div>

            <div class="span4">
                <input id="outroAnexo" type="text" class="form-input" name="outroAnexo" maxlength="40" placeholder="Digite uma descrição...">
                <select id="descricao" class="form-input" name="descricao">
                    <option value="CPF">CPF</option>
                    <option value="Identidade">Identidade</option>
                    <option value="Comprovante de Residência">Comprovante de Residência</option>
                    <option value="Contrato Social">Contrato Social</option>
                    <option value="Imposto de Renda">Imposto de Renda</option>
                    <option value="RGI">RGI</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Documento') }}
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="MAX_FILE_SIZE" value="2048" />
                <input type="file" class="form-input" name="arquivo" id="arquivo" /><br>
                <div id="alert-anexo-averbacao-success">
                    <div class="alert alert-success" role="alert">
                        <strong id="text-alert-anexo-success"></strong>
                    </div>
                </div>
                <div id="alert-anexo-averbacao-fail">
                    <div class="alert alert-danger" role="alert">
                        <strong id="text-alert-anexo"></strong>
                    </div>
                </div>
                @if ($errors->has('arquivo'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('arquivo') }}</strong>
                    </span>
                @endif
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div id="listaAnexos"></div>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivo">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span6">
                <div class="alert alert-info docs">
                    <h4>Documentação Obrigatória</h4>
                    <p>a. Pessoa Física</p>
                    <ul>
                        <li>i. Identidade</li>
                        <li>ii.	CPF</li>
                        <li>iii. Comprovante de Residência</li>
                        <li>iv.	RGI</li>
                    </ul>
                    <p>b. Pessoa Jurídica</p>
                    <ul>
                        <li>i. Contrato Social</li>
                        <li>ii.	Identidade – Sócios</li>
                        <li>iii. CPF – Sócios</li>
                        <li>iv. Comprovante de Residência – Sócios</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <h4 class="heading">Documentos Lançados<span></span></h4>

                <table id="documentosLancados" class="display">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Nome Original</th>
                            <th>Nome Novo</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </form>
</div>
