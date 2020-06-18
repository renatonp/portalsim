<div class="accordion-inner">
    {{-- Postergação do IPTU --}}

    {{-- @if(!$vencimentoIPTU == 0)
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="postergacao" class="col-md-4 col-form-label text-md-right">
                &nbsp;
            </label>
        </div>

        <div class="span3">
            <input type="checkbox" id="postergacao" name="postergacao" class="form-input"> Postergação do IPTU
        </div>
    </div> 
    <br>
    @endif --}}
    
    <section id="imoveisUsuario" style="display: block;">
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="matriculaImovel" class="col-md-4 col-form-label text-md-right">
                        {{ __('Matrícula do Imóvel') }}  
                        @if($vencimentoIPTU != 0)
                        <span class="required">*</span>
                        @endif
                </label>
            </div>

            <div class="span2">
                <input maxlength="6" id="matriculaImovel" type="text" class="form-input"  name="matriculaImovel" value="">
            </div>

        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="tipoVinculo" class="col-md-4 col-form-label text-md-right">
                    {{ __('Tipo de Vínculo') }} 
                    @if($vencimentoIPTU != 0)
                    <span class="required">*</span>
                    @endif 
                </label>
            </div>
    
            <div class="span3">
                <select id="tipoVinculo" class="form-input" name="tipoVinculo">
                    <option value=""></option>
                    <option value="Proprietário">Proprietário</option>
                    <option value="Possuidor">Possuidor</option>
                </select>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="tipoDocImovel" class="col-md-4 col-form-label text-md-right">
                    {{ __('Tipo de Documento') }} 
                    @if($vencimentoIPTU != 0)
                    <span class="required">*</span>
                    @endif
                </label>
            </div>
    
            <div class="span7">
                <select id="tipoDocImovel" class="form-input" name="tipoDocImovel">
                    <option value=""></option>
                    <option value="Contrato de compra e venda">Contrato de compra e venda</option>
                    <option value="Promessa de Compra e Venda">Promessa de Compra e Venda</option>
                    <option value="Escritura pública ou particular">Escritura pública ou particular</option>
                    <option value="Documento de doação">Documento de doação</option>
                    <option value="Conta de luz em nome do possuidor e com o endereço do imóvel em questão">Conta de luz em nome do possuidor e com o endereço do imóvel em questão</option>
                </select>
            </div>
        </div>
        
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
        </form>
        <form method="POST" action="" id="formVinculo" name="formVinculo" enctype="multipart/form-data">
            @csrf
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="documento" class="col-md-4 col-form-label text-md-right">
                        {{ __('Comprovante de Vínculo') }} 
                        @if($vencimentoIPTU != 0)
                        <span class="required">*</span>
                        @endif
                    </label>
                </div>

                <div class="span6">
                    <input type="hidden" name="DescrDoc" value="Comprovante de Vínculo" />
                    <input type="hidden" name="tipoDoc" value="ComprovanteVinculo" />
                    <input type="hidden" name="idCpf" id="idVinculo" value="{{ $cpf }}" />
                    <input type="file" name="arquivo" id="arquivoVinculo" /><br>
                    Obs.: O tamanho máximo dos arquivos é de 2Mb.
                </div>
                <div class="span2">
                    <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoVinculo">
                        {{ __('Lançar') }}
                    </button>
                </div>
            </div>
        </form>

        <div class="row formrow">
            <div class="span11">
                <h4 class="heading">Documentos Lançados<span></span></h4>

                <table id="documentosVinculo" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Tipo de Vínculo</th>
                            <th>Descrição</th>
                            <th>Nome Original</th>
                            <th>Nome Final</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </section>
    <br>
    <br>
</div>