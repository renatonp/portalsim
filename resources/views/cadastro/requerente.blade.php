<div class="accordion-inner">

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="respPreenchimento" class="col-md-4 col-form-label text-md-right">
                {{ __('Responsável pelo Preenchimento') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <select name="respPreenchimento" id="respPreenchimento" style="width:100%;" {{(strlen($cpf) > 14)?"disabled":""}}>
                <option value=""></option>
                <option value="1">Próprio</option>
                <option value="2" {{(strlen($cpf) > 14)?"selected":""}}>Responsável Legal</option>
            </select>
        </div> 
    </div>

<section id="responsavelLegal" style="display: {{(strlen($cpf) > 14)?"block;":"none;"}}">
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="nomeRespLegal" class="col-md-4 col-form-label text-md-right">
                    {{ __('Nome Completo') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="nomeRespLegal" type="text" class="form-input"  name="nomeRespLegal" value="">
        </div>
    </div>


    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="idRespLegal" class="col-md-4 col-form-label text-md-right">
                {{ __('Identidade') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input maxlength="20" id="idRespLegal" type="text" class="form-input" name="idRespLegal" value="">
        </div>

        {{-- Separação --}}
        <div class="controls span1 form-label">
            <label for="" class="col-md-4 col-form-label text-md-right">
                &nbsp;
            </label>
        </div>

        <div class="controls span2 form-label">
            <label for="orgEmRespLegal" class="col-md-4 col-form-label text-md-right">
                {{ __('Órgão Emissor') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input maxlength="50" id="orgEmRespLegal" type="text" class="form-input" name="orgEmRespLegal" value="">
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="dtEmissRespLegal" class="col-md-4 col-form-label text-md-right">
                {{ __('Data Emissão') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input id="dtEmissRespLegal" type="text" class="form-input" name="dtEmissRespLegal" value="">
        </div>

        {{-- Separação --}}
        <div class="controls span1 form-label">
            <label for="" class="col-md-4 col-form-label text-md-right">
                &nbsp;
            </label>
        </div>

        <div class="controls span2 form-label">
            <label for="cpfRespLegal" class="col-md-4 col-form-label text-md-right">
                {{ __('CPF') }} <span class="required">*</span>
            </label>
        </div>
        <div class="span2">
            <input maxlength="20" id="cpfRespLegal" type="text" class="form-input" name="cpfRespLegal" value="">
        </div>        
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="emailRespLegal" class="col-md-4 col-form-label text-md-right">
                {{ __('Email') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input id="emailRespLegal" type="text" class="form-input" name="emailRespLegal" value="">
        </div>
    </div>

        <form method="POST">
            @csrf
        </form>
        <form method="POST" action="" id="cad_doc_req" name="cad_doc_req" enctype="multipart/form-data">
            @csrf
            <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Anexar Representação Legal') }} <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Representação Legal" />
                <input type="hidden" name="tipoDoc" value="Representacao_Legal" />
                <input type="hidden" name="idCpf" id="idCpf" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCpfReq" /><br>
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCpfReq">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosLancadosReq" class="display" style="width:100%">
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
    <br>
    <br>











</section>



</div>
