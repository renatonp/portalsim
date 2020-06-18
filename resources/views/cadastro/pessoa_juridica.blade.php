<div class="accordion-inner">
    {{-- CPF/CNPJ --}}
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="cpf" class="col-md-4 col-form-label text-md-right">
                {{ __('CNPJ') }} 
            </label>
        </div>
        <div class="span2">
            <input maxlength="20" id="cpfPJ" type="text" class="form-input" name="cpf" value="{{$cpf}}" readonly>
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="razaoSocial" class="col-md-4 col-form-label text-md-right">
                    {{ __('Razão Social') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="razaoSocial" type="text" class="form-input"  name="razaoSocial" value="">
        </div>
    </div>
    
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="nomeFantasia" class="col-md-4 col-form-label text-md-right">
                    {{ __('Nome Fantasia') }}
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="nomeFantasia" type="text" class="form-input"  name="nomeFantasia" value="">
        </div>
    </div>
    
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="NatJur" class="col-md-4 col-form-label text-md-right">
                {{ __('Natureza Jurídica') }}
            </label>
        </div>

        <div class="span7">
            <input maxlength="40" id="NatJur" type="text" class="form-input" name="NatJur" value="">

        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="dtAbertura" class="col-md-4 col-form-label text-md-right">
                {{ __('Data de Abertura') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input id="dtAbertura" type="text" class="form-input" name="dtAbertura" value="">
        </div>
        {{-- Separação --}}

        <div class="controls span2 form-label">
            <label for="inscrEstadual" class="col-md-4 col-form-label text-md-right">
                {{ __('Inscrição Estadual') }} 
            </label>
        </div>
    
        <div class="span3">
            <input maxlength="8" id="inscrEstadual" type="text" class="form-input"  name="inscrEstadual" value="">
        </div>
    </div>



    <form method="POST" action="" enctype="multipart/form-data">
        @csrf
    </form>

    <form method="POST" action="" id="formCSocial" name="formCSocial" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Contrato Social') }} <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Contrato Social" />
                <input type="hidden" name="tipoDoc" value="ContratoSocial" />
                <input type="hidden" name="idCpf" id="idCSocial" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCSocial" />
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCSocial">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>


    <form method="POST" action="" id="formRGSocio" name="formRGSocio" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Documento de Identidade do Sócio') }} <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Documento de Identidade do Sócio" />
                <input type="hidden" name="tipoDoc" value="RGSocio" />
                <input type="hidden" name="idCpf" id="idRGSocio" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoRGSocio" />
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoRGSocio">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <form method="POST" action="" id="formCPFSocio" name="formCPFSocio" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('CPF do Sócio') }}  <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="CPF do Sócio" />
                <input type="hidden" name="tipoDoc" value="CPFSocio" />
                <input type="hidden" name="idCpf" id="idCPFSocio" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCPFSocio" /><br>
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCPFSocio">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosPJTbl" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th width='20%'>Descrição</th>
                        <th>Nome Original</th>
                        <th>Nome Final</th>
                        <th width='20%'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>



</div>
