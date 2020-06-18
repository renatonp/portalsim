<div class="accordion-inner">
    <input id="arquivosLista" type="hidden" name="arquivosLista" value="{{ old('arquivosLista') }}">
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="documento" class="col-md-4 col-form-label text-md-right">
            </label>
        </div>

        <div class="span8">
            <a href="{{  url('fileDownload/3') }}">
                <b>Verifique aqui as formas de comprovação de atividade econômicas</b>
            </a>
        </div>
        <br>
        <br>
        <br>
    </div>

    <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_cpf" name="pat_doc_cpf" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    CPF <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="CPF" />
                <input type="hidden" name="tipoDoc" value="CPF" />
                <input type="hidden" name="idCpf" id="idCpf" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCpf" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCpf">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_id" name="pat_doc_id" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    Identidade <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Identidade" />
                <input type="hidden" name="tipoDoc" value="IDENTIDADE" />
                <input type="hidden" name="idCpf" id="idId" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoId" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoId">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_cr1" name="pat_doc_cr1"  enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    Comprovante de Residência <span class="required">*</span><br>(Janeiro/2020)
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Comprovante de Residência (janeiro/2020)" />
                <input type="hidden" name="tipoDoc" value="CR_JANEIRO" />
                <input type="hidden" name="idCpf" id="idCr1" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCr1" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCr1">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_cr2" name="pat_doc_cr2"  enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    Comprovante de Residência <span class="required">*</span><br>(fevereiro/2020)
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Comprovante de Residência (fevereiro/2020)" />
                <input type="hidden" name="tipoDoc" value="CR_FEVEREIRO" />
                <input type="hidden" name="idCpf" id="idCr2" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCr2" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCr2">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_cr3" name="pat_doc_cr3"  enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    Comprovante de Residência <span class="required">*</span><br>(março/2020)
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Comprovante de Residência (março/2020)" />
                <input type="hidden" name="tipoDoc" value="CR_MARCO" />
                <input type="hidden" name="idCpf" id="idCr3" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCr3" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCr3">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_cat" name="pat_doc_cat"  enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    Comprovante  <span class="required">*</span><br>de Atividades de Trabalho
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Comprovante de Atividades de Trabalho" />
                <input type="hidden" name="tipoDoc" value="CA_TRABALHO" />
                <input type="hidden" name="idCpf" id="idCat" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCAT" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCat">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_cr" name="pat_doc_cr"  enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    Comprovante de Imposto de Renda <span class="required" id="exigeIR">*</span><br> ano base 2018 
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Comprovante de Imposto de Renda ano base 2018" />
                <input type="hidden" name="tipoDoc" value="C_RENDA" />
                <input type="hidden" name="idCpf" id="idCr" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCR" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCr">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>
    {{-- <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_ad" name="pat_doc_ad"  enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    Auto declaração <span class="required" id="exigeIR">*</span><br>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Auto declaração" />
                <input type="hidden" name="tipoDoc" value="AD" />
                <input type="hidden" name="idCpf" id="idad" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoAD" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoAd">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form> --}}
    {{-- <form method="POST" action="{{ route('pat_documentos') }}" id="pat_doc_cec" name="pat_doc_cec"  enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    Comprovante da Entidade de Classe <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="tipoDoc" value="CE_CLASSE" />
                <input type="hidden" name="idCpf" id="idCec" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCec" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCr">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form> --}}
    <div class="row formrow">
        <div class="controls span3 form-label">
        </div>

        <div class="span6">
            Obs.: O tamanho máximo dos arquivos é de 5Mb.
        </div>
    </div>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="patDocumentos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th align="left" width='10%'>Documento</th>
                        <th align="left">Nome Original</th>
                        <th align="left">Nome Final</th>
                        <th align="left" width='10%'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
    <br>
    <br>
</div>