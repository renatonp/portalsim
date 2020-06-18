<div class="container-fluid">
    <!-- <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="inscricao" id="tituloPesquisa" class="col-md-4 col-form-label text-md-right">
                Imóvel
            </label>
        </div>

        <div class="span2">
            <input id="inscricao" type="text" name="inscricao" value="" class="form-input">
            <input id="guiaItbi" type="hidden" class="form-input" name="guiaItbi" value="" readonly>
            <input id="dataItbi" type="hidden" class="form-input" name="dataItbi" value="" readonly>
        </div>

        <div class="span2">
            <button type="button" class="btn e_wiggle" id="pesquisar">
                Pesquisar
            </button>
        </div>
    </div> -->

    @if (!count($pendencias))
    <div class="row-fluid">
        <div class="span3">
            <label for="inscricao" id="tituloPesquisa">
                Imóvel <span>*</span>
            </label>
            <input id="inscricao" type="text" name="inscricao" value="" class="form-input">
            <div id="alert-imovel-averbacao-fail">
                <div class="alert alert-danger" role="alert">
                    <strong id="text-alert-imovel-fail"></strong>
                </div>
            </div>
        </div>
        <div class="span2">
            <button type="button" class="btn e_wiggle" id="pesquisar" style="margin-top: 25px">
                Pesquisar
            </button>
        </div>
    </div>
    @endif

    @if (count($pendencias))
    <div class="row-fluid">
        <div class="span3">
            <label for="inscricao" id="tituloPesquisa">
                Imóvel <span>*</span>
            </label>
            <input id="inscricao" type="text" name="inscricao" value="{{$pendencias['MAT_IMOV_CARTORIO']}}" class="form-input" readonly>
            <div id="alert-imovel-averbacao-fail">
                <div class="alert alert-danger" role="alert">
                    <strong id="text-alert-imovel-fail"></strong>
                </div>
            </div>
        </div>
        <div class="span3">
            <input id="processo_pendencias" type="hidden" value="{{$pendencias['COD_PROCESSO']}}" class="form-input" name="processo_pendencias">
            <input id="etapa_pendencias" type="hidden" value="{{$pendencias['COD_ETAPA_ATUAL']}}" class="form-input" name="etapa_pendencias">
            <input id="ciclo_pendencias" type="hidden" value="{{$pendencias['COD_CICLO_ATUAL']}}" class="form-input" name="ciclo_pendencias">
            <label for="guia_pendencias">Nº Guia ITBI</label>
            <input id="guia_pendencias" type="text" value="{{$pendencias['NU_GUIA_ITBI']}}" class="form-input" name="guia_pendencias" readonly>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <label for="data_pendencias">Data Registro de Imóvel</label>
            <input id="data_pendencias" type="text" value="{{$pendencias['DT_REG_IMOVEL']}}" class="form-input" name="data_pendencias">
        </div>
        <div class="span3">
            <label for="imovel_pendencias">Nº Registro Geral Imóvel</label>
            <input id="imovel_pendencias" type="text" value="{{$pendencias['NU_REG_GERAL_IMOVEL']}}" class="form-input" name="imovel_pendencias" maxlength="20">
        </div>
        <div class="span3">
            <label for="protocolo_pendencias">Protocolo Registro Imóvel</label>
            <input id="protocolo_pendencias" type="text" value="{{$pendencias['PROT_REG_IMOVEL']}}" class="form-input" name="protocolo_pendencias" maxlength="20">
        </div>
    </div>
    @endif
   
    <div class="row-fluid">
        @if (!count($pendencias))
        <div class="span3">
            <label for="dataAverbacao">
                Data de Registro do Imóvel no Cartório <span>*</span>
            </label>
            <input id="dataAverbacao" type="text" class="form-input" name="dataAverbacao" readonly required>
            <input type="hidden" name="tipoSolicitacao" id="tipoSolicitacao" class="form-input" value="3">
        </div>
        <div class="span3">
            <label for="registro">
                Número do Registro <span>*</span>
            </label>
            <input id="registro" type="text" class="form-input" name="registro" maxlength="20" readonly required>
        </div>
        <div class="span3">
            <label for="protocolo">
                Protocolo Reg <span>*</span>
            </label>
            <input id="protocolo" type="text" class="form-input" name="protocolo" maxlength="20" readonly required>
        </div>
    </div>
    @endif
</div>
